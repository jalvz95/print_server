<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * API: Obtener todos los usuarios
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }
}

