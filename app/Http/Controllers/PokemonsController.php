<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;

class PokemonsController extends Controller
{

    public function majListe(Pokemon $pokemon, $pokemons)
    {
        if ($pokemon&& !in_array($pokemon, $pokemons)) {

            $pokemons[] = $pokemon;
        }


    }
}
