<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use Illuminate\Http\Request;

class ConnexionController extends Controller
{
    public function connecter(string $username, string $password)
    {
        $user = Joueur::where('pseudo', $username)->first();

        if ($user && password_verify($password, $user->pwd_hash)) {
            session()->put('joueur_id', $user->id);
            session()->put('username', $user->pseudo);
            return redirect('/play');
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

    public function createAcount(string $username, string $password)
    {
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
        return redirect('/play');
    }
}
