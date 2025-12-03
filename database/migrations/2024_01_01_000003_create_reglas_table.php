<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reglas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // 'Cuota Usuario', 'Restricción Trabajo'
            $table->string('parametro_objetivo'); // 'paginas', 'es_color', 'cuota_actual'
            $table->string('valor_limite'); // Puede ser número o boolean como string
            $table->string('accion'); // 'Bloquear', 'Advertir', 'Reducir Prioridad'
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reglas');
    }
};

