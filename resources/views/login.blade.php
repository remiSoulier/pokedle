<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Se Connecter</title>
</head>
<body>

<div style="text-align: center; margin-top: 50px;">
    <h1>Se Connecter</h1>
    <form action="/login" method="POST" style="display: inline-block; margin-top: 20px;">
        @csrf
        <input type="text" name="username" placeholder="Nom d'utilisateur" required style="padding: 10px; margin-bottom: 10px; width: 200px;">
        <br>
        <input type="password" name="password" placeholder="Mot de passe" required style="padding: 10px; margin-bottom: 20px; width: 200px;">
        <br>
        <button type="submit" style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px;">Se connecter</button>
    </form>
    <p style="margin-top: 20px;">Pas encore de compte ? <a href="/register" style="color: #007BFF;">S'inscrire</a></p>
</body>
</html>
