@extends('layouts.app')

@section('title', 'Servidor CUPS')

@section('content')
<div x-data="simulacionApp()" x-init="init()">
    <!-- Header con información del tipo (estilo morado característico de CUPS) -->
    <div class="bg-purple-50 border-l-4 border-purple-400 p-4 mb-6 rounded">
        <div class="flex items-center">
            <div class="text-3xl mr-3">🐧</div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Common Unix Printing System (CUPS)</h1>
                <p class="text-sm text-gray-600 mt-1">Sistema de impresión estándar en Linux/Unix que gestiona colas, drivers y comunicación con impresoras mediante IPP (Internet Printing Protocol).</p>
            </div>
        </div>
        <a href="{{ route('tipo-servidor.index') }}" class="text-sm text-purple-600 hover:text-purple-900 mt-2 inline-block">← Volver a selección de tipos</a>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Total Trabajos</div>
            <div class="text-2xl font-bold text-gray-800">{{ $estadisticas['total_trabajos'] }}</div>
        </div>
        <div class="bg-yellow-100 rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">En Cola</div>
            <div class="text-2xl font-bold text-yellow-800" x-text="estadisticas.en_cola">{{ $estadisticas['en_cola'] }}</div>
        </div>
        <div class="bg-blue-100 rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">En Proceso</div>
            <div class="text-2xl font-bold text-blue-800" x-text="estadisticas.en_proceso">{{ $estadisticas['en_proceso'] }}</div>
        </div>
        <div class="bg-red-100 rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Bloqueados</div>
            <div class="text-2xl font-bold text-red-800" x-text="estadisticas.bloqueados">{{ $estadisticas['bloqueados'] }}</div>
        </div>
        <div class="bg-green-100 rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Terminados</div>
            <div class="text-2xl font-bold text-green-800" x-text="estadisticas.terminados">{{ $estadisticas['terminados'] }}</div>
        </div>
    </div>

    <!-- Visualización específica: Servidor CUPS -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">🐧 Arquitectura: Common Unix Printing System (CUPS)</h2>
        <div id="packet-tracer" class="relative bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg p-8 min-h-[500px] border-2 border-purple-200 overflow-hidden" data-impresoras='@json($impresoras)'>
            <!-- Clientes Linux/Unix (10 computadoras) - Parte superior izquierda -->
            <div class="absolute left-4 top-4" style="z-index: 3;">
                <div class="grid grid-cols-2 gap-2" style="width: 180px;">
                    <template x-for="i in Array.from({length: 10}, (_, i) => i + 1)" :key="i">
                        <div class="bg-white rounded shadow p-2 border border-blue-300 text-center">
                            <div class="text-xs">🐧</div>
                            <div class="text-[8px] font-semibold" x-text="'Linux ' + i"></div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Router/Switch - Centrado verticalmente, 1/4 desde la izquierda -->
            <div class="absolute left-1/4 top-1/2 transform -translate-x-1/2 -translate-y-1/2" style="z-index: 3;">
                <div class="bg-white rounded-lg shadow-lg p-4 border-2 border-green-400 min-w-[120px] text-center">
                    <div class="text-3xl mb-2">🔌</div>
                    <div class="text-xs font-semibold text-gray-700">Router/Switch</div>
                    <div class="text-xs text-gray-500 mt-1">192.168.1.1</div>
                </div>
            </div>

            <!-- Servidor CUPS - Centrado verticalmente, centro horizontal -->
            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2" style="z-index: 3;">
                <div class="bg-purple-100 rounded-lg shadow-lg p-4 border-4 border-purple-500 min-w-[160px] text-center">
                    <div class="text-3xl mb-2">🖥️</div>
                    <div class="text-xs font-bold text-purple-800">Servidor CUPS</div>
                    <div class="text-[10px] text-purple-700 mt-1">Linux / Unix Server</div>
                    <div class="text-[10px] text-purple-600 mt-1">CUPS Daemon (cupsd)</div>
                    <div class="text-[10px] text-purple-600 mt-1">IPP Protocol (Port 631)</div>
                    <div class="text-[10px] text-purple-600 mt-1">Spooler /var/spool/cups</div>
                </div>
            </div>

            <!-- Múltiples Impresoras - Parte superior derecha -->
            <div class="absolute right-4 top-4" style="z-index: 3;">
                <div class="grid grid-cols-2 gap-2" style="width: 200px;">
                    @foreach($impresoras as $impresora)
                        <div class="bg-white rounded shadow p-2 border-2 {{ $impresora->estado === 'funcional' ? 'border-green-400' : ($impresora->estado === 'sin_tinta' ? 'border-yellow-400' : ($impresora->estado === 'sin_hojas' ? 'border-orange-400' : 'border-red-400')) }} text-center relative">
                            <div class="text-xs">{{ $impresora->icono_estado }}</div>
                            <div class="text-[8px] font-semibold">{{ $impresora->nombre }}</div>
                            <div class="absolute top-0 right-0 w-2 h-2 rounded-full {{ $impresora->color_estado }}"></div>
                            <div class="text-[7px] mt-1 {{ $impresora->estado === 'funcional' ? 'text-green-600' : ($impresora->estado === 'sin_tinta' ? 'text-yellow-600' : ($impresora->estado === 'sin_hojas' ? 'text-orange-600' : 'text-red-600')) }}">
                                @if($impresora->estado === 'funcional')
                                    Funcional
                                @elseif($impresora->estado === 'sin_tinta')
                                    Sin Tinta
                                @elseif($impresora->estado === 'sin_hojas')
                                    Sin Hojas
                                @else
                                    Desconectada
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Líneas de conexión -->
            <svg id="network-lines" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 1; width: 100%; height: 100%;"></svg>

            <!-- Paquetes animados -->
            <div id="packet-container" class="absolute inset-0 pointer-events-none" style="z-index: 2; width: 100%; height: 100%;"></div>

            <!-- Estado actual - Parte inferior, centrado -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-purple-50 rounded-lg shadow-lg p-4 border-2 border-purple-300 min-w-[300px]" style="z-index: 4;">
                <div class="text-sm font-semibold text-purple-800 mb-2">Estado de Transmisión (IPP):</div>
                <div class="text-xs text-purple-700" id="packet-status">Esperando trabajo...</div>
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="packet-progress" class="bg-purple-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 p-4 bg-purple-50 rounded-lg">
            <h3 class="font-semibold text-purple-800 mb-2">Características de CUPS:</h3>
            <ul class="text-sm text-purple-700 space-y-1">
                <li>✓ Sistema de impresión estándar en Linux/Unix</li>
                <li>✓ Protocolo IPP (Internet Printing Protocol) sobre HTTP</li>
                <li>✓ Gestión de colas de impresión (/var/spool/cups)</li>
                <li>✓ Drivers y filtros PostScript, PDF, etc.</li>
                <li>✓ Interfaz web de administración (puerto 631)</li>
                <li>✓ Soporte para impresoras de red y locales</li>
                <li>✓ Autenticación y control de acceso</li>
            </ul>
        </div>
    </div>

    <!-- Sección de Terminal CUPS -->
    <div class="bg-black rounded-lg shadow-2xl p-6 mb-6" style="position: relative; z-index: 1; background: #000000;">
        <h2 class="text-xl font-bold mb-4 text-white">💻 Terminal - Comandos CUPS</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Terminal - Ocupa 2 columnas -->
            <div class="lg:col-span-2" x-data="terminalConsole()" x-init="init()" style="position: relative; z-index: 1;">
                <div class="rounded-lg font-mono text-sm terminal-container" style="min-height: 400px; max-height: 500px; overflow: hidden; position: relative; background: #1a1a1a; border: 1px solid #2d2d2d; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);">
                    <!-- Barra de título de terminal estilo macOS -->
                    <div class="flex items-center justify-between px-4 py-2 bg-gray-800 border-b border-gray-700">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="text-gray-400 text-xs font-normal">user@cups-server:~</div>
                    </div>
                    
                    <!-- Contenedor de salida de terminal -->
                    <div id="terminal-output" class="terminal-output space-y-1 text-xs p-4 mb-2" style="max-height: 300px; overflow-y: auto; background: #000000; color: #ffffff;">
                        <!-- El contenido se generará dinámicamente -->
                    </div>
                    
                    <!-- Línea de comando actual con cursor parpadeante -->
                    <div class="flex items-center px-4 py-2 border-t border-gray-800" style="min-height: 28px; background: #000000;">
                        <span class="text-green-400 font-bold">$</span>
                        <span id="current-command-display" class="text-white ml-2 font-normal"></span>
                        <span id="terminal-cursor" class="bg-green-400 w-2 h-4 ml-1 inline-block terminal-cursor" style="vertical-align: middle; background: #00ff00;"></span>
                    </div>
                </div>
            </div>
            
            <!-- Leyenda de Comandos - Ocupa 1 columna -->
            <div class="bg-white rounded-lg p-4 border border-gray-300 shadow-lg" style="max-height: 500px; overflow-y: auto;">
                <h3 class="text-gray-800 font-bold text-sm mb-3 border-b border-gray-300 pb-2">📖 Leyenda de Comandos</h3>
                <div class="space-y-2 text-xs">
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">lpstat -p</div>
                        <div class="text-gray-700">Muestra el estado de todas las impresoras configuradas en el sistema.</div>
                    </div>
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">lpstat -o</div>
                        <div class="text-gray-700">Lista todos los trabajos de impresión en cola o en proceso.</div>
                    </div>
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">lpinfo -v</div>
                        <div class="text-gray-700">Muestra las impresoras de red disponibles usando el protocolo IPP.</div>
                    </div>
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">lpadmin</div>
                        <div class="text-gray-700">Configura una impresora en el sistema CUPS con su URI y driver.</div>
                    </div>
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">cupsctl</div>
                        <div class="text-gray-700">Habilita o deshabilita funciones del servidor CUPS (ej: debug logging).</div>
                    </div>
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">lp</div>
                        <div class="text-gray-700">Envía un documento a la cola de impresión de una impresora específica.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Configuración del Sistema CUPS - Terminal -->
    <div class="bg-black rounded-lg shadow-2xl p-6 mb-6" style="position: relative; z-index: 1; background: #000000;">
        <h2 class="text-xl font-bold mb-4 text-white">📋 Configuración del Sistema - Terminal</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Terminal - Ocupa 2 columnas -->
            <div class="lg:col-span-2" x-data="configTerminalConsole()" x-init="init()" style="position: relative; z-index: 1;">
                <div class="rounded-lg font-mono text-sm terminal-container" style="min-height: 400px; max-height: 500px; overflow: hidden; position: relative; background: #1a1a1a; border: 1px solid #2d2d2d; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);">
                    <!-- Barra de título de terminal estilo macOS -->
                    <div class="flex items-center justify-between px-4 py-2 bg-gray-800 border-b border-gray-700">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="text-gray-400 text-xs font-normal">root@cups-server:~</div>
                    </div>
                    
                    <!-- Contenedor de salida de terminal -->
                    <div id="config-terminal-output" class="terminal-output space-y-1 text-xs p-4 mb-2" style="max-height: 300px; overflow-y: auto; background: #000000; color: #ffffff;">
                        <!-- El contenido se generará dinámicamente -->
                    </div>
                    
                    <!-- Línea de comando actual con cursor parpadeante -->
                    <div class="flex items-center px-4 py-2 border-t border-gray-800" style="min-height: 28px; background: #000000;">
                        <span class="text-green-400 font-bold">#</span>
                        <span id="config-current-command-display" class="text-white ml-2 font-normal"></span>
                        <span id="config-terminal-cursor" class="bg-green-400 w-2 h-4 ml-1 inline-block terminal-cursor" style="vertical-align: middle; background: #00ff00;"></span>
                    </div>
                </div>
            </div>
            
            <!-- Leyenda de Comandos - Ocupa 1 columna -->
            <div class="bg-white rounded-lg p-4 border border-gray-300 shadow-lg" style="max-height: 500px; overflow-y: auto;">
                <h3 class="text-gray-800 font-bold text-sm mb-3 border-b border-gray-300 pb-2">📖 Leyenda de Comandos</h3>
                <div class="space-y-2 text-xs">
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">cat /etc/cups/cupsd.conf</div>
                        <div class="text-gray-700">Muestra el contenido del archivo de configuración principal de CUPS.</div>
                    </div>
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">systemctl status cups</div>
                        <div class="text-gray-700">Verifica el estado del servicio CUPS (activo, inactivo, PID, uptime).</div>
                    </div>
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">cupsctl</div>
                        <div class="text-gray-700">Muestra la configuración actual del servidor CUPS sin editar archivos.</div>
                    </div>
                    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg" style="padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-bottom-left-radius: 0.5rem; border-top-left-radius: 0.5rem;">
                        <div class="text-green-700 font-mono font-bold mb-1.5">lpstat -t</div>
                        <div class="text-gray-700">Muestra información completa del sistema: scheduler, destino por defecto y dispositivos.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir el resto del dashboard -->
    @include('servidores.partials.flujo-trabajos')
