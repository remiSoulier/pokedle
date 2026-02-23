@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div style="text-align: center; margin-top: 50px;">
    <h1>S'inscrire</h1>
    <form action="/register" method="POST" style="display: inline-block; margin-top: 20px;">
        @csrf
        <input type="text" name="username" placeholder="Nom d'utilisateur" required style="padding: 10px; margin-bottom: 10px; width: 200px;">
        <br>
        <input type="password" name="password" placeholder="Mot de passe" required style="padding: 10px; margin-bottom: 20px; width: 200px;">
        <br>
        <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required style="padding: 10px; margin-bottom: 20px; width: 200px;">
        <br>
        <button type="submit" style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px;">S'inscrire</button>
    </form>
    <p style="margin-top: 20px;">Déjà un compte ? <a href="/login" style="color: #007BFF;">Se connecter</a></p>
@endsection
