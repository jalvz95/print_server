<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServidorCupsBackendController extends Controller
{
    /**
     * Diagrama de Backend CUPS - Flujo de procesamiento
     */
    public function index()
    {
        return view('servidores.cups-backend');
    }
}