</div>

<script>
function simulacionApp() {
    return {
        trabajos: [],
        estadisticas: {
            en_cola: 0,
            en_proceso: 0,
            bloqueados: 0,
            terminados: 0
        },
        intervalId: null,
        trabajoActual: null,
        packetAnimations: [],

        init() {
            this.dibujarLineasRed();
            this.cargarTrabajos();
            this.intervalId = setInterval(() => {
                this.procesarSimulacion();
            }, 2000);
            setInterval(() => {
                this.actualizarVisualizacion();
            }, 500);
            window.addEventListener('resize', () => {
                this.dibujarLineasRed();
            });
        },

        dibujarLineasRed() {
            setTimeout(() => {
                const svg = document.getElementById('network-lines');
                if (!svg) return;
                const container = svg.parentElement;
                if (!container) return;
                const rect = container.getBoundingClientRect();
                const width = rect.width || container.offsetWidth || 800;
                const height = rect.height || container.offsetHeight || 500;
                const routerX = width / 4;
                const servidorX = width / 2;
                const centerY = height / 2;
                const clientX = 200;
                const printerX = width - 200;
                const printerY = 100;
                
                svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
                svg.setAttribute('width', '100%');
                svg.setAttribute('height', '100%');
                svg.innerHTML = '';
                
                // Definir marcador de flecha para CUPS (morado)
                const defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
                const marker = document.createElementNS('http://www.w3.org/2000/svg', 'marker');
                marker.setAttribute('id', 'arrowhead-cups');
                marker.setAttribute('markerWidth', '10');
                marker.setAttribute('markerHeight', '10');
                marker.setAttribute('refX', '9');
                marker.setAttribute('refY', '3');
                marker.setAttribute('orient', 'auto');
                const polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
                polygon.setAttribute('points', '0 0, 10 3, 0 6');
                polygon.setAttribute('fill', '#8b5cf6');
                marker.appendChild(polygon);
                defs.appendChild(marker);
                
                // Marcador de flecha verde para conexión inicial
                const markerGreen = document.createElementNS('http://www.w3.org/2000/svg', 'marker');
                markerGreen.setAttribute('id', 'arrowhead-green');
                markerGreen.setAttribute('markerWidth', '10');
                markerGreen.setAttribute('markerHeight', '10');
                markerGreen.setAttribute('refX', '9');
                markerGreen.setAttribute('refY', '3');
                markerGreen.setAttribute('orient', 'auto');
                const polygonGreen = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
                polygonGreen.setAttribute('points', '0 0, 10 3, 0 6');
                polygonGreen.setAttribute('fill', '#10b981');
                markerGreen.appendChild(polygonGreen);
                defs.appendChild(markerGreen);
                svg.appendChild(defs);
                
                // Línea Clientes -> Router (verde, más gruesa, con flecha)
                const line1 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line1.setAttribute('x1', clientX);
                line1.setAttribute('y1', 100);
                line1.setAttribute('x2', routerX);
                line1.setAttribute('y2', centerY);
                line1.setAttribute('stroke', '#10b981');
                line1.setAttribute('stroke-width', '4');
                line1.setAttribute('stroke-dasharray', '8,4');
                line1.setAttribute('marker-end', 'url(#arrowhead-green)');
                svg.appendChild(line1);
                
                // Etiqueta para línea Clientes -> Router
                const label1Bg = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                label1Bg.setAttribute('x', (clientX + routerX) / 2 - 35);
                label1Bg.setAttribute('y', (100 + centerY) / 2 - 12);
                label1Bg.setAttribute('width', '70');
                label1Bg.setAttribute('height', '16');
                label1Bg.setAttribute('fill', 'white');
                label1Bg.setAttribute('opacity', '0.9');
                label1Bg.setAttribute('rx', '3');
                label1Bg.setAttribute('stroke', '#10b981');
                label1Bg.setAttribute('stroke-width', '1');
                svg.appendChild(label1Bg);
                
                const label1 = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                label1.setAttribute('x', (clientX + routerX) / 2);
                label1.setAttribute('y', (100 + centerY) / 2);
                label1.setAttribute('fill', '#10b981');
                label1.setAttribute('font-size', '10');
                label1.setAttribute('font-weight', 'bold');
                label1.setAttribute('text-anchor', 'middle');
                label1.textContent = 'TCP/IP';
                svg.appendChild(label1);
                
                // Línea Router -> Servidor CUPS (horizontal, morado, más gruesa, con flecha)
                const line2 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line2.setAttribute('x1', routerX);
                line2.setAttribute('y1', centerY);
                line2.setAttribute('x2', servidorX);
                line2.setAttribute('y2', centerY);
                line2.setAttribute('stroke', '#8b5cf6');
                line2.setAttribute('stroke-width', '5');
                line2.setAttribute('stroke-dasharray', '8,4');
                line2.setAttribute('marker-end', 'url(#arrowhead-cups)');
                svg.appendChild(line2);
                
                // Etiqueta para línea Router -> Servidor CUPS
                const label2Bg = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                label2Bg.setAttribute('x', (routerX + servidorX) / 2 - 60);
                label2Bg.setAttribute('y', centerY - 25);
                label2Bg.setAttribute('width', '120');
                label2Bg.setAttribute('height', '18');
                label2Bg.setAttribute('fill', 'white');
                label2Bg.setAttribute('opacity', '0.9');
                label2Bg.setAttribute('rx', '3');
                label2Bg.setAttribute('stroke', '#8b5cf6');
                label2Bg.setAttribute('stroke-width', '1');
                svg.appendChild(label2Bg);
                
                const label2 = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                label2.setAttribute('x', (routerX + servidorX) / 2);
                label2.setAttribute('y', centerY - 10);
                label2.setAttribute('fill', '#8b5cf6');
                label2.setAttribute('font-size', '11');
                label2.setAttribute('font-weight', 'bold');
                label2.setAttribute('text-anchor', 'middle');
                label2.textContent = 'IPP (Port 631)';
                svg.appendChild(label2);
                
                // Línea Servidor CUPS -> Impresoras (hacia la parte superior derecha, con flecha)
                const line3 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line3.setAttribute('x1', servidorX);
                line3.setAttribute('y1', centerY);
                line3.setAttribute('x2', printerX);
                line3.setAttribute('y2', printerY);
                line3.setAttribute('stroke', '#8b5cf6');
                line3.setAttribute('stroke-width', '4');
                line3.setAttribute('stroke-dasharray', '8,4');
                line3.setAttribute('marker-end', 'url(#arrowhead-cups)');
                svg.appendChild(line3);
                
                // Etiqueta para línea Servidor -> Impresoras
                const label3Bg = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                label3Bg.setAttribute('x', (servidorX + printerX) / 2 - 50);
                label3Bg.setAttribute('y', (centerY + printerY) / 2 - 20);
                label3Bg.setAttribute('width', '100');
                label3Bg.setAttribute('height', '16');
                label3Bg.setAttribute('fill', 'white');
                label3Bg.setAttribute('opacity', '0.9');
                label3Bg.setAttribute('rx', '3');
                label3Bg.setAttribute('stroke', '#8b5cf6');
                label3Bg.setAttribute('stroke-width', '1');
                svg.appendChild(label3Bg);
                
                const label3 = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                label3.setAttribute('x', (servidorX + printerX) / 2);
                label3.setAttribute('y', (centerY + printerY) / 2 - 5);
                label3.setAttribute('fill', '#8b5cf6');
                label3.setAttribute('font-size', '10');
                label3.setAttribute('font-weight', 'bold');
                label3.setAttribute('text-anchor', 'middle');
                label3.textContent = 'IPP → Printer';
                svg.appendChild(label3);
            }, 100);
        },

        calcularProgreso(trabajo) {
            if (!trabajo.tiempo_inicio_proceso) return 0;
            const tiempoTotal = trabajo.paginas * 3;
            const tiempoTranscurrido = (new Date() - new Date(trabajo.tiempo_inicio_proceso)) / 1000;
            const progreso = Math.min(100, Math.max(0, (tiempoTranscurrido / tiempoTotal) * 100));
            return Math.round(progreso);
        },

        actualizarVisualizacion() {
            const trabajoEnProceso = this.trabajos.find(t => t.estado === 'En Proceso');
            const trabajoEnviado = this.trabajos.find(t => t.estado === 'Enviado');
            const trabajo = trabajoEnProceso || trabajoEnviado;
            
            if (trabajo && trabajo.id !== (this.trabajoActual?.id)) {
                this.trabajoActual = trabajo;
                this.iniciarAnimacionPaquete(trabajo);
            }
            if (trabajoEnProceso) {
                this.actualizarProgreso(trabajoEnProceso);
            }
        },

        iniciarAnimacionPaquete(trabajo) {
            const container = document.getElementById('packet-container');
            const statusEl = document.getElementById('packet-status');
            if (!container || !statusEl) return;
            container.innerHTML = '';
            
            const packet = document.createElement('div');
            packet.className = 'packet absolute bg-indigo-500 text-white text-xs font-bold rounded-full w-12 h-12 flex items-center justify-center shadow-lg border-2 border-indigo-700';
            packet.style.left = '200px';
            packet.style.top = '100px';
            packet.textContent = '📄';
            container.appendChild(packet);
            
            statusEl.textContent = `Enviando trabajo "${trabajo.descripcion}" desde cliente Linux...`;
            
            const containerEl = container.parentElement;
            const rect = containerEl.getBoundingClientRect();
            const width = rect.width || containerEl.offsetWidth || 800;
            const height = rect.height || containerEl.offsetHeight || 500;
            const routerX = width / 4;
            const servidorX = width / 2;
            const centerY = height / 2;
            const printerX = width - 200;
            const printerY = 100;
            
            let currentX = 200;
            let currentY = 100;
            const targetX = routerX;
            const targetY = centerY;
            const dx = (targetX - currentX) / 30;
            const dy = (targetY - currentY) / 30;
            let step = 0;
            
            const animate = () => {
                if (step < 30) {
                    currentX += dx;
                    currentY += dy;
                    packet.style.left = currentX + 'px';
                    packet.style.top = currentY + 'px';
                    step++;
                    requestAnimationFrame(animate);
                } else {
                    currentX = routerX;
                    currentY = centerY;
                    step = 0;
                    const dx2 = (servidorX - currentX) / 30;
                    const dy2 = (centerY - currentY) / 30;
                    const animate2 = () => {
                        if (step < 30) {
                            currentX += dx2;
                            currentY += dy2;
                            packet.style.left = currentX + 'px';
                            packet.style.top = currentY + 'px';
                            step++;
                            requestAnimationFrame(animate2);
                        } else {
                            statusEl.textContent = `Procesando en CUPS (IPP) - "${trabajo.descripcion}"...`;
                            packet.style.left = servidorX + 'px';
                            packet.style.top = centerY + 'px';
                            setTimeout(() => {
                                const dx3 = (printerX - servidorX) / 30;
                                const dy3 = (printerY - centerY) / 30;
                                step = 0;
                                const animate3 = () => {
                                    if (step < 30) {
                                        currentX += dx3;
                                        currentY += dy3;
                                        packet.style.left = currentX + 'px';
                                        packet.style.top = currentY + 'px';
                                        step++;
                                        requestAnimationFrame(animate3);
                                    } else {
                                        statusEl.textContent = `Imprimiendo en impresora...`;
                                        setTimeout(() => {
                                            container.innerHTML = '';
                                            statusEl.textContent = 'Esperando trabajo...';
                                        }, 1000);
                                    }
                                };
                                animate3();
                            }, 1000);
                        }
                    };
                    animate2();
                }
            };
            animate();
        },

        actualizarProgreso(trabajo) {
            const progreso = this.calcularProgreso(trabajo);
            const progressBar = document.getElementById('packet-progress');
            const statusEl = document.getElementById('packet-status');
            if (progressBar) {
                progressBar.style.width = progreso + '%';
            }
            if (statusEl && trabajo) {
                statusEl.textContent = `Imprimiendo "${trabajo.descripcion}" - ${progreso}% completado`;
            }
        },

        async cargarTrabajos() {
            try {
                const response = await fetch('/api/trabajos');
                const data = await response.json();
                this.trabajos = data;
                this.actualizarEstadisticas();
            } catch (error) {
                console.error('Error cargando trabajos:', error);
            }
        },

        async procesarSimulacion() {
            try {
                const response = await fetch('/api/simulacion/procesar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });
                if (response.ok) {
                    await this.cargarTrabajos();
                }
            } catch (error) {
                console.error('Error procesando simulación:', error);
            }
        },

        actualizarEstadisticas() {
            this.estadisticas.en_cola = this.trabajos.filter(t => t.estado === 'En Cola').length;
            this.estadisticas.en_proceso = this.trabajos.filter(t => t.estado === 'En Proceso').length;
            this.estadisticas.bloqueados = this.trabajos.filter(t => t.estado === 'Bloqueado').length;
            this.estadisticas.terminados = this.trabajos.filter(t => t.estado === 'Terminado').length;
        }
    }
}

function terminalConsole() {
    return {
        currentCommand: '',
        showCursor: true,
        commandIndex: 0,
        charIndex: 0,
        outputContainer: null,
        trabajos: [],
        
        commands: [
            {
                cmd: 'lpstat -p',
                output: [
                    'printer Impresora_1 is idle.  enabled since Mon Nov 14 10:00:00 2025',
                    'printer Impresora_2 is idle.  enabled since Mon Nov 14 10:00:00 2025',
                    'printer Impresora_3 is idle.  enabled since Mon Nov 14 10:00:00 2025',
                    'printer Impresora_4 is idle.  enabled since Mon Nov 14 10:00:00 2025'
                ],
                dynamic: false
            },
            {
                cmd: 'lpstat -o',
                output: [],
                dynamic: true // Se llenará con trabajos reales
            },
            {
                cmd: 'lpinfo -v',
                output: [
                    'network ipp://192.168.1.100:631/ipp/print',
                    'network ipp://192.168.1.101:631/ipp/print',
                    'network ipp://192.168.1.102:631/ipp/print',
                    'network ipp://192.168.1.103:631/ipp/print'
                ],
                dynamic: false
            },
            {
                cmd: 'lpadmin -p Impresora_1 -E -v ipp://192.168.1.100:631/ipp/print -m everywhere',
                output: ['Impresora configurada correctamente'],
                dynamic: false
            },
            {
                cmd: 'cupsctl --debug-logging',
                output: ['Debug logging habilitado'],
                dynamic: false
            },
            {
                cmd: 'lp -d Impresora_1 -n 1 documento.pdf',
                output: [],
                dynamic: true // Se generará dinámicamente
            }
        ],
        
        init() {
            this.outputContainer = document.getElementById('terminal-output');
            this.commandDisplay = document.getElementById('current-command-display');
            this.cursorElement = document.getElementById('terminal-cursor');
            this.isRunning = false; // Flag para evitar múltiples ejecuciones
            
            // Verificar que los elementos existan
            if (!this.outputContainer || !this.commandDisplay || !this.cursorElement) {
                console.error('Elementos del terminal no encontrados');
                return;
            }
            
            this.cursorBlink();
            
            // Cargar trabajos en segundo plano, pero iniciar la terminal de todas formas
            this.cargarTrabajos().catch(err => {
                console.error('Error cargando trabajos:', err);
            });
            
            // Iniciar la terminal después de un breve delay
            if (!this.isRunning) {
                this.isRunning = true;
                setTimeout(() => {
                    this.ejecutarComandos();
                }, 1500);
            }
        },
        
        cursorBlink() {
            setInterval(() => {
                if (this.cursorElement) {
                    this.cursorElement.style.opacity = this.cursorElement.style.opacity === '0' ? '1' : '0';
                }
            }, 530);
        },
        
        async cargarTrabajos() {
            try {
                const response = await fetch('/api/trabajos');
                const data = await response.json();
                this.trabajos = data;
            } catch (error) {
                console.error('Error cargando trabajos:', error);
            }
        },
        
        async ejecutarComandos() {
            // Bucle infinito
            while (true) {
                // Limpiar el terminal
                await this.limpiarTerminal();
                
                // Esperar un momento antes de empezar
                await this.esperar(2000);
                
                for (let i = 0; i < this.commands.length; i++) {
                    this.commandIndex = i;
                    const command = this.commands[i];
                    
                    // Escribir el comando letra por letra (visible en la línea de comando)
                    await this.escribirComando(command.cmd);
                    
                    // Esperar un momento antes de mostrar la salida
                    await this.esperar(1200);
                    
                    // Mostrar la salida (mueve el comando al historial)
                    await this.mostrarSalida(command);
                    
                    // Limpiar la línea de comando
                    this.currentCommand = '';
                    if (this.commandDisplay) {
                        this.commandDisplay.textContent = '';
                    }
                    
                    // Esperar antes del siguiente comando
                    await this.esperar(2000);
                }
                
                // Esperar antes de limpiar y empezar de nuevo
                await this.esperar(3000);
            }
        },
        
        async limpiarTerminal() {
            if (this.outputContainer) {
                // Efecto de limpieza: mostrar comando "clear" primero
                if (this.commandDisplay) {
                    this.commandDisplay.textContent = 'clear';
                    await this.esperar(300);
                }
                
                // Efecto de limpieza: borrar línea por línea desde arriba con fade out
                const lines = Array.from(this.outputContainer.children);
                
                for (let i = 0; i < lines.length; i++) {
                    if (lines[i]) {
                        lines[i].style.opacity = '0';
                        lines[i].style.transition = 'opacity 0.15s ease-out';
                        await this.esperar(30);
                    }
                }
                
                // Esperar un momento para que termine la animación
                await this.esperar(200);
                
                // Remover todas las líneas
                this.outputContainer.innerHTML = '';
                
                // Limpiar también la línea de comando
                this.currentCommand = '';
                if (this.commandDisplay) {
                    this.commandDisplay.textContent = '';
                }
                
                // Pequeña pausa antes de empezar de nuevo
                await this.esperar(500);
            }
        },
        
        async escribirComando(cmd) {
            this.currentCommand = '';
            this.charIndex = 0;
            
            if (this.commandDisplay) {
                this.commandDisplay.textContent = '';
            }
            
            return new Promise((resolve) => {
                const interval = setInterval(() => {
                    if (this.charIndex < cmd.length) {
                        this.currentCommand += cmd[this.charIndex];
                        // Actualizar directamente en el DOM letra por letra
                        if (this.commandDisplay) {
                            this.commandDisplay.textContent = this.currentCommand;
                            // Asegurar que el cursor sea visible
                            if (this.cursorElement) {
                                this.cursorElement.style.opacity = '1';
                            }
                        }
                        this.charIndex++;
                    } else {
                        clearInterval(interval);
                        resolve();
                    }
                }, 60); // Velocidad de escritura: 60ms por carácter (más lento)
            });
        },
        
        async mostrarSalida(command) {
            // Agregar la línea del comando ejecutado
            const commandLine = document.createElement('div');
            commandLine.className = 'mb-1';
            commandLine.style.color = '#00ff00';
            commandLine.innerHTML = `$ <span style="color: #ffffff; font-weight: normal;">${command.cmd}</span>`;
            this.outputContainer.appendChild(commandLine);
            this.scrollToBottom();
            
            // Preparar la salida
            let output = [];
            if (command.dynamic) {
                if (command.cmd === 'lpstat -o') {
                    const trabajosEnCola = this.trabajos.filter(t => t.estado === 'En Cola' || t.estado === 'En Proceso');
                    if (trabajosEnCola.length > 0) {
                        trabajosEnCola.forEach(trabajo => {
                            output.push(`${'Impresora_' + (trabajo.impresora_id || 1)}-${trabajo.id} ${trabajo.usuario?.nombre || 'Usuario'} ${trabajo.paginas} páginas ${trabajo.estado}`);
                        });
                    } else {
                        output.push('No hay trabajos en cola');
                    }
                } else if (command.cmd.startsWith('lp -d')) {
                    output.push(`request id is Impresora_1-${this.trabajos.length + 1} (1 file(s))`);
                }
            } else {
                output = command.output;
            }
            
            // Mostrar la salida línea por línea
            for (let i = 0; i < output.length; i++) {
                await this.esperar(150);
                const outputLine = document.createElement('div');
                outputLine.className = 'mb-1';
                outputLine.style.color = '#cccccc';
                
                // Detectar colores según el contenido (colores de terminal real)
                if (output[i].includes('Impresora_')) {
                    outputLine.innerHTML = this.formatearSalidaTrabajo(output[i]);
                } else if (output[i].includes('network ipp://')) {
                    outputLine.style.color = '#00ffff';
                    outputLine.textContent = output[i];
                } else if (output[i].includes('configurada correctamente')) {
                    outputLine.style.color = '#00ff00';
                    outputLine.textContent = output[i];
                } else if (output[i].includes('habilitado')) {
                    outputLine.style.color = '#ffff00';
                    outputLine.textContent = output[i];
                } else if (output[i].includes('request id')) {
                    outputLine.style.color = '#0088ff';
                    outputLine.textContent = output[i];
                } else if (output[i].includes('printer') && output[i].includes('is idle')) {
                    outputLine.style.color = '#cccccc';
                    outputLine.textContent = output[i];
                } else {
                    outputLine.style.color = '#cccccc';
                    outputLine.textContent = output[i];
                }
                
                // Verificar que no exista ya esta línea antes de agregarla
                const existingLines = Array.from(this.outputContainer.children);
                const isDuplicate = existingLines.some(line => {
                    const existingText = line.textContent.trim();
                    const newText = outputLine.textContent.trim();
                    return existingText === newText && existingText !== '';
                });
                
                if (!isDuplicate) {
                    this.outputContainer.appendChild(outputLine);
                    this.scrollToBottom();
                }
            }
            
            // Agregar espacio después de cada comando
            const spacer = document.createElement('div');
            spacer.className = 'mb-1';
            spacer.style.height = '4px';
            this.outputContainer.appendChild(spacer);
            this.scrollToBottom();
        },
        
        scrollToBottom() {
            if (this.outputContainer) {
                this.outputContainer.scrollTop = this.outputContainer.scrollHeight;
            }
        },
        
        formatearSalidaTrabajo(linea) {
            // Formatear la salida de lpstat -o con colores de terminal real
            const partes = linea.split(' ');
            let html = '';
            partes.forEach((parte, index) => {
                if (parte.includes('Impresora_')) {
                    html += `<span style="color: #ffffff;">${parte}</span> `;
                } else if (parte.match(/^\d+$/)) {
                    html += `<span style="color: #0088ff;">${parte}</span> `;
                } else if (parte === 'páginas') {
                    html += `<span style="color: #0088ff;">${parte}</span> `;
                } else if (parte === 'En' || parte === 'Cola' || parte === 'Proceso') {
                    html += `<span style="color: #ffff00;">${parte}</span> `;
                } else {
                    html += `<span style="color: #cccccc;">${parte}</span> `;
                }
            });
            return html;
        },
        
        esperar(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
    }
}

function configTerminalConsole() {
    return {
        currentCommand: '',
        showCursor: true,
        commandIndex: 0,
        charIndex: 0,
        outputContainer: null,
        commandDisplay: null,
        cursorElement: null,
        
        commands: [
            {
                cmd: 'cat /etc/cups/cupsd.conf',
                output: [
                    '# Configuración del servidor CUPS',
                    'Listen localhost:631',
                    'Listen *:631',
                    'LogLevel info',
                    'MaxJobs 100',
                    'MaxJobsPerUser 50',
                    'DefaultShared Yes',
                    'WebInterface Yes'
                ],
                dynamic: false
            },
            {
                cmd: 'systemctl status cups',
                output: [
                    '● cups.service - CUPS Scheduler',
                    '   Loaded: loaded (/lib/systemd/system/cups.service; enabled; vendor preset: enabled)',
                    '   Active: active (running) since Mon 2025-11-14 10:00:00 UTC; 7h 23min ago',
                    '     Docs: man:cupsd(8)',
                    '  Process: 1234 ExecStart=/usr/sbin/cupsd -l (code=exited, status=0/SUCCESS)',
                    ' Main PID: 1234 (cupsd)',
                    '    Tasks: 3 (limit: 4915)',
                    '   Memory: 12.5M',
                    '   CGroup: /system.slice/cups.service'
                ],
                dynamic: false
            },
            {
                cmd: 'cupsctl',
                output: [
                    'AuthInfoRequired negotiate',
                    'BrowseLocalProtocols dnssd',
                    'BrowseRemoteProtocols dnssd',
                    'DefaultEncryption Never',
                    'DefaultShared Yes',
                    'MaxJobs 100',
                    'MaxJobsPerUser 50',
                    'WebInterface Yes'
                ],
                dynamic: false
            },
            {
                cmd: 'lpstat -t',
                output: [
                    'scheduler is running',
                    'system default destination: Impresora_1',
                    'device for Impresora_1: ipp://192.168.1.100:631/ipp/print',
                    'device for Impresora_2: ipp://192.168.1.101:631/ipp/print',
                    'device for Impresora_3: ipp://192.168.1.102:631/ipp/print',
                    'device for Impresora_4: ipp://192.168.1.103:631/ipp/print'
                ],
                dynamic: true
            }
        ],
        
        init() {
            this.outputContainer = document.getElementById('config-terminal-output');
            this.commandDisplay = document.getElementById('config-current-command-display');
            this.cursorElement = document.getElementById('config-terminal-cursor');
            this.isRunning = false; // Flag para evitar múltiples ejecuciones
            this.cursorBlink();
            if (!this.isRunning) {
                this.isRunning = true;
                setTimeout(() => this.ejecutarComandos(), 1500);
            }
        },
        
        cursorBlink() {
            setInterval(() => {
                if (this.cursorElement) {
                    this.cursorElement.style.opacity = this.cursorElement.style.opacity === '0' ? '1' : '0';
                }
            }, 530);
        },
        
        async ejecutarComandos() {
            // Bucle infinito
            while (true) {
                // Limpiar el terminal
                await this.limpiarTerminal();
                
                // Esperar un momento antes de empezar
                await this.esperar(2000);
                
                for (let i = 0; i < this.commands.length; i++) {
                    this.commandIndex = i;
                    const command = this.commands[i];
                    
                    // Escribir el comando letra por letra
                    await this.escribirComando(command.cmd);
                    
                    // Esperar un momento antes de mostrar la salida
                    await this.esperar(1200);
                    
                    // Mostrar la salida
                    await this.mostrarSalida(command);
                    
                    // Limpiar la línea de comando
                    this.currentCommand = '';
                    if (this.commandDisplay) {
                        this.commandDisplay.textContent = '';
                    }
                    
                    // Esperar antes del siguiente comando
                    await this.esperar(2000);
                }
                
                // Esperar antes de limpiar y empezar de nuevo
                await this.esperar(3000);
            }
        },
        
        async limpiarTerminal() {
            if (this.outputContainer) {
                // Efecto de limpieza: mostrar comando "clear" primero
                if (this.commandDisplay) {
                    this.commandDisplay.textContent = 'clear';
                    await this.esperar(300);
                }
                
                // Efecto de limpieza: borrar línea por línea desde arriba con fade out
                const lines = Array.from(this.outputContainer.children);
                
                for (let i = 0; i < lines.length; i++) {
                    if (lines[i]) {
                        lines[i].style.opacity = '0';
                        lines[i].style.transition = 'opacity 0.15s ease-out';
                        await this.esperar(30);
                    }
                }
                
                // Esperar un momento para que termine la animación
                await this.esperar(200);
                
                // Remover todas las líneas
                this.outputContainer.innerHTML = '';
                
                // Limpiar también la línea de comando
                this.currentCommand = '';
                if (this.commandDisplay) {
                    this.commandDisplay.textContent = '';
                }
                
                // Pequeña pausa antes de empezar de nuevo
                await this.esperar(500);
            }
        },
        
        async escribirComando(cmd) {
            this.currentCommand = '';
            this.charIndex = 0;
            
            if (this.commandDisplay) {
                this.commandDisplay.textContent = '';
            }
            
            return new Promise((resolve) => {
                const interval = setInterval(() => {
                    if (this.charIndex < cmd.length) {
                        this.currentCommand += cmd[this.charIndex];
                        // Actualizar directamente en el DOM letra por letra
                        if (this.commandDisplay) {
                            this.commandDisplay.textContent = this.currentCommand;
                            // Asegurar que el cursor sea visible
                            if (this.cursorElement) {
                                this.cursorElement.style.opacity = '1';
                            }
                        }
                        this.charIndex++;
                    } else {
                        clearInterval(interval);
                        resolve();
                    }
                }, 60); // Velocidad de escritura: 60ms por carácter (más lento)
            });
        },
        
        async mostrarSalida(command) {
            // Agregar la línea del comando ejecutado
            const commandLine = document.createElement('div');
            commandLine.className = 'mb-1';
            commandLine.style.color = '#00ff00';
            commandLine.innerHTML = `# <span style="color: #ffffff; font-weight: normal;">${command.cmd}</span>`;
            this.outputContainer.appendChild(commandLine);
            this.scrollToBottom();
            
            // Preparar la salida
            let output = [];
            if (command.dynamic) {
                if (command.cmd === 'lpstat -t') {
                    output.push('scheduler is running');
                    output.push('system default destination: Impresora_1');
                    // Agregar impresoras dinámicamente leyendo desde atributo data (evita mezclar Blade/PHP dentro del JS)
                    let impresoras = [];
                    const impresorasDataEl = document.getElementById('packet-tracer');
                    if (impresorasDataEl && impresorasDataEl.dataset.impresoras) {
                        try {
                            impresoras = JSON.parse(impresorasDataEl.dataset.impresoras);
                        } catch (e) {
                            impresoras = [];
                        }
                    }
                    impresoras.forEach(impresora => {
                        output.push(`device for ${impresora.nombre}: ipp://192.168.1.${100 + impresora.id}:631/ipp/print`);
                    });
                } else {
                    output = command.output;
                }
            } else {
                output = command.output;
            }
            
            // Mostrar la salida línea por línea
            for (let i = 0; i < output.length; i++) {
                await this.esperar(150);
                const outputLine = document.createElement('div');
                outputLine.className = 'mb-1';
                outputLine.style.color = '#cccccc';
                
                // Detectar colores según el contenido (colores de terminal real)
                if (output[i].startsWith('#')) {
                    outputLine.style.color = '#00ff00';
                    outputLine.textContent = output[i];
                } else if (output[i].includes('Active: active')) {
                    outputLine.style.color = '#00ff00';
                    outputLine.textContent = output[i];
                } else if (output[i].includes('Active: inactive')) {
                    outputLine.style.color = '#ff0000';
                    outputLine.textContent = output[i];
                } else if (output[i].includes('device for')) {
                    outputLine.style.color = '#00ffff';
                    outputLine.textContent = output[i];
                } else if (output[i].includes('scheduler is running')) {
                    outputLine.style.color = '#00ff00';
                    outputLine.textContent = output[i];
                } else if (output[i].includes('Yes') || output[i].includes('Never')) {
                    outputLine.style.color = '#ffff00';
                    outputLine.textContent = output[i];
                } else {
                    outputLine.style.color = '#cccccc';
                    outputLine.textContent = output[i];
                }
                
                // Verificar que no exista ya esta línea antes de agregarla
                const existingLines = Array.from(this.outputContainer.children);
                const isDuplicate = existingLines.some(line => {
                    const existingText = line.textContent.trim();
                    const newText = outputLine.textContent.trim();
                    return existingText === newText && existingText !== '';
                });
                
                if (!isDuplicate) {
                    this.outputContainer.appendChild(outputLine);
                    this.scrollToBottom();
                }
            }
            
            // Agregar espacio después de cada comando
            const spacer = document.createElement('div');
            spacer.className = 'mb-1';
            spacer.style.height = '4px';
            this.outputContainer.appendChild(spacer);
            this.scrollToBottom();
        },
        
        scrollToBottom() {
            if (this.outputContainer) {
                this.outputContainer.scrollTop = this.outputContainer.scrollHeight;
            }
        },
        
        esperar(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
    }
}
</script>
@endsection

