<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Victoire</title>
</head>
<body>
<h1>
    Félicitations, vous avez gagné en {{ $nbEssais }} essai{{ $nbEssais > 1 ? 's' : '' }} !
</h1>


<form action="/reset" method="post">
    @csrf
    <button type="submit">Rejouer</button>
</form>
</body>
</html>
