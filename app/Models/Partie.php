<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partie extends Model
{
    protected $table = 'parties';

    protected $fillable = [
        'joueur_id',
        'type_partie',
        'reponse_pokemon_id',
        'nb_essais',
        'status'
    ];

    public function joueur()
    {
        return $this->belongsTo(Joueur::class, 'joueur_id');
    }

    public function reponsePokemon()
    {
        return $this->belongsTo(Pokemon::class, 'reponse_pokemon_id');
    }
}
