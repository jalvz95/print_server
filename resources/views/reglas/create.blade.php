@extends('layouts.app')

@section('title', 'Crear Regla')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Crear Nueva Regla</h2>

    <form action="{{ route('reglas.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                Nombre de la Regla
            </label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Ej: Límite Diario para Estudiantes">
        </div>

        <div class="mb-4">
            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-2">
                Tipo de Regla
            </label>
            <select name="tipo" id="tipo" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccione un tipo</option>
                <option value="Cuota Usuario" {{ old('tipo') == 'Cuota Usuario' ? 'selected' : '' }}>Cuota Usuario</option>
                <option value="Restricción Trabajo" {{ old('tipo') == 'Restricción Trabajo' ? 'selected' : '' }}>Restricción Trabajo</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="parametro_objetivo" class="block text-sm font-medium text-gray-700 mb-2">
                Parámetro Objetivo
            </label>
            <select name="parametro_objetivo" id="parametro_objetivo" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccione un parámetro</option>
                <option value="cuota_actual" {{ old('parametro_objetivo') == 'cuota_actual' ? 'selected' : '' }}>Cuota Actual</option>
                <option value="paginas" {{ old('parametro_objetivo') == 'paginas' ? 'selected' : '' }}>Páginas</option>
                <option value="es_color" {{ old('parametro_objetivo') == 'es_color' ? 'selected' : '' }}>Impresión a Color</option>
            </select>
            <p class="mt-1 text-sm text-gray-500">El parámetro que la regla evaluará</p>
        </div>

        <div class="mb-4">
            <label for="valor_limite" class="block text-sm font-medium text-gray-700 mb-2">
                Valor Límite
            </label>
            <input type="text" name="valor_limite" id="valor_limite" value="{{ old('valor_limite') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Ej: 0, 200, true">
            <p class="mt-1 text-sm text-gray-500">Para páginas: número (ej: 200). Para color: true/false</p>
        </div>

        <div class="mb-4">
            <label for="accion" class="block text-sm font-medium text-gray-700 mb-2">
                Acción
            </label>
            <select name="accion" id="accion" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccione una acción</option>
                <option value="Bloquear" {{ old('accion') == 'Bloquear' ? 'selected' : '' }}>Bloquear</option>
                <option value="Advertir" {{ old('accion') == 'Advertir' ? 'selected' : '' }}>Advertir</option>
                <option value="Reducir Prioridad" {{ old('accion') == 'Reducir Prioridad' ? 'selected' : '' }}>Reducir Prioridad</option>
            </select>
        </div>

        <div class="mb-6">
            <div class="flex items-center">
                <input type="checkbox" name="activa" id="activa" value="1" {{ old('activa', true) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="activa" class="ml-2 block text-sm text-gray-900">
                    Regla Activa
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('reglas.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                Crear Regla
            </button>
        </div>
    </form>
</div>
@endsection

