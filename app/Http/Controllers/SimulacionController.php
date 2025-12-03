<?php

namespace App\Http\Controllers;

use App\Models\Trabajo;
use App\Models\Regla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimulacionController extends Controller
{
    /**
     * Procesar un ciclo de simulación
     * Este método será llamado periódicamente desde el frontend
     */
    public function procesar()
    {
        DB::beginTransaction();
        try {
            // 1. Mover trabajos "Enviado" a "En Cola" (si no están bloqueados)
            Trabajo::where('estado', Trabajo::ESTADO_ENVIADO)
                ->get()
                ->each(function ($trabajo) {
                    $reglas = Regla::where('activa', true)->get();
                    $bloqueado = false;

                    foreach ($reglas as $regla) {
                        $resultado = $regla->aplicar($trabajo);
                        if ($resultado && $resultado['aplica'] && $resultado['accion'] === Regla::ACCION_BLOQUEAR) {
                            $trabajo->estado = Trabajo::ESTADO_BLOQUEADO;
                            $trabajo->motivo_bloqueo = $resultado['motivo'];
                            $bloqueado = true;
                            break;
                        }
                    }

                    if (!$bloqueado) {
                        $trabajo->estado = Trabajo::ESTADO_EN_COLA;
                    }
                    $trabajo->save();
                });

            // 2. Verificar si hay trabajo en proceso que deba terminar
            $trabajoEnProceso = Trabajo::where('estado', Trabajo::ESTADO_EN_PROCESO)
                ->whereNotNull('tiempo_inicio_proceso')
                ->first();

            if ($trabajoEnProceso) {
                $tiempoProcesamiento = $trabajoEnProceso->paginas * 3; // 3 segundos por página para demostración
                $tiempoTranscurrido = now()->diffInSeconds($trabajoEnProceso->tiempo_inicio_proceso);

                if ($tiempoTranscurrido >= $tiempoProcesamiento) {
                    $trabajoEnProceso->estado = Trabajo::ESTADO_TERMINADO;
                    $trabajoEnProceso->tiempo_terminacion = now();
                    $trabajoEnProceso->save();

                    // Reducir cuota del usuario
                    $usuario = $trabajoEnProceso->usuario;
                    $usuario->reducirCuota(1);
                }
            }

            // 3. Si no hay trabajo en proceso, tomar el siguiente de la cola
            if (!$trabajoEnProceso || $trabajoEnProceso->estado === Trabajo::ESTADO_TERMINADO) {
                $siguienteTrabajo = Trabajo::where('estado', Trabajo::ESTADO_EN_COLA)
                    ->orderBy('prioridad', 'desc')
                    ->orderBy('tiempo_envio', 'asc')
                    ->first();

                if ($siguienteTrabajo) {
                    $siguienteTrabajo->estado = Trabajo::ESTADO_EN_PROCESO;
                    $siguienteTrabajo->tiempo_inicio_proceso = now();
                    $siguienteTrabajo->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ciclo de simulación procesado',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error en simulación: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener estado actual de todos los trabajos
     */
    public function estado()
    {
        $trabajos = Trabajo::with('usuario')
            ->orderBy('tiempo_envio', 'desc')
            ->get();

        return response()->json($trabajos);
    }
}

