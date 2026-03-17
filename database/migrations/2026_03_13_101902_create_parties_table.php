<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parties', function (Blueprint $table) {

            $table->id();

            $table->foreignId('joueur_id')
                ->constrained('joueurs')
                ->cascadeOnDelete();

            $table->string('type_partie', 30);

            $table->foreignId('reponse_pokemon_id')
                ->constrained('pokemons')
                ->restrictOnDelete();

            $table->unsignedSmallInteger('nb_essais')->default(0);

            $table->enum('status', ['in_progress', 'won', 'lost'])
                ->default('in_progress');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
