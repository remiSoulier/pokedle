<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
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

        return response()->json($parties);
    }
}
