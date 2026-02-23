<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pokemons', function (Blueprint $table) {
            $table->decimal('height', 6, 2)->change();
            $table->decimal('weight', 8, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pokemons', function (Blueprint $table) {
            $table->decimal('height', 4, 2)->change();
            $table->decimal('weight', 5, 2)->change();
        });
    }
};
