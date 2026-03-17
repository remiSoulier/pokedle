@extends('layouts.app')

@section('title', 'Modes de jeu')

@section('content')

    <form action="/play" method="POST" class="space-y-4">
        @csrf

        <div class="max-w-3xl mx-auto p-6">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-semibold text-gray-800">Choisissez votre mode de jeu</h2>

                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-3">Choix des générations</h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <label for="gen1" class="flex items-center gap-3 cursor-pointer rounded-md p-2 hover:bg-gray-50">
                            <input type="checkbox" id="gen1" name="generations[]" value="1" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Génération 1 (Kanto)</span>
                        </label>

                        <label for="gen2" class="flex items-center gap-3 cursor-pointer rounded-md p-2 hover:bg-gray-50">
                            <input type="checkbox" id="gen2" name="generations[]" value="2" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Génération 2 (Johto)</span>
                        </label>

                        <label for="gen3" class="flex items-center gap-3 cursor-pointer rounded-md p-2 hover:bg-gray-50">
                            <input type="checkbox" id="gen3" name="generations[]" value="3" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Génération 3 (Hoenn)</span>
                        </label>

                        <label for="gen4" class="flex items-center gap-3 cursor-pointer rounded-md p-2 hover:bg-gray-50">
                            <input type="checkbox" id="gen4" name="generations[]" value="4" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Génération 4 (Sinnoh)</span>
                        </label>

                        <label for="gen5" class="flex items-center gap-3 cursor-pointer rounded-md p-2 hover:bg-gray-50">
                            <input type="checkbox" id="gen5" name="generations[]" value="5" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Génération 5 (Unys)</span>
                        </label>

                        <label for="gen6" class="flex items-center gap-3 cursor-pointer rounded-md p-2 hover:bg-gray-50">
                            <input type="checkbox" id="gen6" name="generations[]" value="6" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Génération 6 (Kalos)</span>
                        </label>

                        <label for="gen7" class="flex items-center gap-3 cursor-pointer rounded-md p-2 hover:bg-gray-50">
                            <input type="checkbox" id="gen7" name="generations[]" value="7" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Génération 7 (Alola)</span>
                        </label>

                        <label for="gen8" class="flex items-center gap-3 cursor-pointer rounded-md p-2 hover:bg-gray-50">
                            <input type="checkbox" id="gen8" name="generations[]" value="8" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Génération 8 (Galar)</span>
                        </label>

                        <label for="gen9" class="flex items-center gap-3 cursor-pointer rounded-md p-2 hover:bg-gray-50">
                            <input type="checkbox" id="gen9" name="generations[]" value="9" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Génération 9 (Paldea)</span>
                        </label>
                    </div>

                    <div class="mt-4">
                        <label for="selectAll" class="inline-flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                            <input type="checkbox" id="selectAll" name="selectAll" value="all" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span>Tout sélectionner / Tout désélectionner</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-3">Choix du mode de jeu</h3>

                    <div class="flex items-center gap-6">
                        <label for="classic" class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="radio" id="classic" name="mode" value="classic" checked class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Classique</span>
                        </label>

                        <label for="emoji" class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="radio" id="emoji" name="mode" value="emoji" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Emoji</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 text-right">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Commencer à jouer
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        // Script simple pour toggle "Tout sélectionner"
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAll');
            const genCheckboxes = Array.from(document.querySelectorAll('input[name="generations[]"]'));

            if (!selectAll) return;

            selectAll.addEventListener('change', function () {
                genCheckboxes.forEach(cb => cb.checked = selectAll.checked);
            });

            // Si l'utilisateur change manuellement une case, désactiver "selectAll" si tout n'est pas coché
            genCheckboxes.forEach(cb => cb.addEventListener('change', function () {
                selectAll.checked = genCheckboxes.every(c => c.checked);
            }));
        });
    </script>

@endsection
