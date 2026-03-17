<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function afficherVueSelection()
    {
        return view('play');
    }

    public function redirigerVersJeu()
    {
        //var_dump($_POST);
        $gen = request()->input('generations');
        session()->put('generations', $gen);
        $typePartie = request()->input('mode');
        return match ($typePartie) {
            'classic' => redirect('/play/classic'),
            'emoji' => redirect('/play/emoji'),
            default => redirect('/play')->with('error', 'Mode de jeu invalide.'),
        };
    }

    public function afficherVueParties()
    {
        $parties = $this->getParties();


        return view('games', compact('parties'));

    }

    public function reset()
    {
        $this->updatePartie(session()->get('partie_id'), count(session()->get('pokemons', [])), 'lost');
        session()->forget(['pokemonCible', 'pokemons', 'statusPartie']);
        return redirect('/play');
    }

    public function startClassicGame()
    {
        $gen = session()->get('generations');
        $pokemonCible = \App\Models\Pokemon::getRandomPokemon($gen);
        if (session()->has('joueur_id')) {
            $this->enregisterPartie('classic', $pokemonCible->id, 0, 'in_progress');
        }
        session()->put('pokemonCible', $pokemonCible);
        session()->put('pokemons', []);
        session()->put('statusPartie', 'en cours');
        $pokemons = session()->get('pokemons', []);
        var_dump(session()->get('partie_id'));
        var_dump($pokemonCible->name);
        return view('classic', compact('pokemons'));
    }

    public function tentativeClassicGame()
    {
        $input = trim((string) request()->input('input', ''));

        $pokemons = session()->get('pokemons', []);

        $pokemonCible = session()->get('pokemonCible');
        //var_dump($pokemonCible);
        //(new GameController)->updatePartie(session()->get('partie_id'), count($pokemons), 'en cours');

        if (!$pokemonCible) {
            return redirect('/play/classic')->with('error', "Pas de Pokémon cible en session.");
        }

        $pokemon = Pokemon::where('name', 'like', "%{$input}%")->first();

        if (!isset($pokemon)) {
            var_dump($pokemonCible->name);
            return view('classic',compact('pokemons'));
        }

        if ($pokemon->id === $pokemonCible->id) {
            return redirect('/win');
        }



        $alreadyGuessed = collect($pokemons)->contains(function ($p) use ($pokemon) {
            return isset($p['pokemon']) && $p['pokemon'] && isset($p['pokemon']->id) && $p['pokemon']->id === $pokemon->id;
        });

        if (!$alreadyGuessed) {

            $result = Pokemon::comparer($pokemon, $pokemonCible);

            $pokemons[] = ['pokemon' => $pokemon, 'results' => $result];

        }

        $this->updatePartie(session()->get('partie_id'), count($pokemons), 'in_progress');
        session()->put('pokemons', $pokemons);
        $pokemons = array_reverse($pokemons); // pour afficher le plus récent en haut

        var_dump($pokemonCible->name);
        return view('classic', compact('pokemons'));
    }

    public function partieGagnee()
    {
        $nbEssais = count(session()->get('pokemons', []));
        $pokemon = session()->get('pokemonCible');
        $this->updatePartie(session()->get('partie_id'), $nbEssais, 'won');


        session()->forget('pokemons');
        return view('win',compact('nbEssais', 'pokemon'));
    }

    public function enregisterPartie(string $typePartie, int $pokemonId, int $nbEssais, string $status)
    {
            $joueurId = session()->get('joueur_id');

            if (!$joueurId) {
                return response()->json(['error' => 'Utilisateur non connecté'], 401);
            }

            $partie = new \App\Models\Partie();
            $partie->joueur_id = $joueurId;
            $partie->type_partie = $typePartie;
            $partie->reponse_pokemon_id = $pokemonId;
            $partie->nb_essais = $nbEssais;
            $partie->status = $status;
            $partie->save();
            session()->put('partie_id', $partie->id);
            session()->put('statusPartie', $status);
            return response()->json(['message' => 'Partie enregistrée avec succès']);

    }

    public function updatePartie(int $partieId, int $nbEssais, string $status)
    {
        $joueurId = session()->get('joueur_id');

        if (!$joueurId) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $partie = \App\Models\Partie::where('id', $partieId)->where('joueur_id', $joueurId)->first();

        if (!$partie) {
            return response()->json(['error' => 'Partie non trouvée'], 404);
        }

        $partie->nb_essais = $nbEssais;
        if (!($status === 'gagné' || $status === 'perdu')) {
            $partie->status = $status;
            session()->put('statusPartie', $status);
        } else {
            session()->put('statusPartie', 'terminé');
        }
        $partie->save();


        return response()->json(['message' => 'Partie mise à jour avec succès']);
    }

    public function getParties()
    {
        $joueurId = session()->get('joueur_id');

        if (!$joueurId) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $parties = \App\Models\Partie::where('joueur_id', $joueurId)->with('reponsePokemon')->get();

        $res = [];
        foreach ($parties as $partie) {
            $pokemon = Pokemon::find($partie->reponse_pokemon_id);
            $pokemonName = $pokemon ? $pokemon->name : 'Inconnu';
            if ($partie->status === 'won' || $partie->status === 'lost') {
                $pokemonImage = $pokemon ? $pokemon->image_url : null;
            } else {
                $pokemonImage = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/0.png';
            }

            $res[] = [
                'id' => $partie->id,
                'type_partie' => $partie->type_partie,
                'id_pokemon_reponse' => $partie->reponse_pokemon_id,
                'pokemon_name' => $pokemonName,
                'pokemon_image' => $pokemonImage,
                'nb_essais' => $partie->nb_essais,
                'status' => $partie->status,
            ];
        }

        return $res;

    }


    public function notImplemented()
    {
        return view('notImplemented');
    }
}
