<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();

            $table->foreignId('joueur_id')
                ->constrained('joueurs')
                ->cascadeOnDelete();

            $table->string('type_partie', 30); // ex: classic, gen1, etc.

            $table->foreignId('reponse_pokemon_id')
                ->constrained('pokemons')
                ->restrictOnDelete();

            $table->unsignedTinyInteger('nb_essais')->default(0);

            // Optionnel mais très utile
            $table->enum('status', ['in_progress', 'won', 'lost'])->default('in_progress');

            $table->timestamps();

            // Bonus: éviter 2 parties "en cours" du même type pour un joueur
            $table->unique(['joueur_id', 'type_partie', 'status'], 'uniq_partie_in_progress')
                ->where('status', 'in_progress'); // ⚠️ support dépend du driver
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
