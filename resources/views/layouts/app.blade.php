<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Servidor de Impresión') - {{ config('app.name', 'Print Server') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100" x-data="{ quickNavVisible: false }">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('tipo-servidor.index') }}" class="text-2xl font-bold text-gray-800 hover:text-gray-600 transition-colors cursor-pointer">
                            🖨️ Print Server
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-8">
                        <!-- Nav por defecto (visible cuando quickNavVisible es false) -->
                        <a x-show="!quickNavVisible" href="{{ route('tipo-servidor.index') }}"
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
                           @mouseenter="quickNavVisible = true">
                            Tipos de Servidor
                        </a>
                        <a x-show="!quickNavVisible" href="{{ route('dashboard') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a x-show="!quickNavVisible" href="{{ route('trabajos.create') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Enviar Impresión
                        </a>
                        <!-- Accesos rápidos (visible cuando quickNavVisible es true) -->
                        <div x-show="quickNavVisible"
                             x-cloak
                             @mouseleave="quickNavVisible = false"
                             class="flex items-center gap-2 text-xs font-medium text-gray-700">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-blue-50 border border-transparent hover:bg-blue-100 hover:border-blue-400 hover:text-blue-700 transition">
                                <span class="text-lg">🖥️</span>
                                <span>Básico</span>
                            </a>
                            <a href="{{ route('servidor.dedicado') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-green-50 border border-transparent hover:bg-green-100 hover:border-green-400 hover:text-green-700 transition">
                                <span class="text-lg">🔌</span>
                                <span>Dedicado</span>
                            </a>
                            <a href="{{ route('servidor.software') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-purple-50 border border-transparent hover:bg-purple-100 hover:border-purple-400 hover:text-purple-700 transition">
                                <span class="text-lg">💾</span>
                                <span>Software</span>
                            </a>
                            <a href="{{ route('servidor.integrado') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-orange-50 border border-transparent hover:bg-orange-100 hover:border-orange-400 hover:text-orange-700 transition">
                                <span class="text-lg">🖨️</span>
                                <span>Integrado</span>
                            </a>
                            <a href="{{ route('servidor.cloud') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-cyan-50 border border-transparent hover:bg-cyan-100 hover:border-cyan-400 hover:text-cyan-700 transition">
                                <span class="text-lg">☁️</span>
                                <span>Cloud</span>
                            </a>
                            <a href="{{ route('servidor.cups') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-purple-50 border border-transparent hover:bg-purple-100 hover:border-purple-400 hover:text-purple-700 transition">
                                <span class="text-lg">🐧</span>
                                <span>CUPS</span>
                            </a>
                            <a href="{{ route('servidor.lpr') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-orange-50 border border-transparent hover:bg-orange-100 hover:border-orange-400 hover:text-orange-700 transition">
                                <span class="text-lg">📠</span>
                                <span>LPR/LPD</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>

