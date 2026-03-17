<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokemons', function (Blueprint $table) {

            $table->id();

            $table->string('name', 100)->unique();

            $table->string('type1', 50);
            $table->string('type2', 50)->nullable();

            $table->unsignedTinyInteger('generation');

            $table->unsignedTinyInteger('evolution_stage');

            $table->boolean('is_fully_evolved')->default(false);

            $table->decimal('height', 6, 2);
            $table->decimal('weight', 8, 2);

            $table->string('image_url');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemons');
    }
};
