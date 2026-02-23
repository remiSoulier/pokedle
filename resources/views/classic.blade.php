@extends('layouts.app')

@section('title', 'Play')

@section('content')

    <div style="text-align: center; margin-top: 50px;">
        <h1>Devinez le Pokémon mystère !</h1>
    </div>

    <div>
        @if(!session('joueur_id'))
            <p style="text-align: center; color: red;">Vous jouez en tant qu'invité. Vos résultats ne seront pas sauvegardés.</p>
        @else
            <p style="text-align: center; color: green;">Vous jouez en tant que {{ session('username') }}. Vos résultats seront sauvegardés.</p>
            <button onclick="window.location.href='/logout'"
                    style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">
                Se déconnecter
            </button>
        @endif
    </div>

    <form action="/play/classic" method="POST">
        @csrf
        <label for="input">Pokemon:</label>
        <input type="text" id="input" name="input">
        <button type="submit">Submit</button>
    </form>

    <table>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Type 1</th>
            <th>Type 2</th>
            <th>generation</th>
            <th>stade d'évolution</th>
            <th>evolution complete</th>
            <th>taille</th>
            <th>poids</th>
        </tr>

        @foreach($pokemons as $poke)
            @php($p = $poke['pokemon'] ?? null)
            @if($p)
                <tr>
                    <td>
                        <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-16 h-16 object-cover rounded-full">
                    </td>
                    <td style="background-color: {{ $poke['results']['name'] ?? 'transparent' }}">{{ $p->name }}</td>
                    <td style="background-color: {{ $poke['results']['type1'] ?? 'transparent' }}">{{ $p->type1 }}</td>
                    <td style="background-color: {{ $poke['results']['type2'] ?? 'transparent' }}">{{ $p->type2 ?? '-' }}</td>
                    <td style="background-color: {{ $poke['results']['generation'] ?? 'transparent' }}">{{ $p->generation }}</td>
                    <td style="background-color: {{ $poke['results']['evolution_stage'] ?? 'transparent' }}">{{ $p->evolution_stage }}</td>
                    <td style="background-color: {{ $poke['results']['is_fully_evolved'] ?? 'transparent' }}">{{ $p->is_fully_evolved ? 'Oui' : 'Non' }}</td>
                    <td style="background-color: {{ $poke['results']['height'] ?? 'transparent' }}">{{ $p->height }}{{ $poke['results']['hint_height'] ?? '' }}</td>
                    <td style="background-color: {{ $poke['results']['weight'] ?? 'transparent' }}">{{ $p->weight }}{{ $poke['results']['hint_weight'] ?? '' }}</td>
                </tr>
            @endif
        @endforeach
    </table>

    <form action="/reset" method="post">
        @csrf
        <button type="submit">Reset</button>
    </form>

@endsection
