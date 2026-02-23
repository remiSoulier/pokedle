<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pokédle')</title>
</head>
<body>

<header>
    <a href="/" style="text-decoration: none; color: black;">
        <img src="{{ asset('logo.svg') }}" alt="Logo" style="width: 100px; height: auto;">
    </a>
</header>

<main>
    @yield('content')
</main>

</body>
</html>
