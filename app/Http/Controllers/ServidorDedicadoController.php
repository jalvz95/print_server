<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Trabajo;
use Illuminate\Http\Request;

class ServidorDedicadoController extends Controller
{
    /**
     * Dashboard para Servidor de Impresión Dedicado (Hardware)
     */
    public function index()
    {
        $usuarios = Usuario::where('activo', true)->get();
        $trabajos = Trabajo::with('usuario')
            ->orderBy('tiempo_envio', 'desc')
            ->get();

        $estadisticas = [
            'total_trabajos' => Trabajo::count(),
            'en_cola' => Trabajo::where('estado', Trabajo::ESTADO_EN_COLA)->count(),
            'en_proceso' => Trabajo::where('estado', Trabajo::ESTADO_EN_PROCESO)->count(),
            'bloqueados' => Trabajo::where('estado', Trabajo::ESTADO_BLOQUEADO)->count(),
            'terminados' => Trabajo::where('estado', Trabajo::ESTADO_TERMINADO)->count(),
        ];

        return view('servidores.dedicado', compact('usuarios', 'trabajos', 'estadisticas'));
    }
}
