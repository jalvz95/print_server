<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Impresora extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
        'descripcion_estado',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    const ESTADO_FUNCIONAL = 'funcional';
    const ESTADO_SIN_TINTA = 'sin_tinta';
    const ESTADO_SIN_HOJAS = 'sin_hojas';
    const ESTADO_DESCONECTADA = 'desconectada';

    /**
     * Relación con trabajos
     */
    public function trabajos(): HasMany
    {
        return $this->hasMany(Trabajo::class);
    }

    /**
     * Verificar si la impresora está disponible para imprimir
     */
    public function estaDisponible(): bool
    {
        return $this->activa && $this->estado === self::ESTADO_FUNCIONAL;
    }

    /**
     * Obtener mensaje de error según el estado
     */
    public function getMensajeError(): string
    {
        return match($this->estado) {
            self::ESTADO_SIN_TINTA => "La impresora '{$this->nombre}' no tiene tinta disponible",
            self::ESTADO_SIN_HOJAS => "La impresora '{$this->nombre}' no tiene hojas disponibles",
            self::ESTADO_DESCONECTADA => "La impresora '{$this->nombre}' está desconectada",
            default => "La impresora '{$this->nombre}' no está disponible",
        };
    }

    /**
     * Obtener color de estado para UI
     */
    public function getColorEstadoAttribute(): string
    {
        return match($this->estado) {
            self::ESTADO_FUNCIONAL => 'bg-green-500',
            self::ESTADO_SIN_TINTA => 'bg-yellow-500',
            self::ESTADO_SIN_HOJAS => 'bg-orange-500',
            self::ESTADO_DESCONECTADA => 'bg-red-500',
            default => 'bg-gray-500',
        };
    }

    /**
     * Obtener icono según el estado
     */
    public function getIconoEstadoAttribute(): string
    {
        return match($this->estado) {
            self::ESTADO_FUNCIONAL => '✅',
            self::ESTADO_SIN_TINTA => '🖨️⚠️',
            self::ESTADO_SIN_HOJAS => '🖨️📄',
            self::ESTADO_DESCONECTADA => '🖨️🔌',
            default => '🖨️',
        };
    }
}
