<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Trabajo;
use App\Models\Regla;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar dashboard principal
     */
    public function index()
    {
        $usuarios = Usuario::where('activo', true)->get();
        $trabajos = Trabajo::with('usuario')
            ->orderBy('tiempo_envio', 'desc')
            ->get();
        $reglas = Regla::all();

        $estadisticas = [
            'total_trabajos' => Trabajo::count(),
            'en_cola' => Trabajo::where('estado', Trabajo::ESTADO_EN_COLA)->count(),
            'en_proceso' => Trabajo::where('estado', Trabajo::ESTADO_EN_PROCESO)->count(),
            'bloqueados' => Trabajo::where('estado', Trabajo::ESTADO_BLOQUEADO)->count(),
            'terminados' => Trabajo::where('estado', Trabajo::ESTADO_TERMINADO)->count(),
        ];

        return view('dashboard', compact('usuarios', 'trabajos', 'reglas', 'estadisticas'));
    }
}

