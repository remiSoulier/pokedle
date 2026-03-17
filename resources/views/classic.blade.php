@extends('layouts.app')

@section('title', 'Play')

@section('content')

    <div class="space-y-8">

        {{-- Header --}}
        <div class="text-center">
            <h1 class="text-3xl font-bold tracking-tight">Devinez le Pokémon mystère !</h1>
            <p class="mt-2 text-sm text-gray-600">Les couleurs t’aident à te rapprocher de la bonne réponse.</p>
        </div>

        {{-- Status joueur --}}
        @if(!session('joueur_id'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-center text-sm text-red-700">
                Vous jouez en tant qu'invité. Vos résultats ne seront pas sauvegardés.
            </div>
        @else
            <div class="flex flex-col gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-center text-sm text-green-700 sm:text-left">
                    Vous jouez en tant que <span class="font-semibold">{{ session('username') }}</span>. Vos résultats seront sauvegardés.
                </p>

                <button
                    type="button"
                    onclick="window.location.href='/logout'"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 active:bg-blue-800"
                >
                    Se déconnecter
                </button>
            </div>
        @endif

        {{-- Zone de jeu --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <form action="/play/classic" method="POST" class="w-full sm:max-w-xl">
                    @csrf

                    <label for="pokemon-input" class="block text-sm font-medium text-gray-700">
                        Pokémon
                    </label>

                    <div class="relative mt-1">
                        <input
                            type="text"
                            id="pokemon-input"
                            name="input"
                            autocomplete="off"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            placeholder="ex: pikachu"
                        >

                        <div
                            id="suggestions"
                            class="absolute z-10 mt-1 hidden w-full overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg"
                        ></div>
                    </div>

                    <div class="mt-3 flex flex-col gap-3 sm:flex-row">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-gray-800 active:bg-black"
                        >
                            Valider
                        </button>

                        <a
                            href="/"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50"
                        >
                            Retour accueil
                        </a>
                    </div>
                </form>

                {{-- Reset séparé (pas imbriqué) --}}
                <form action="/reset" method="post" class="sm:self-start">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50"
                    >
                        Reset
                    </button>
                </form>
            </div>

            {{-- Petite légende "Wordle-like" --}}
            <div class="mt-6 flex flex-wrap items-center gap-3 text-xs text-gray-600">
            <span class="inline-flex items-center gap-2">
                <span class="h-3 w-3 rounded-sm bg-green-400"></span> bon
            </span>
                <span class="inline-flex items-center gap-2">
                <span class="h-3 w-3 rounded-sm bg-yellow-300"></span> proche
            </span>
                <span class="inline-flex items-center gap-2">
                <span class="h-3 w-3 rounded-sm bg-gray-200"></span> faux
            </span>
                <span class="text-gray-400">(tes couleurs actuelles viennent de `results[...]`)</span>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3">Nom</th>
                    <th class="px-4 py-3">Type 1</th>
                    <th class="px-4 py-3">Type 2</th>
                    <th class="px-4 py-3">Génération</th>
                    <th class="px-4 py-3">Évolution</th>
                    <th class="px-4 py-3">Complète</th>
                    <th class="px-4 py-3">Taille</th>
                    <th class="px-4 py-3">Poids</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($pokemons as $poke)
                    @php($p = $poke['pokemon'] ?? null)
                    @if($p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <img src="{{ $p->image_url }}"
                                     alt="{{ $p->name }}"
                                     class="h-12 w-12 rounded-full object-cover ring-1 ring-gray-200">
                            </td>

                            {{-- On garde le background inline car dynamique --}}
                            <td class="px-4 py-3 font-medium" style="background-color: {{ $poke['results']['name'] ?? 'transparent' }}">
                                {{ $p->name }}
                            </td>

                            <td class="px-4 py-3" style="background-color: {{ $poke['results']['type1'] ?? 'transparent' }}">
                                {{ $p->type1 }}
                            </td>

                            <td class="px-4 py-3" style="background-color: {{ $poke['results']['type2'] ?? 'transparent' }}">
                                {{ $p->type2 ?? '-' }}
                            </td>

                            <td class="px-4 py-3" style="background-color: {{ $poke['results']['generation'] ?? 'transparent' }}">
                                {{ $p->generation }}
                            </td>

                            <td class="px-4 py-3" style="background-color: {{ $poke['results']['evolution_stage'] ?? 'transparent' }}">
                                {{ $p->evolution_stage }}
                            </td>

                            <td class="px-4 py-3" style="background-color: {{ $poke['results']['is_fully_evolved'] ?? 'transparent' }}">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                {{ $p->is_fully_evolved ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800' }}">
                                {{ $p->is_fully_evolved ? 'Oui' : 'Non' }}
                            </span>
                            </td>

                            <td class="px-4 py-3" style="background-color: {{ $poke['results']['height'] ?? 'transparent' }}">
                                {{ $p->height }}{{ $poke['results']['hint_height'] ?? '' }}
                            </td>

                            <td class="px-4 py-3" style="background-color: {{ $poke['results']['weight'] ?? 'transparent' }}">
                                {{ $p->weight }}{{ $poke['results']['hint_weight'] ?? '' }}
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-10 text-center text-sm text-gray-500">
                            Aucun essai pour le moment. Commence à taper un Pokémon 👆
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection
