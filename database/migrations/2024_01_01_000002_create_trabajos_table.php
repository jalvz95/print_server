<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('descripcion');
            $table->integer('paginas');
            $table->boolean('es_color')->default(false);
            $table->integer('prioridad')->default(3); // 1-Baja, 3-Normal, 5-Urgente
            $table->string('estado')->default('Enviado');
            $table->timestamp('tiempo_envio');
            $table->timestamp('tiempo_inicio_proceso')->nullable();
            $table->timestamp('tiempo_terminacion')->nullable();
            $table->text('motivo_bloqueo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trabajos');
    }
};

