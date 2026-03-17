<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokemons';

    public $timestamps = false;

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

    public static function comparer($pokemonTest, $pokemonCible)
    {
        $result = [];

        $result['name'] = ($pokemonTest->name === $pokemonCible->name) ? 'green' : 'red';
        $result['type1'] = ($pokemonTest->type1 === $pokemonCible->type1) ? 'green' : 'red';
        $result['type2'] = ($pokemonTest->type2 === $pokemonCible->type2) ? 'green' : 'red';
        $result['generation'] = ($pokemonTest->generation === $pokemonCible->generation) ? 'green' : 'red';
        $result['evolution_stage'] = ($pokemonTest->evolution_stage === $pokemonCible->evolution_stage) ? 'green' : 'red';
        $result['is_fully_evolved'] = ($pokemonTest->is_fully_evolved === $pokemonCible->is_fully_evolved) ? 'green' : 'red';
        $result['height'] = ($pokemonTest->height === $pokemonCible->height) ? 'green' : 'red';
        if ($result['height'] === 'red') {
            $result['hint_height'] = ($pokemonTest->height < $pokemonCible->height) ?  '↑' : '↓';
        }
        $result['weight'] = ($pokemonTest->weight === $pokemonCible->weight) ? 'green' : 'red';
        if ($result['weight'] === 'red') {
            $result['hint_weight'] = ($pokemonTest->weight < $pokemonCible->weight) ?  '↑' : '↓';
        }

        return $result;
    }
}
