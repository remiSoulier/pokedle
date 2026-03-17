<?php

use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\GameController;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    if (session()->has('joueur_id')) {
        return redirect('/games');
    }
    return view('welcome');
});

Route::get('/login', [ConnexionController::class, 'afficherVueConnexion']);

Route::post('/login', [ConnexionController::class, 'connecter']);

Route::get('/register', [ConnexionController::class, 'afficherVueCreationCompte']);

Route::post('/register', [ConnexionController::class, 'createAcount']);

Route::get('/logout', [ConnexionController::class, 'deconnecter']);

Route::get('/games', [GameController::class, 'afficherVueParties']);

Route::get('/play', [GameController::class, 'afficherVueSelection']);

Route::post('/play', [GameController::class, 'redirigerVersJeu']);

Route::get('/reprendre/{id}', [GameController::class, 'notImplemented']);

Route::get('/play/classic/', [GameController::class, 'startClassicGame']);

Route::post('/play/classic', [GameController::class, 'tentativeClassicGame']);

Route::get('/play/emoji', [GameController::class, 'notImplemented']);

Route::get('/play/description', [GameController::class, 'notImplemented']);

Route::get('/play/whosthat', [GameController::class, 'notImplemented']);

Route::post('/reset', [GameController::class, 'reset']);

Route::get('/win', [GameController::class, 'partieGagnee']);

Route::get('/pokemon-search', function (Illuminate\Http\Request $request) {

    $query = $request->q;

    return \App\Models\Pokemon::where('name', 'like', $query.'%')
        ->limit(10)
        ->pluck('name');

});
