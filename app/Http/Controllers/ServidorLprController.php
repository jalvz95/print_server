<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Trabajo;
use App\Models\Impresora;
use Illuminate\Http\Request;

class ServidorLprController extends Controller
{
    /**
     * Dashboard para Servidor LPR/LPD (Line Printer Remote/Daemon)
     */
    public function index()
    {
        $usuarios = Usuario::where('activo', true)->get();
        $trabajos = Trabajo::with('usuario', 'impresora')
            ->orderBy('tiempo_envio', 'desc')
            ->get();

        $estadisticas = [
            'total_trabajos' => Trabajo::count(),
            'en_cola' => Trabajo::where('estado', Trabajo::ESTADO_EN_COLA)->count(),
            'en_proceso' => Trabajo::where('estado', Trabajo::ESTADO_EN_PROCESO)->count(),
            'bloqueados' => Trabajo::where('estado', Trabajo::ESTADO_BLOQUEADO)->count(),
            'terminados' => Trabajo::where('estado', Trabajo::ESTADO_TERMINADO)->count(),
        ];

        $impresoras = Impresora::where('activa', true)->get();

        return view('servidores.lpr', compact('usuarios', 'trabajos', 'estadisticas', 'impresoras'));
    }
}

