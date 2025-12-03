<?php

namespace App\Http\Controllers;

use App\Models\Regla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReglaController extends Controller
{
    /**
     * Mostrar lista de reglas
     */
    public function index()
    {
        $reglas = Regla::orderBy('activa', 'desc')->orderBy('nombre')->get();
        return view('reglas.index', compact('reglas'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('reglas.create');
    }

    /**
     * Almacenar nueva regla
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Cuota Usuario,Restricción Trabajo',
            'parametro_objetivo' => 'required|string',
            'valor_limite' => 'required|string',
            'accion' => 'required|in:Bloquear,Advertir,Reducir Prioridad',
            'activa' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Regla::create([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'parametro_objetivo' => $request->parametro_objetivo,
            'valor_limite' => $request->valor_limite,
            'accion' => $request->accion,
            'activa' => $request->has('activa'),
        ]);

        return redirect()->route('reglas.index')->with('success', 'Regla creada exitosamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Regla $regla)
    {
        return view('reglas.edit', compact('regla'));
    }

    /**
     * Actualizar regla
     */
    public function update(Request $request, Regla $regla)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Cuota Usuario,Restricción Trabajo',
            'parametro_objetivo' => 'required|string',
            'valor_limite' => 'required|string',
            'accion' => 'required|in:Bloquear,Advertir,Reducir Prioridad',
            'activa' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $regla->update([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'parametro_objetivo' => $request->parametro_objetivo,
            'valor_limite' => $request->valor_limite,
            'accion' => $request->accion,
            'activa' => $request->has('activa'),
        ]);

        return redirect()->route('reglas.index')->with('success', 'Regla actualizada exitosamente');
    }

    /**
     * Eliminar regla
     */
    public function destroy(Regla $regla)
    {
        $regla->delete();
        return redirect()->route('reglas.index')->with('success', 'Regla eliminada exitosamente');
    }
}

