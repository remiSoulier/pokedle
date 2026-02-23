<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Joueur extends Model
{
    protected $table = 'joueurs';

    protected $fillable = ['pseudo', 'pwd_hash'];

    protected $hidden = ['pwd_hash'];

    public function parties()
    {
        return $this->hasMany(Partie::class, 'joueur_id');
    }
}
