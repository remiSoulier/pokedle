@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div>
    <h1>Jeux disponibles</h1>
    <ul>
        <li><a href="/play/classic">Classique</a></li>
        <li><a href="/play/emoji">Emoji</a></li>
        <li><a href="/play/description">Description</a></li>
        <li><a href="/play/whosthat">Who's that Pokémon ?</a></li>
    </ul>
</div>
@endsection
