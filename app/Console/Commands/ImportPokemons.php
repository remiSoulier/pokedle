<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;

class ImportPokemons extends Command
{
    protected $signature = 'pokemons:import';
    protected $description = 'Import all pokemons from PokeAPI (species only, no forms)';

    public function handle()
    {
        $this->info('Starting import (species only)...');

        // Optionnel : protéger un minimum contre les erreurs réseau / rate-limit
        $client = Http::timeout(20)->retry(2, 200);

        $response = $client->get('https://pokeapi.co/api/v2/pokemon-species', [
            'limit' => 2000,
        ]);

        if (!$response->ok()) {
            $this->error('Failed to fetch species list.');
            return Command::FAILURE;
        }

        $speciesList = $response->json('results', []);

        foreach ($speciesList as $speciesData) {
            $speciesResponse = $client->get($speciesData['url']);
            if (!$speciesResponse->ok()) {
                continue;
            }

            $species = $speciesResponse->json();

            // Nom "API" (EN) => sert de clé fiable + sert à matcher la chaîne d'évolution
            $speciesApiName = strtolower($species['name'] ?? '');
            if ($speciesApiName === '') {
                $this->warn('Skip (no api name)');
                continue;
            }

            // Nom FR (affichage / stockage si tu veux)
            $speciesFrName = $this->getFrenchName($species) ?? $speciesApiName;

            // Génération: generation-i / generation-iii ... => 1..9
            $generation = $this->parseGeneration($species['generation']['name'] ?? null);

            // Récupération du Pokémon par défaut (variety is_default)
            $varieties = $species['varieties'] ?? [];
            $defaultPokemonUrl = null;

            foreach ($varieties as $variety) {
                if (!empty($variety['is_default'])) {
                    $defaultPokemonUrl = $variety['pokemon']['url'] ?? null;
                    break;
                }
            }

            if (!$defaultPokemonUrl) {
                $this->warn('Skip (no default variety): ' . $speciesApiName);
                continue;
            }

            $pokemonResponse = $client->get($defaultPokemonUrl);
            if (!$pokemonResponse->ok()) {
                $this->warn('Skip (default pokemon fetch failed): ' . $speciesApiName);
                continue;
            }

            $pokemon = $pokemonResponse->json();

            // Evolution chain (peut manquer)
            $stage = 1;
            $isFullyEvolved = true;

            $evoUrl = $species['evolution_chain']['url'] ?? null;
            if ($evoUrl) {
                $evolutionResponse = $client->get($evoUrl);
                if ($evolutionResponse->ok()) {
                    $evolutionChain = $evolutionResponse->json();
                    if (!empty($evolutionChain['chain'])) {
                        // IMPORTANT: on cherche avec le NOM API (EN), pas le FR
                        [$foundStage, $foundFully] = $this->getEvolutionData($speciesApiName, $evolutionChain['chain']);
                        if ($foundStage !== null) {
                            $stage = $foundStage;
                            $isFullyEvolved = $foundFully;
                        }
                    }
                }
            }

            // Types
            $type1 = $pokemon['types'][0]['type']['name'] ?? null;
            $type2 = $pokemon['types'][1]['type']['name'] ?? null;

            if (!$type1) {
                $this->warn('Skip (no type): ' . $speciesApiName);
                continue;
            }

            // Taille/poids : API en dm / hg => m / kg
            $height = isset($pokemon['height']) ? ($pokemon['height'] / 10) : 0;
            $weight = isset($pokemon['weight']) ? ($pokemon['weight'] / 10) : 0;

            // Image : front_default
            $imageUrl = $pokemon['sprites']['front_default'] ?? null;

            // Fallback sprite github par id si dispo
            if (!$imageUrl && !empty($pokemon['id'])) {
                $imageUrl = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/' . $pokemon['id'] . '.png';
            }

            /**
             * RECO : upsert sur une clé stable.
             * Idéal : ajouter une colonne `api_name` UNIQUE dans ta table pokemons.
             *
             * Exemple si tu as `api_name`:
             * Pokemon::updateOrCreate(['api_name' => $speciesApiName], [...]);
             *
             * Si tu ne l'as pas, tu peux garder name=FR, mais attention : les accents / traductions peuvent changer.
             */
            Pokemon::updateOrCreate(
                ['name' => $speciesFrName],
                [
                    // 'api_name' => $speciesApiName, // <-- décommente si tu ajoutes la colonne
                    'type1' => $type1,
                    'type2' => $type2,
                    'generation' => $generation,
                    'evolution_stage' => $stage,
                    'is_fully_evolved' => $isFullyEvolved,
                    'height' => $height,
                    'weight' => $weight,
                    'image_url' => $imageUrl,
                ]
            );

            $this->info("Imported: {$speciesFrName} ({$speciesApiName}) - stage {$stage}");
        }

        $this->info('Import finished.');
        return Command::SUCCESS;
    }

    /**
     * generation-i / generation-ii / generation-iii ... => 1..9
     */
    private function parseGeneration(?string $generationName): int
    {
        if (!$generationName) {
            return 0;
        }

        $parts = explode('-', $generationName);
        $roman = end($parts);

        $map = [
            'i' => 1,
            'ii' => 2,
            'iii' => 3,
            'iv' => 4,
            'v' => 5,
            'vi' => 6,
            'vii' => 7,
            'viii' => 8,
            'ix' => 9,
        ];

        return $map[$roman] ?? 0;
    }

    private function getFrenchName(array $species): ?string
    {
        foreach (($species['names'] ?? []) as $nameEntry) {
            if (($nameEntry['language']['name'] ?? null) === 'fr') {
                // Je laisse en lower si c'est ton choix, mais tu peux aussi garder la casse/accents.
                return strtolower($nameEntry['name']);
            }
        }

        return isset($species['name']) ? strtolower($species['name']) : null;
    }

    /**
     * Renvoie [stage, isFullyEvolved] ou [null, false] si non trouvé.
     * IMPORTANT: $targetName doit être le species name API (EN), ex: "ivysaur"
     */
    private function getEvolutionData(string $targetName, array $chain, int $stage = 1): array
    {
        $nodeName = strtolower($chain['species']['name'] ?? '');

        if ($nodeName === $targetName) {
            $isFullyEvolved = empty($chain['evolves_to']);
            return [$stage, $isFullyEvolved];
        }

        foreach (($chain['evolves_to'] ?? []) as $next) {
            [$foundStage, $foundFully] = $this->getEvolutionData($targetName, $next, $stage + 1);
            if ($foundStage !== null) {
                return [$foundStage, $foundFully];
            }
        }

        return [null, false];
    }
}
