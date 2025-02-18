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
            $table->string('dirección');
            $table->decimal('precio_medio', 8, 2);
            $table->text('descripcion')->nullable();
            $table->foreignId('tipocomida_id')->constrained();
            $table->foreignId('ciudad_id')->nullable()->constrained('ciudades');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurantes');
    }
};