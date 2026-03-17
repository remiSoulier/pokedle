<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pokédle')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">

<header class="border-b bg-white shadow-sm">
    <div class="mx-auto max-w-5xl px-4 py-3">
        <a href="/" class="inline-block">
            <img src="{{ asset('logo.svg') }}" alt="Logo" class="h-12 w-auto">
        </a>
    </div>
</header>

<main class="mx-auto max-w-5xl px-4 py-8">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
@stack('scripts')
</body>
</html>
