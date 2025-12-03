<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipoServidorController extends Controller
{
    /**
     * Mostrar página de selección de tipo de servidor
     */
    public function index()
    {
        return view('tipo-servidor.index');
    }
}
