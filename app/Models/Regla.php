<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regla extends Model
{
    use HasFactory;

    protected $table = 'reglas';

    protected $fillable = [
        'nombre',
        'tipo',
        'parametro_objetivo',
        'valor_limite',
        'accion',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
        'valor_limite' => 'string', // Puede ser JSON o string
    ];

    const TIPO_CUOTA_USUARIO = 'Cuota Usuario';
    const TIPO_RESTRICCION_TRABAJO = 'Restricción Trabajo';

    const ACCION_BLOQUEAR = 'Bloquear';
    const ACCION_ADVERTIR = 'Advertir';
    const ACCION_REDUCIR_PRIORIDAD = 'Reducir Prioridad';

    /**
     * Aplicar regla a un trabajo
     */
    public function aplicar(Trabajo $trabajo): ?array
    {
        if (!$this->activa) {
            return null;
        }

        $resultado = null;

        switch ($this->tipo) {
            case self::TIPO_CUOTA_USUARIO:
                $resultado = $this->aplicarCuotaUsuario($trabajo);
                break;
            case self::TIPO_RESTRICCION_TRABAJO:
                $resultado = $this->aplicarRestriccionTrabajo($trabajo);
                break;
        }

        return $resultado;
    }

    /**
     * Aplicar regla de cuota de usuario
     */
    private function aplicarCuotaUsuario(Trabajo $trabajo): ?array
    {
        $usuario = $trabajo->usuario;
        
        if ($this->parametro_objetivo === 'cuota_actual') {
            $limite = (int) $this->valor_limite;
            
            if ($usuario->cuota_actual <= $limite) {
                return [
                    'aplica' => true,
                    'accion' => $this->accion,
                    'motivo' => "Usuario sin cuota disponible (cuota actual: {$usuario->cuota_actual})",
                ];
            }
        }

        return null;
    }

    /**
     * Aplicar restricción de trabajo
     */
    private function aplicarRestriccionTrabajo(Trabajo $trabajo): ?array
    {
        $parametro = $this->parametro_objetivo;
        $limite = $this->valor_limite;

        switch ($parametro) {
            case 'paginas':
                $limiteInt = (int) $limite;
                if ($trabajo->paginas > $limiteInt) {
                    return [
                        'aplica' => true,
                        'accion' => $this->accion,
                        'motivo' => "Trabajo excede límite de páginas ({$trabajo->paginas} > {$limiteInt})",
                    ];
                }
                break;

            case 'es_color':
                $limiteBool = filter_var($limite, FILTER_VALIDATE_BOOLEAN);
                if ($trabajo->es_color && $limiteBool) {
                    // Verificar si el usuario es "Premium" (podría ser un campo adicional)
                    // Por ahora, asumimos que si es_color es true y la regla está activa, aplica
                    return [
                        'aplica' => true,
                        'accion' => $this->accion,
                        'motivo' => "Trabajo a color no permitido para este usuario",
                    ];
                }
                break;
        }

        return null;
    }
}

