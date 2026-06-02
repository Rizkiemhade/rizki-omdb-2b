<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('imdb_id');
            $table->string('title');
            $table->string('year')->nullable();
            $table->string('poster')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'imdb_id']); // 1 user tidak bisa favorite film yang sama 2x
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};