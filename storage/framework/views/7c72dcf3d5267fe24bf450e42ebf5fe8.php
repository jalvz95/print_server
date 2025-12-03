<?php $__env->startSection('title', 'Servidor Dedicado (Hardware)'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="simulacionApp()" x-init="init()">
    <!-- Header con información del tipo -->
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded">
        <div class="flex items-center">
            <div class="text-3xl mr-3">🔌</div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Servidor de Impresión Dedicado (Hardware)</h1>
                <p class="text-sm text-gray-600 mt-1">Dispositivo físico autónomo que convierte impresoras USB en impresoras de red. Independiente de cualquier PC.</p>
            </div>
        </div>
        <a href="<?php echo e(route('tipo-servidor.index')); ?>" class="text-sm text-green-600 hover:text-green-800 mt-2 inline-block">← Volver a selección de tipos</a>
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

    <!-- Visualización específica: Servidor Dedicado -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">🔌 Arquitectura: Servidor Dedicado (Hardware)</h2>
        <div id="packet-tracer" class="relative bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-8 min-h-[500px] border-2 border-green-200 overflow-hidden">
            <!-- Múltiples PCs (10 computadoras) - Posicionadas en la parte superior izquierda -->
            <div class="absolute left-4 top-4" style="z-index: 3;">
                <div class="grid grid-cols-2 gap-2" style="width: 180px;">
                    <template x-for="i in Array.from({length: 10}, (_, i) => i + 1)" :key="i">
                        <div class="bg-white rounded shadow p-2 border border-blue-300 text-center">
                            <div class="text-xs">💻</div>
                            <div class="text-[8px] font-semibold" x-text="'PC' + i"></div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Router/Switch - Centrado verticalmente, 1/3 desde la izquierda -->
            <div class="absolute left-1/4 top-1/2 transform -translate-x-1/2 -translate-y-1/2" style="z-index: 3;">
                <div class="bg-white rounded-lg shadow-lg p-4 border-2 border-green-400 min-w-[120px] text-center">
                    <div class="text-3xl mb-2">🔌</div>
                    <div class="text-xs font-semibold text-gray-700">Router/Switch</div>
                    <div class="text-xs text-gray-500 mt-1">192.168.1.1</div>
                </div>
            </div>

            <!-- Servidor Dedicado (Hardware) - Centrado verticalmente, 2/3 desde la izquierda -->
            <div class="absolute left-2/3 top-1/2 transform -translate-x-1/2 -translate-y-1/2" style="z-index: 3;">
                <div class="bg-green-100 rounded-lg shadow-lg p-4 border-4 border-green-500 min-w-[140px] text-center">
                    <div class="text-3xl mb-2">📦</div>
                    <div class="text-xs font-bold text-green-800">Servidor Dedicado</div>
                    <div class="text-[10px] text-green-700 mt-1">Hardware Autónomo</div>
                    <div class="text-[10px] text-green-600 mt-1">USB → Ethernet</div>
                </div>
            </div>

            <!-- Impresora USB - Derecha, centrada verticalmente -->
            <div class="absolute right-4 top-1/2 transform -translate-y-1/2" style="z-index: 3;">
                <div class="bg-white rounded-lg shadow-lg p-4 border-2 border-purple-400 min-w-[120px] text-center">
                    <div class="text-3xl mb-2">🖨️</div>
                    <div class="text-xs font-semibold text-gray-700">Impresora USB</div>
                    <div class="text-xs text-gray-500 mt-1">Conectada vía USB</div>
                </div>
            </div>

            <!-- Líneas de conexión -->
            <svg id="network-lines" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 1;"></svg>

            <!-- Paquetes animados -->
            <div id="packet-container" class="absolute inset-0 pointer-events-none" style="z-index: 2;"></div>

            <!-- Estado actual - Parte inferior, centrado -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-white rounded-lg shadow-lg p-4 border-2 border-gray-300 min-w-[300px]" style="z-index: 4;">
                <div class="text-sm font-semibold text-gray-700 mb-2">Estado de Transmisión:</div>
                <div class="text-xs text-gray-600" id="packet-status">Esperando trabajo...</div>
                <div class="mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="packet-progress" class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 p-4 bg-green-50 rounded-lg border-2 border-green-300">
            <h3 class="font-semibold text-green-800 mb-2">Características del Servidor Dedicado:</h3>
            <ul class="text-sm text-green-700 space-y-1">
                <li>✓ Dispositivo físico pequeño y autónomo</li>
                <li>✓ Conecta impresoras USB a la red</li>
                <li>✓ No requiere PC o servidor adicional</li>
                <li>✓ Ideal para impresoras antiguas sin conexión de red</li>
            </ul>
        </div>
    </div>

    <!-- Incluir el resto del dashboard (flujo de trabajos, etc.) -->
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
                const routerX = width / 4;
                const servidorX = (width * 2) / 3;
                const centerY = height / 2;
                const clientX = 200;
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
                
                // Línea PCs -> Router
                const line1 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line1.setAttribute('class', 'network-line');
                line1.setAttribute('x1', clientX);
                line1.setAttribute('y1', centerY);
                line1.setAttribute('x2', routerX);
                line1.setAttribute('y2', centerY);
                line1.setAttribute('stroke', '#10b981');
                svg.appendChild(line1);
                
                // Línea Router -> Servidor Dedicado
                const line2 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line2.setAttribute('class', 'network-line');
                line2.setAttribute('x1', routerX);
                line2.setAttribute('y1', centerY);
                line2.setAttribute('x2', servidorX);
                line2.setAttribute('y2', centerY);
                line2.setAttribute('stroke', '#10b981');
                svg.appendChild(line2);
                
                // Línea Servidor Dedicado -> Impresora (USB)
                const line3 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line3.setAttribute('class', 'network-line');
                line3.setAttribute('x1', servidorX);
                line3.setAttribute('y1', centerY);
                line3.setAttribute('x2', printerX);
                line3.setAttribute('y2', centerY);
                line3.setAttribute('stroke', '#8b5cf6');
                svg.appendChild(line3);
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
            packet.className = 'packet absolute bg-green-500 text-white text-xs font-bold rounded-full w-12 h-12 flex items-center justify-center shadow-lg border-2 border-green-700';
            packet.style.left = '200px';
            packet.style.top = '50%';
            packet.style.transform = 'translateY(-50%)';
            packet.textContent = '📄';
            container.appendChild(packet);

            statusEl.textContent = `📤 Enviando desde PC: ${trabajo.descripcion}...`;
            this.animarPaquete(packet, '200px', '50%', '25%', '50%', 1500, () => {
                statusEl.textContent = `🔌 Pasando por Router: ${trabajo.descripcion}...`;
                this.animarPaquete(packet, '25%', '50%', '66.66%', '50%', 1500, () => {
                    statusEl.textContent = `📦 Procesando en Servidor Dedicado: ${trabajo.descripcion}...`;
                    packet.style.left = '66.66%';
                    packet.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                    packet.textContent = '⚙️';
                    if (trabajo.estado === 'En Proceso') {
                        this.animarPaquete(packet, '66.66%', '50%', 'calc(100% - 140px)', '50%', 1000, () => {
                            statusEl.textContent = `🖨️ Imprimiendo: ${trabajo.descripcion}...`;
                        });
                    }
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/servidores/dedicado.blade.php ENDPATH**/ ?>