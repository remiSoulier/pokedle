<?php

use App\Models\Pokemon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Tests unitaires pour App\Models\Pokemon
 */

test('comparer retourne tout en vert pour des pokemons identiques', function () {
    $a = new Pokemon([
        'name' => 'Pikachu',
        'type1' => 'Electric',
        'type2' => null,
        'generation' => 1,
        'evolution_stage' => 2,
        'is_fully_evolved' => true,
        'height' => 0.4,
        'weight' => 6.0,
    ]);

    $b = new Pokemon([
        'name' => 'Pikachu',
        'type1' => 'Electric',
        'type2' => null,
        'generation' => 1,
        'evolution_stage' => 2,
        'is_fully_evolved' => true,
        'height' => 0.4,
        'weight' => 6.0,
    ]);

    $result = Pokemon::comparer($a, $b);

    expect($result)->toBeArray();

    foreach (['name','type1','type2','generation','evolution_stage','is_fully_evolved','height','weight'] as $key) {
        expect($result[$key])->toBe('green');
    }

    expect(isset($result['hint_height']))->toBeFalse();
    expect(isset($result['hint_weight']))->toBeFalse();
});

test('comparer fournit des hints pour height et weight quand differe', function () {
    $a = new Pokemon([
        'name' => 'A',
        'type1' => 'Fire',
        'type2' => null,
        'generation' => 1,
        'evolution_stage' => 1,
        'is_fully_evolved' => false,
        'height' => 2.0,
        'weight' => 10.0,
    ]);

    $b = new Pokemon([
        'name' => 'B',
        'type1' => 'Water',
        'type2' => null,
        'generation' => 1,
        'evolution_stage' => 1,
        'is_fully_evolved' => false,
        'height' => 1.5,
        'weight' => 12.0,
    ]);

    $result = Pokemon::comparer($a, $b);

    expect($result['height'])->toBe('red');
    expect($result['hint_height'])->toBe('↑');

    expect($result['weight'])->toBe('red');
    expect($result['hint_weight'])->toBe('↓');
});

test('getRandomPokemon retourne un pok\u00e9mon appartenant aux g\u00e9n\u00e9rations demand\u00e9es', function () {
    Pokemon::create([
        'name' => 'Bulbasaur',
        'type1' => 'Grass',
        'type2' => null,
        'generation' => 1,
        'evolution_stage' => 1,
        'is_fully_evolved' => false,
        'height' => 0.7,
        'weight' => 6.9,
    ]);

    Pokemon::create([
        'name' => 'Charmander',
        'type1' => 'Fire',
        'type2' => null,
        'generation' => 1,
        'evolution_stage' => 1,
        'is_fully_evolved' => false,
        'height' => 0.6,
        'weight' => 8.5,
    ]);

    Pokemon::create([
        'name' => 'Mew',
        'type1' => 'Psychic',
        'type2' => null,
        'generation' => 1,
        'evolution_stage' => 3,
        'is_fully_evolved' => true,
        'height' => 0.4,
        'weight' => 4.0,
    ]);

    Pokemon::create([
        'name' => 'Scorbunny',
        'type1' => 'Fire',
        'type2' => null,
        'generation' => 8,
        'evolution_stage' => 1,
        'is_fully_evolved' => false,
        'height' => 0.3,
        'weight' => 4.5,
    ]);

    $random = Pokemon::getRandomPokemon([1]);

    expect($random)->not->toBeNull();
    expect(in_array($random->generation, [1], true))->toBeTrue();
});

