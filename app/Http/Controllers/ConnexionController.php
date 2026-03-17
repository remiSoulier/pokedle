<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use Illuminate\Http\Request;

class ConnexionController extends Controller
{

    public function afficherVueConnexion()
    {
        if (session()->has('joueur_id')) {
            return redirect('/play');
        }
        return view('login');
    }
    public function connecter()
    {
        $username = request()->input('username');
        $password = request()->input('password');
        $user = Joueur::where('pseudo', $username)->first();

        if ($user && password_verify($password, $user->pwd_hash)) {
            session()->put('joueur_id', $user->id);
            session()->put('username', $user->pseudo);
            return redirect('/games');
        } else {
            return redirect('/login')->with('error', 'Identifiants invalides.');
        }
    }

    public function deconnecter()
    {
        session()->forget('joueur_id');
        session()->forget('username');
        return redirect('/login');
    }

    public function afficherVueCreationCompte()
    {
        if (session()->has('joueur_id')) {
            return redirect('/games');
        }
        return view('register');
    }

    public function createAcount()
    {
        $username = request()->input('username');
        $password = request()->input('password');
        $password2 = request()->input('password_confirmation');

        if ($password !== $password2) {
            return redirect('/register')->with('error', 'Les mots de passe ne correspondent pas.');
        }



        $existingUser = Joueur::where('pseudo', $username)->first();

        if ($existingUser) {
            return redirect('/register')->with('error', 'Ce pseudo est déjà pris.');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = Joueur::create([
            'pseudo' => $username,
            'pwd_hash' => $hashedPassword
        ]);

        session()->put('joueur_id', $user->id);
        session()->put('username', $user->pseudo);
        return redirect('/games');
    }
}
