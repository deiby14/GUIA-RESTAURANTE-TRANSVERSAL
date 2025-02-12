<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('restaurante_id');
            $table->decimal('puntuación', 2, 1);
            $table->text('comentario')->nullable();
            $table->timestamps();
    
            // Claves foráneas
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('restaurante_id')->references('id')->on('restaurantes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoraciones');
    }
};
