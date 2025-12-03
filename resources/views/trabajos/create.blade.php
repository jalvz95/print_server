@extends('layouts.app')

@section('title', 'Enviar Trabajo')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Enviar Nuevo Trabajo de Impresión</h2>

    <form action="{{ route('trabajos.store') }}" method="POST">
        @csrf
        <input type="hidden" name="return_to" value="{{ $returnTo ?? 'dashboard' }}">

        <div class="mb-4">
            <label for="usuario_id" class="block text-sm font-medium text-gray-700 mb-2">
                Usuario
            </label>
            <select name="usuario_id" id="usuario_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccione un usuario</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombre }} (Cuota: {{ $usuario->cuota_actual }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="impresora_id" class="block text-sm font-medium text-gray-700 mb-2">
                Impresora
            </label>
            <select name="impresora_id" id="impresora_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccione una impresora</option>
                @foreach($impresoras as $impresora)
                    <option value="{{ $impresora->id }}" {{ old('impresora_id') == $impresora->id ? 'selected' : '' }}>
                        {{ $impresora->nombre }} 
                        @if($impresora->estado === 'funcional')
                            ✅ Funcional
                        @elseif($impresora->estado === 'sin_tinta')
                            ⚠️ Sin Tinta
                        @elseif($impresora->estado === 'sin_hojas')
                            📄 Sin Hojas
                        @elseif($impresora->estado === 'desconectada')
                            🔌 Desconectada
                        @endif
                    </option>
                @endforeach
            </select>
            <p class="mt-1 text-sm text-gray-500">Seleccione la impresora a la que desea enviar el trabajo</p>
        </div>

        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                Descripción del Trabajo
            </label>
            <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Ej: Reporte Mensual">
        </div>

        <div class="mb-4">
            <label for="paginas" class="block text-sm font-medium text-gray-700 mb-2">
                Número de Páginas (1-500)
            </label>
            <input type="number" name="paginas" id="paginas" value="{{ old('paginas', 1) }}" required
                   min="1" max="500"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tipo de Impresión
            </label>
            <div class="flex items-center">
                <input type="checkbox" name="es_color" id="es_color" value="1" {{ old('es_color') ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="es_color" class="ml-2 block text-sm text-gray-900">
                    A Color
                </label>
            </div>
            <p class="mt-1 text-sm text-gray-500">Si no se marca, será impresión en Blanco y Negro</p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Prioridad
            </label>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input type="radio" name="prioridad" id="prioridad_normal" value="3" {{ old('prioridad', 3) == 3 ? 'checked' : '' }} required
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <label for="prioridad_normal" class="ml-2 block text-sm text-gray-900">
                        Normal
                    </label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="prioridad" id="prioridad_urgente" value="5" {{ old('prioridad') == 5 ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <label for="prioridad_urgente" class="ml-2 block text-sm text-gray-900">
                        Urgente
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route($returnTo ?? 'dashboard') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                Enviar Trabajo
            </button>
        </div>
    </form>
</div>
@endsection

