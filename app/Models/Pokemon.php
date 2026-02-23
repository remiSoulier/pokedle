<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokemons';

    protected $fillable = [
        'id',
        'name',
        'type1',
        'type2',
        'generation',
        'evolution_stage',
        'is_fully_evolved',
        'height',
        'weight',
        'image_url'
    ];

    protected $casts = [
        'generation' => 'integer',
        'evolution_stage' => 'integer',
        'is_fully_evolved' => 'boolean',
        'height' => 'float',
        'weight' => 'float',
    ];

    public static function getRandomPokemon(array $generations)
    {
        return self::whereIn('generation', $generations)->inRandomOrder()->first();
    }
}
