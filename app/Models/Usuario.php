<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'cuota_actual',
        'activo',
    ];

    protected $casts = [
        'cuota_actual' => 'integer',
        'activo' => 'boolean',
    ];

    /**
     * Relación con trabajos
     */
    public function trabajos(): HasMany
    {
        return $this->hasMany(Trabajo::class);
    }

    /**
     * Verificar si el usuario tiene cuota disponible
     */
    public function tieneCuota(): bool
    {
        return $this->cuota_actual > 0;
    }

    /**
     * Reducir cuota del usuario
     */
    public function reducirCuota(int $cantidad = 1): void
    {
        $this->cuota_actual = max(0, $this->cuota_actual - $cantidad);
        $this->save();
    }
}

