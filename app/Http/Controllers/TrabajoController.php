<?php

namespace App\Http\Controllers;

use App\Models\Trabajo;
use App\Models\Usuario;
use App\Models\Regla;
use App\Models\Impresora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TrabajoController extends Controller
{
    /**
     * Mostrar formulario de envío de trabajo
     */
    public function create(Request $request)
    {
        $usuarios = Usuario::where('activo', true)->get();
        $impresoras = Impresora::where('activa', true)->get();
        $returnTo = $request->input('return_to', 'dashboard');
        return view('trabajos.create', compact('usuarios', 'impresoras', 'returnTo'));
    }

    /**
     * Almacenar nuevo trabajo
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|exists:usuarios,id',
            'impresora_id' => 'required|exists:impresoras,id',
            'descripcion' => 'required|string|max:255',
            'paginas' => 'required|integer|min:1|max:500',
            'es_color' => 'boolean',
            'prioridad' => 'required|in:1,3,5',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Validar estado de la impresora
            $impresora = Impresora::findOrFail($request->impresora_id);
            $bloqueadoPorImpresora = false;
            $motivoImpresora = null;

            if (!$impresora->estaDisponible()) {
                $bloqueadoPorImpresora = true;
                $motivoImpresora = $impresora->getMensajeError();
                
                // Registrar en el log
                Log::warning('Trabajo bloqueado por estado de impresora', [
                    'usuario_id' => $request->usuario_id,
                    'impresora_id' => $request->impresora_id,
                    'impresora_nombre' => $impresora->nombre,
                    'impresora_estado' => $impresora->estado,
                    'descripcion_trabajo' => $request->descripcion,
                    'motivo' => $motivoImpresora,
                ]);
            }

            $trabajo = Trabajo::create([
                'usuario_id' => $request->usuario_id,
                'impresora_id' => $request->impresora_id,
                'descripcion' => $request->descripcion,
                'paginas' => $request->paginas,
                'es_color' => $request->has('es_color'),
                'prioridad' => $request->prioridad,
                'estado' => Trabajo::ESTADO_ENVIADO,
                'tiempo_envio' => now(),
            ]);

            // Aplicar reglas
            $reglas = Regla::where('activa', true)->get();
            $bloqueado = $bloqueadoPorImpresora;
            $motivo = $motivoImpresora;

            // Solo aplicar reglas si la impresora está disponible
            if (!$bloqueadoPorImpresora) {
                foreach ($reglas as $regla) {
                    $resultado = $regla->aplicar($trabajo);
                    
                    if ($resultado && $resultado['aplica']) {
                        if ($resultado['accion'] === Regla::ACCION_BLOQUEAR) {
                            $trabajo->estado = Trabajo::ESTADO_BLOQUEADO;
                            $trabajo->motivo_bloqueo = $resultado['motivo'];
                            $bloqueado = true;
                            $motivo = $resultado['motivo'];
                            break;
                        } elseif ($resultado['accion'] === Regla::ACCION_REDUCIR_PRIORIDAD) {
                            $trabajo->prioridad = Trabajo::PRIORIDAD_BAJA;
                        }
                    }
                }
            } else {
                // Si la impresora no está disponible, bloquear el trabajo
                $trabajo->estado = Trabajo::ESTADO_BLOQUEADO;
                $trabajo->motivo_bloqueo = $motivoImpresora;
            }

            if (!$bloqueado) {
                $trabajo->estado = Trabajo::ESTADO_EN_COLA;
            }

            $trabajo->save();

            DB::commit();

            $mensaje = $bloqueado 
                ? ($bloqueadoPorImpresora 
                    ? "⚠️ {$trabajo->motivo_bloqueo}. El trabajo ha sido bloqueado."
                    : "Trabajo bloqueado: {$trabajo->motivo_bloqueo}")
                : "✅ Trabajo enviado exitosamente a {$impresora->nombre} y agregado a la cola";

            // Redirigir a la ruta desde donde se envió el trabajo
            $returnTo = $request->input('return_to', 'dashboard');
            
            // Validar que la ruta existe y es segura
            $allowedRoutes = [
                'dashboard',
                'servidor.dedicado',
                'servidor.software',
                'servidor.integrado',
                'servidor.cloud',
                'servidor.cups',
                'servidor.lpr'
            ];
            
            if (in_array($returnTo, $allowedRoutes)) {
                return redirect()->route($returnTo)->with('success', $mensaje);
            }
            
            return redirect()->route('dashboard')->with('success', $mensaje);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear el trabajo: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * API: Obtener todos los trabajos
     */
    public function index()
    {
        $trabajos = Trabajo::with('usuario')
            ->orderBy('tiempo_envio', 'desc')
            ->get();

        return response()->json($trabajos);
    }

    /**
     * API: Obtener trabajos por estado
     */
    public function porEstado($estado)
    {
        $trabajos = Trabajo::with('usuario')
            ->where('estado', $estado)
            ->orderBy('prioridad', 'desc')
            ->orderBy('tiempo_envio', 'asc')
            ->get();

        return response()->json($trabajos);
    }
}

