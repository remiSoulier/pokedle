@extends('layouts.app')

@section('title', 'Connexion')

@section('content')

    <div class="flex min-h-[70vh] items-center justify-center px-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">

            <div class="text-center">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                    Se connecter
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    Connectez-vous pour sauvegarder vos performances.
                </p>
            </div>

            <form action="/login" method="POST" class="mt-6 space-y-5">
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

                <button
                    type="submit"
                    class="w-full rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-gray-800 active:bg-black"
                >
                    Se connecter
                </button>
            </form>

            <div class="mt-6 space-y-3 text-center text-sm">
                <p class="text-gray-600">
                    Pas encore de compte ?
                    <a href="/register" class="font-medium text-blue-600 hover:underline">
                        S'inscrire
                    </a>
                </p>

                <div class="flex items-center justify-center gap-3">
                    <span class="h-px w-10 bg-gray-200"></span>
                    <span class="text-gray-400">ou</span>
                    <span class="h-px w-10 bg-gray-200"></span>
                </div>

                <a
                    href="/play"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50"
                >
                    Jouer en tant qu'invité
                </a>
            </div>

        </div>
    </div>

@endsection
