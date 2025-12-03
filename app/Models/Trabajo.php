<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trabajo extends Model
{
    use HasFactory;

    protected $table = 'trabajos';

    protected $fillable = [
        'usuario_id',
        'impresora_id',
        'descripcion',
        'paginas',
        'es_color',
        'prioridad',
        'estado',
        'tiempo_envio',
        'tiempo_inicio_proceso',
        'tiempo_terminacion',
        'motivo_bloqueo',
    ];

    protected $casts = [
        'usuario_id' => 'integer',
        'paginas' => 'integer',
        'es_color' => 'boolean',
        'prioridad' => 'integer',
        'tiempo_envio' => 'datetime',
        'tiempo_inicio_proceso' => 'datetime',
        'tiempo_terminacion' => 'datetime',
    ];

    const ESTADO_ENVIADO = 'Enviado';
    const ESTADO_EN_COLA = 'En Cola';
    const ESTADO_EN_PROCESO = 'En Proceso';
    const ESTADO_BLOQUEADO = 'Bloqueado';
    const ESTADO_TERMINADO = 'Terminado';

    const PRIORIDAD_BAJA = 1;
    const PRIORIDAD_NORMAL = 3;
    const PRIORIDAD_URGENTE = 5;

    /**
     * Relación con usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relación con impresora
     */
    public function impresora(): BelongsTo
    {
        return $this->belongsTo(Impresora::class);
    }

    /**
     * Calcular tiempo estimado de procesamiento en segundos
     */
    public function getTiempoProcesamientoAttribute(): float
    {
        return $this->paginas * 0.1;
    }

    /**
     * Obtener color de estado para UI
     */
    public function getColorEstadoAttribute(): string
    {
        return match($this->estado) {
            self::ESTADO_ENVIADO => 'bg-gray-400',
            self::ESTADO_EN_COLA => 'bg-yellow-400',
            self::ESTADO_EN_PROCESO => 'bg-blue-400',
            self::ESTADO_BLOQUEADO => 'bg-red-400',
            self::ESTADO_TERMINADO => 'bg-green-400',
            default => 'bg-gray-400',
        };
    }
}

