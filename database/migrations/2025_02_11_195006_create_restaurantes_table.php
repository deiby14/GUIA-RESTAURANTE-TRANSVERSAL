<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('dirección');
            $table->text('precio_medio');
            // $table->string('tipo_cocina');
            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onDelete('cascade');
            $table->foreignId('tipocomida_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurantes');
    }
};