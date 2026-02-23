@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div style="text-align: center; margin-top: 50px;">
        <h1>Bienvenue sur Pokedle !</h1>
        <p>Devinez le Pokémon mystère avec le moins d'essais possible !</p>
        <button onclick="window.location.href='/login'" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">Se connecter</button>
        <a href="/play" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Jouer en tant qu'invité</a>
    </div>

@endsection
