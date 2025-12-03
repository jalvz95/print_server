<?php $__env->startSection('title', 'Servidor Básico'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="simulacionApp()" x-init="init()">
    <!-- Header con información del tipo -->
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded">
        <div class="flex items-center">
            <div class="text-3xl mr-3">🖥️</div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Servidor de Impresión Básico</h1>
                <p class="text-sm text-gray-600 mt-1">Simulación básica de servidor de impresión con arquitectura cliente-servidor tradicional.</p>
            </div>
        </div>
        <a href="<?php echo e(route('tipo-servidor.index')); ?>" class="text-sm text-blue-600 hover:text-blue-800 mt-2 inline-block">← Volver a selección de tipos</a>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Total Trabajos</div>
            <div class="text-2xl font-bold text-gray-800"><?php echo e($estadisticas['total_trabajos']); ?></div>
        </div>
        <div class="bg-yellow-100 rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">En Cola</div>
            <div class="text-2xl font-bold text-yellow-800" x-text="estadisticas.en_cola"><?php echo e($estadisticas['en_cola']); ?></div>
        </div>
        <div class="bg-blue-100 rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">En Proceso</div>
            <div class="text-2xl font-bold text-blue-800" x-text="estadisticas.en_proceso"><?php echo e($estadisticas['en_proceso']); ?></div>
        </div>
        <div class="bg-red-100 rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Bloqueados</div>
            <div class="text-2xl font-bold text-red-800" x-text="estadisticas.bloqueados"><?php echo e($estadisticas['bloqueados']); ?></div>
        </div>
        <div class="bg-green-100 rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Terminados</div>
            <div class="text-2xl font-bold text-green-800" x-text="estadisticas.terminados"><?php echo e($estadisticas['terminados']); ?></div>
        </div>
    </div>

    <!-- Visualización de Red -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">🌐 Visualización de Red (Simulación)</h2>
        <div id="packet-tracer" class="relative bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-8 min-h-[400px] border-2 border-blue-200 overflow-hidden">
            <!-- Cliente/PC -->
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2" style="z-index: 3;">
                <div class="bg-white rounded-lg shadow-lg p-4 border-2 border-blue-400 min-w-[120px] text-center">
                    <div class="text-3xl mb-2">💻</div>
                    <div class="text-xs font-semibold text-gray-700">PC Cliente</div>
                    <div class="text-xs text-gray-500 mt-1" x-text="trabajoActual ? trabajoActual.usuario.nombre : 'Esperando...'"></div>
                </div>
            </div>

            <!-- Router/Switch -->
            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2" style="z-index: 3;">
                <div class="bg-white rounded-lg shadow-lg p-4 border-2 border-green-400 min-w-[100px] text-center">
                    <div class="text-3xl mb-2">🔌</div>
                    <div class="text-xs font-semibold text-gray-700">Router</div>
                    <div class="text-xs text-gray-500 mt-1">192.168.1.1</div>
                </div>
            </div>

            <!-- Impresora -->
            <div class="absolute right-4 top-1/2 transform -translate-y-1/2" style="z-index: 3;">
                <div class="bg-white rounded-lg shadow-lg p-4 border-2 border-purple-400 min-w-[120px] text-center">
                    <div class="text-3xl mb-2">🖨️</div>
                    <div class="text-xs font-semibold text-gray-700">Impresora</div>
                    <div class="text-xs text-gray-500 mt-1">HP LaserJet</div>
                </div>
            </div>

            <!-- Líneas de conexión -->
            <svg id="network-lines" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 1;"></svg>

            <!-- Paquetes animados -->
            <div id="packet-container" class="absolute inset-0 pointer-events-none" style="z-index: 2;"></div>

            <!-- Estado actual -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-white rounded-lg shadow-lg p-4 border-2 border-gray-300 min-w-[300px]" style="z-index: 4;">
                <div class="text-sm font-semibold text-gray-700 mb-2">Estado de Transmisión:</div>
                <div class="text-xs text-gray-600" id="packet-status">Esperando trabajo...</div>
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="packet-progress" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 p-4 bg-blue-50 rounded-lg border-2 border-blue-200">
            <h3 class="font-semibold text-blue-800 mb-2">Características del Servidor Básico:</h3>
            <ul class="text-sm text-blue-700 space-y-1">
                <li>✓ Arquitectura cliente-servidor tradicional</li>
                <li>✓ Conexión directa a través de red LAN</li>
                <li>✓ Ideal para entornos de oficina pequeños</li>
                <li>✓ Gestión centralizada de impresión</li>
            </ul>
        </div>
    </div>

    <!-- Incluir el flujo de trabajos -->
    <?php echo $__env->make('servidores.partials.flujo-trabajos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                const width = container.offsetWidth || 800;
                const height = container.offsetHeight || 400;
                const centerX = width / 2;
                const centerY = height / 2;
                const clientX = 140;
                const printerX = width - 140;
                
                svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
                svg.setAttribute('width', '100%');
                svg.setAttribute('height', '100%');
                svg.innerHTML = '';
                
                // Agregar estilos de animación dentro del SVG
                const style = document.createElementNS('http://www.w3.org/2000/svg', 'style');
                style.textContent = `
                    .network-line {
                        stroke-width: 3;
                        stroke-dasharray: 10, 5;
                        opacity: 0.8;
                        animation: dashFlow 1s linear infinite;
                    }
                    @keyframes dashFlow {
                        from { stroke-dashoffset: 15; }
                        to { stroke-dashoffset: 0; }
                    }
                `;
                svg.appendChild(style);
                
                // Línea Cliente -> Router
                const line1 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line1.setAttribute('class', 'network-line');
                line1.setAttribute('x1', clientX);
                line1.setAttribute('y1', centerY);
                line1.setAttribute('x2', centerX);
                line1.setAttribute('y2', centerY);
                line1.setAttribute('stroke', '#3b82f6');
                svg.appendChild(line1);
                
                // Línea Router -> Impresora
                const line2 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line2.setAttribute('class', 'network-line');
                line2.setAttribute('x1', centerX);
                line2.setAttribute('y1', centerY);
                line2.setAttribute('x2', printerX);
                line2.setAttribute('y2', centerY);
                line2.setAttribute('stroke', '#8b5cf6');
                svg.appendChild(line2);
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
            packet.className = 'packet absolute bg-blue-500 text-white text-xs font-bold rounded-full w-12 h-12 flex items-center justify-center shadow-lg border-2 border-blue-700';
            packet.style.left = '140px';
            packet.style.top = '50%';
            packet.style.transform = 'translateY(-50%)';
            packet.textContent = '📄';
            container.appendChild(packet);

            statusEl.textContent = `📤 Enviando: ${trabajo.descripcion}...`;
            this.animarPaquete(packet, '140px', '50%', '50%', '50%', 1500, () => {
                statusEl.textContent = `🔌 Pasando por Router: ${trabajo.descripcion}...`;
                this.animarPaquete(packet, '50%', '50%', 'calc(100% - 140px)', '50%', 1500, () => {
                    statusEl.textContent = `🖨️ Imprimiendo: ${trabajo.descripcion}...`;
                    packet.style.background = 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)';
                    packet.textContent = '🖨️';
                });
            });
        },

        animarPaquete(element, fromX, fromY, toX, toY, duration, callback) {
            element.style.left = fromX;
            element.style.top = fromY;
            element.style.transition = `all ${duration}ms ease-in-out`;
            setTimeout(() => {
                element.style.left = toX;
                element.style.top = toY;
            }, 50);
            if (callback) {
                setTimeout(callback, duration);
            }
        },

        actualizarProgreso(trabajo) {
            const progreso = this.calcularProgreso(trabajo);
            const progressBar = document.getElementById('packet-progress');
            const statusEl = document.getElementById('packet-status');
            if (progressBar) progressBar.style.width = progreso + '%';
            if (statusEl && trabajo) {
                statusEl.textContent = `Procesando: ${trabajo.descripcion} (${progreso}%)`;
            }
        },

        async cargarTrabajos() {
            try {
                const response = await fetch('/api/simulacion/estado');
                const data = await response.json();
                this.trabajos = data;
                this.actualizarEstadisticas();
            } catch (error) {
                console.error('Error al cargar trabajos:', error);
            }
        },

        async procesarSimulacion() {
            try {
                await fetch('/api/simulacion/procesar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });
                await this.cargarTrabajos();
            } catch (error) {
                console.error('Error al procesar simulación:', error);
            }
        },

        actualizarEstadisticas() {
            this.estadisticas.en_cola = this.trabajos.filter(t => t.estado === 'En Cola').length;
            this.estadisticas.en_proceso = this.trabajos.filter(t => t.estado === 'En Proceso').length;
            this.estadisticas.bloqueados = this.trabajos.filter(t => t.estado === 'Bloqueado').length;
            this.estadisticas.terminados = this.trabajos.filter(t => t.estado === 'Terminado').length;
            this.actualizarCuotasUsuarios();
        },

        async actualizarCuotasUsuarios() {
            try {
                const response = await fetch('/api/usuarios');
                const usuarios = await response.json();
                usuarios.forEach(usuario => {
                    const elemento = document.getElementById(`cuota-${usuario.id}`);
                    if (elemento) {
                        elemento.textContent = usuario.cuota_actual;
                    }
                });
            } catch (error) {
                console.error('Error al actualizar cuotas:', error);
            }
        }
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/servidores/basico.blade.php ENDPATH**/ ?>