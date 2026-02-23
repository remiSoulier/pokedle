@extends('layouts.app')

@section('title', 'Login')

@section('content')
<h1>
    Félicitations, vous avez gagné en {{ $nbEssais }} essai{{ $nbEssais > 1 ? 's' : '' }}
</h1>
<h2>
    Le Pokémon mystère était {{ $pokemon->name }} !
</h2>
<img src="{{ $pokemon->image_url }}" alt="{{ $pokemon->name }}" style="width: 200px; height: auto;">

<form action="/reset" method="post">
    @csrf
    <button type="submit">Rejouer</button>
</form>
@endsection
