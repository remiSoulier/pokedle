<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id();

            // Nom
            $table->string('name', 100)->unique();

            // Types (1 obligatoire, 2 optionnel)
            $table->string('type1', 50);
            $table->string('type2', 50)->nullable();

            // Génération (1 à 9)
            $table->unsignedTinyInteger('generation');

            // Stade d'évolution (1 = base, 2 = 1ère evo, 3 = 2ème evo)
            $table->unsignedTinyInteger('evolution_stage');

            // Entièrement évolué
            $table->boolean('is_fully_evolved')->default(false);

            // Taille (mètres) et poids (kg)
            $table->decimal('height', 4, 2); // ex: 1.70
            $table->decimal('weight', 5, 2); // ex: 123.45

            // Image
            $table->string('image_url');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemons');
    }
};
