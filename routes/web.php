<?php

use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\PlayerController;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    if (session()->has('joueur_id')) {
        return redirect('/play');
    }
    return view('login');
});

Route::post('/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    return (new ConnexionController)->connecter($username, $password);
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');
    $password2 = $request->input('password_confirmation');

    if ($password !== $password2) {
        return redirect('/register')->with('error', 'Les mots de passe ne correspondent pas.');
    }

    return (new ConnexionController)->createAcount($username, $password);
});

Route::get('/logout', function () {
    return (new ConnexionController)->deconnecter();
});

Route::get('/play', function () {
    return view('play');

});

Route::get('/play/classic', function () {
    $generations = [2];
    $pokemon = Pokemon::getRandomPokemon($generations);
    var_dump($pokemon);

    session()->put('pokemonCible', $pokemon);
    //(new PlayerController)->enregisterPartie('classique', $pokemon->id, 0, 'en cours');

    $pokemons = session()->get('pokemons', []);
    return view('classic', compact('pokemons'));
});

Route::post('/play/classic', function (Request $request) {
    $input = trim((string) $request->input('input', ''));
    // Liste actuelle stockée en session
    $pokemons = session()->get('pokemons', []);

    // Pokémon cible en session (à créer dans le GET si absent)
    $pokemonCible = session()->get('pokemonCible');
    //(new PlayerController)->updatePartie(session()->get('partie_id'), count($pokemons), 'en cours');

    if (!$pokemonCible) {
        return redirect('/play/classic')->with('error', "Pas de Pokémon cible en session.");
    }

    // Recherche (premier match)
    $pokemon = Pokemon::where('name', 'like', "%{$input}%")->first();

    if (!isset($pokemon)) {
        return view('classic',compact('pokemons'));
    }

    if ($pokemon->id === $pokemonCible->id) {
        return redirect('/win');
    }



    // ✅ éviter les doublons : comparer par ID
    $alreadyGuessed = collect($pokemons)->contains(function ($p) use ($pokemon) {
        return isset($p['pokemon']) && $p['pokemon'] && isset($p['pokemon']->id) && $p['pokemon']->id === $pokemon->id;
    });

    if (!$alreadyGuessed) {

        // --- Résultats couleurs ---

        $resName = $pokemon->name === $pokemonCible->name ? 'green' : 'red';

        // Types : green si même emplacement, orange si présent mais pas au même emplacement
        $resType1 = ($pokemon->type1 === $pokemonCible->type1)
            ? 'green'
            : (($pokemon->type1 !== null && in_array($pokemon->type1, [$pokemonCible->type1, $pokemonCible->type2], true)) ? 'orange' : 'red');

        $resType2 = ($pokemon->type2 === $pokemonCible->type2)
            ? 'green'
            : (($pokemon->type2 !== null && in_array($pokemon->type2, [$pokemonCible->type1, $pokemonCible->type2], true)) ? 'orange' : 'red');

        $resGeneration = $pokemon->generation === $pokemonCible->generation ? 'green' : 'red';
        $resEvolutionStage = $pokemon->evolution_stage === $pokemonCible->evolution_stage ? 'green' : 'red';
        $resIsFullyEvolved = $pokemon->is_fully_evolved === $pokemonCible->is_fully_evolved ? 'green' : 'red';

        // Taille/poids : si tu veux plus tard ajouter ↑ ↓, on peut.
        $resHeight = ((float)$pokemon->height === (float)$pokemonCible->height) ? 'green' : 'red';
        $hintHeight = null;
        if ($resHeight === 'red') {
            $hintHeight = ((float)$pokemon->height < (float)$pokemonCible->height) ? '↑' : '↓';
        }
        $resWeight = ((float)$pokemon->weight === (float)$pokemonCible->weight) ? 'green' : 'red';
        $hintWeight = null;
        if ($resWeight === 'red') {
            $hintWeight = ((float)$pokemon->weight < (float)$pokemonCible->weight) ? '↑' : '↓';
        }

        $pokemons[] = [
            'pokemon' => $pokemon,
            'results' => [
                'name' => $resName,
                'type1' => $resType1,
                'type2' => $resType2,
                'generation' => $resGeneration,
                'evolution_stage' => $resEvolutionStage,
                'is_fully_evolved' => $resIsFullyEvolved,
                'height' => $resHeight,
                'hint_height' => $hintHeight,
                'weight' => $resWeight,
                'hint_weight' => $hintWeight,
            ]
        ];
    }

    session()->put('pokemons', $pokemons);
    $pokemons = array_reverse($pokemons); // pour afficher le plus récent en haut

    return view('classic', compact('pokemons'));
});

Route::get('/play/emoji', function () {
    return view('notImplemented');
});

Route::get('/play/description', function () {
    return view('notImplemented');
});

Route::get('/play/whosthat', function () {
    return view('notImplemented');
});

Route::post('/reset', function () {
    //(new PlayerController)->updatePartie(session()->get('partie_id'), count(session()->get('pokemons', [])), 'perdu');
    session()->forget('pokemons');
    return redirect('/play');
});

Route::get('/win', function () {
    $nbEssais = count(session()->get('pokemons', []));
    $pokemon = session()->get('pokemonCible');
    //(new PlayerController)->updatePartie(session()->get('partie_id'), $nbEssais, 'gagné');

    session()->forget('pokemons');
    return view('win',compact('nbEssais', 'pokemon'));
});
