@extends('layouts.app')

@section('title', 'Parties enregistrées')

@section('content')

        <div class="max-w-3xl mx-auto p-6">

            <button
                onclick="window.location.href='/play'"
                class="mb-6 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                <span>Nouvelle partie</span>
            </button>

            <button
                onclick="window.location.href='/logout'"
                class="mb-6 inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            >
                <span>Déconnexion</span>
            </button>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-semibold text-gray-800">Parties enregistrées</h2>

                <div class="mt-6 space-y-4">
                    @if(empty($parties))
                        <p class="text-gray-600">Aucune partie enregistrée pour le moment.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($parties as $partie)

                                @php
                                    $colorClass = match($partie['status']) {
                                        'won' => 'bg-green-100 border-green-400',
                                        'lost' => 'bg-red-100 border-red-400',
                                        'in_progress' => 'bg-yellow-100 border-yellow-400',
                                        default => 'bg-gray-100 border-gray-300'
                                    };
                                @endphp

                                <li class="flex items-center gap-4 rounded-md border p-4 hover:bg-gray-50 {{ $colorClass }}">

                                    <div class="flex-1">

                                        <p class="text-sm text-gray-700">
                                            Type : {{ $partie['type_partie'] }}
                                        </p>

                                        <p class="text-sm text-gray-700">
                                            Nombre d'essais : {{ $partie['nb_essais'] }}
                                        </p>

                                        <p class="text-sm text-gray-700 flex items-center gap-2">
                                            Pokémon mystère :
                                            <img src="{{ $partie['pokemon_image'] }}" class="w-10 h-10">
                                        </p>

                                        <p class="text-sm text-gray-700">
                                            Statut : {{ $partie['status'] === 'won' ? 'Gagné' : ($partie['status'] === 'lost' ? 'Perdu' : 'En cours') }}
                                        </p>

                                        @if($partie['status'] === 'in_progress')
                                            <button
                                                onclick="window.location.href='/reprendre/{{ $partie['id'] }}'"
                                                class="mt-2 inline-flex items-center gap-2 rounded-lg bg-green-600 px-3 py-1 text-sm font-semibold text-white shadow hover:bg-green-700"
                                            >
                                                Reprendre
                                            </button>
                                        @endif

                                    </div>
                                </li>

                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
@endsection
