@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

    <div class="flex min-h-[75vh] items-center justify-center px-4">
        <div class="max-w-2xl text-center">

            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                Bienvenue sur <span class="text-blue-600">Pokedle</span> !
            </h1>

            <p class="mt-6 text-lg text-gray-600">
                Devinez le Pokémon mystère avec le moins d'essais possible.
                Analysez les indices, comparez les types, et devenez un véritable Maître Pokémon.
            </p>

            <div class="mt-10 flex flex-col items-center gap-4 sm:flex-row sm:justify-center">

                <a href="/login"
                   class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:-translate-y-1 hover:bg-gray-800">
                    Se connecter
                </a>

                <a href="/play"
                   class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm transition hover:-translate-y-1 hover:bg-gray-50">
                    Jouer en tant qu'invité
                </a>

            </div>

        </div>
    </div>

@endsection
