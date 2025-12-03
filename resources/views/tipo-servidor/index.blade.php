@extends('layouts.app')

@section('title', 'Seleccionar Tipo de Servidor')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">🖨️ Simulador de Servidores de Impresión</h1>
        <p class="text-gray-600">Selecciona el tipo de servidor de impresión que deseas simular</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Servidor Básico -->
        <a href="{{ route('servidor.basico') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow border-2 border-gray-200 hover:border-blue-400">
            <div class="text-center">
                <div class="text-5xl mb-4">🖥️</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Servidor Básico</h3>
                <p class="text-sm text-gray-600 mb-4">Simulación básica de servidor de impresión con arquitectura cliente-servidor</p>
                <div class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full inline-block">
                    Básico
                </div>
            </div>
        </a>

        <!-- Servidor Dedicado (Hardware) -->
        <a href="{{ route('servidor.dedicado') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow border-2 border-gray-200 hover:border-green-400">
            <div class="text-center">
                <div class="text-5xl mb-4">🔌</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Servidor Dedicado</h3>
                <p class="text-sm text-gray-600 mb-4">Dispositivo físico autónomo que convierte impresoras USB en impresoras de red</p>
                <div class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full inline-block">
                    Hardware
                </div>
            </div>
        </a>

        <!-- Servidor Basado en Software -->
        <a href="{{ route('servidor.software') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow border-2 border-gray-200 hover:border-purple-400">
            <div class="text-center">
                <div class="text-5xl mb-4">💾</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Servidor Software</h3>
                <p class="text-sm text-gray-600 mb-4">Servicio ejecutándose en un servidor de red con control centralizado</p>
                <div class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full inline-block">
                    Software
                </div>
            </div>
        </a>

        <!-- Servidor Integrado -->
        <a href="{{ route('servidor.integrado') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow border-2 border-gray-200 hover:border-orange-400">
            <div class="text-center">
                <div class="text-5xl mb-4">🖨️</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Servidor Integrado</h3>
                <p class="text-sm text-gray-600 mb-4">Impresora con servidor de impresión incorporado (Ethernet/Wi-Fi)</p>
                <div class="bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full inline-block">
                    Integrado
                </div>
            </div>
        </a>

        <!-- Servidor Cloud -->
        <a href="{{ route('servidor.cloud') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow border-2 border-gray-200 hover:border-cyan-400">
            <div class="text-center">
                <div class="text-5xl mb-4">☁️</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Servidor Cloud</h3>
                <p class="text-sm text-gray-600 mb-4">Gestión de impresión a través de servicios en la nube</p>
                <div class="bg-cyan-100 text-cyan-800 text-xs px-3 py-1 rounded-full inline-block">
                    Cloud
                </div>
            </div>
        </a>

        <!-- Servidor CUPS -->
        <a href="{{ route('servidor.cups') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow border-2 border-gray-200 hover:border-purple-400">
            <div class="text-center">
                <div class="text-5xl mb-4">🐧</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">CUPS</h3>
                <p class="text-sm text-gray-600 mb-4">Common Unix Printing System - Sistema de impresión estándar en Linux/Unix con IPP</p>
                <div class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full inline-block">
                    Linux/Unix
                </div>
            </div>
        </a>

        <!-- Servidor LPR/LPD -->
        <a href="{{ route('servidor.lpr') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow border-2 border-gray-200 hover:border-orange-400">
            <div class="text-center">
                <div class="text-5xl mb-4">📠</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">LPR/LPD</h3>
                <p class="text-sm text-gray-600 mb-4">Line Printer Remote/Daemon - Protocolo clásico de impresión en Unix/Linux (Puerto 515)</p>
                <div class="bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full inline-block">
                    Protocolo Clásico
                </div>
            </div>
        </a>
    </div>

    <!-- Información adicional -->
    <div class="mt-12 bg-gray-50 rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📚 Información sobre los Tipos de Servidores</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
            <div class="bg-white rounded-lg p-6 border-2 border-gray-300 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-semibold mb-3 text-gray-800 text-center">🔌 Servidor Dedicado (Hardware)</h3>
                <p class="leading-relaxed">Dispositivo físico pequeño y autónomo que se conecta entre la impresora y la red. Ideal para convertir impresoras USB antiguas en impresoras de red.</p>
            </div>
            <div class="bg-white rounded-lg p-6 border-2 border-gray-300 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-semibold mb-3 text-gray-800 text-center">💾 Servidor Software</h3>
                <p class="leading-relaxed">Servicio ejecutándose en un servidor de red. Ofrece máximo control sobre políticas, seguridad y contabilidad de impresión.</p>
            </div>
            <div class="bg-white rounded-lg p-6 border-2 border-gray-300 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-semibold mb-3 text-gray-800 text-center">🖨️ Servidor Integrado</h3>
                <p class="leading-relaxed">La funcionalidad de servidor está incorporada directamente en la impresora. Máxima sencillez, sin hardware adicional.</p>
            </div>
            <div class="bg-white rounded-lg p-6 border-2 border-gray-300 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-semibold mb-3 text-gray-800 text-center">☁️ Servidor Cloud</h3>
                <p class="leading-relaxed">Gestión de impresión a través de servicios en línea. Ideal para trabajo remoto/híbrido sin necesidad de VPN.</p>
            </div>
            <div class="bg-white rounded-lg p-6 border-2 border-gray-300 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-semibold mb-3 text-gray-800 text-center">🐧 CUPS (Common Unix Printing System)</h3>
                <p class="leading-relaxed">Sistema de impresión estándar en Linux/Unix que utiliza IPP (Internet Printing Protocol) sobre HTTP. Gestiona colas, drivers y comunicación con impresoras de forma centralizada.</p>
            </div>
            <div class="bg-white rounded-lg p-6 border-2 border-gray-300 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="font-semibold mb-3 text-gray-800 text-center">📠 LPR/LPD (Line Printer Remote/Daemon)</h3>
                <p class="leading-relaxed">Protocolo clásico de impresión en sistemas Unix/Linux. Usa el puerto 515 y comandos como lpr, lpq, lprm. Es el predecesor de CUPS y aún se usa en sistemas legacy.</p>
            </div>
        </div>
    </div>
</div>
@endsection

