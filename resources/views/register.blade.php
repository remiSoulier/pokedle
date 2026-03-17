@extends('layouts.app')

@section('title', 'Inscription')

@section('content')

    <div class="flex min-h-[70vh] items-center justify-center px-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">

            <div class="text-center">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                    S'inscrire
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    Créez un compte pour sauvegarder vos résultats.
                </p>
            </div>

            <form action="/register" method="POST" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nom d'utilisateur
                    </label>
                    <input
                        type="text"
                        name="username"
                        required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        placeholder="Nom d'utilisateur"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Mot de passe
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        placeholder="Mot de passe"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Confirmer le mot de passe
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        placeholder="Confirmer le mot de passe"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-gray-800 active:bg-black"
                >
                    S'inscrire
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                <p class="text-gray-600">
                    Déjà un compte ?
                    <a href="/login" class="font-medium text-blue-600 hover:underline">
                        Se connecter
                    </a>
                </p>
            </div>

        </div>
    </div>

@endsection
