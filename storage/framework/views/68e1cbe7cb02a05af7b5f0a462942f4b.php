<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="simulacionApp()" x-init="init()">
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

    <!-- Visualización Packet Tracer -->
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

            <!-- Servidor -->
            <div class="absolute right-4 top-1/2 transform -translate-y-1/2" style="z-index: 3;">
                <div class="bg-white rounded-lg shadow-lg p-4 border-2 border-purple-400 min-w-[120px] text-center">
                    <div class="text-3xl mb-2">🖥️</div>
                    <div class="text-xs font-semibold text-gray-700">Servidor</div>
                    <div class="text-xs text-gray-500 mt-1">Print Server</div>
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
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Panel de Flujo de Trabajos -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Flujo de Trabajos</h2>
                
                <!-- Envío -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">📤 Envío</h3>
                    <div class="space-y-2" id="envio-list">
                        <template x-for="trabajo in trabajos.filter(t => t.estado === 'Enviado')" :key="trabajo.id">
                            <div class="bg-gray-100 p-3 rounded border-l-4 border-gray-400">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold" x-text="trabajo.descripcion"></span>
                                        <span class="text-sm text-gray-600 ml-2" x-text="trabajo.usuario.nombre"></span>
                                    </div>
                                    <span class="px-2 py-1 bg-gray-400 text-white text-xs rounded" x-text="trabajo.estado"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Cola -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">📋 Cola de Impresión</h3>
                    <div class="space-y-2 min-h-[100px]" id="cola-list">
                        <template x-for="trabajo in trabajos.filter(t => t.estado === 'En Cola').sort((a, b) => b.prioridad - a.prioridad || new Date(a.tiempo_envio) - new Date(b.tiempo_envio))" :key="trabajo.id">
                            <div class="bg-yellow-100 p-3 rounded border-l-4 border-yellow-400">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold" x-text="trabajo.descripcion"></span>
                                        <div class="text-xs text-gray-600 mt-1">
                                            <span x-text="trabajo.paginas + ' páginas'"></span>
                                            <span x-text="trabajo.es_color ? ' | Color' : ' | B/N'" class="ml-2"></span>
                                            <span class="ml-2" x-text="'Prioridad: ' + trabajo.prioridad"></span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 bg-yellow-400 text-white text-xs rounded" x-text="trabajo.estado"></span>
                                </div>
                            </div>
                        </template>
                        <div x-show="trabajos.filter(t => t.estado === 'En Cola').length === 0" class="text-gray-400 text-center py-4">
                            Cola vacía
                        </div>
                    </div>
                </div>

                <!-- Impresora (En Proceso) -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">🖨️ Impresora (En Proceso)</h3>
                    <div class="min-h-[80px]" id="proceso-list">
                        <template x-for="trabajo in trabajos.filter(t => t.estado === 'En Proceso')" :key="trabajo.id">
                            <div class="bg-blue-100 p-4 rounded border-l-4 border-blue-400">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold" x-text="trabajo.descripcion"></span>
                                        <div class="text-xs text-gray-600 mt-1">
                                            <span x-text="trabajo.usuario.nombre"></span>
                                            <span class="ml-2" x-text="trabajo.paginas + ' páginas'"></span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1" x-text="'Tiempo estimado: ' + (trabajo.paginas * 3).toFixed(1) + 's'"></div>
                                        <div class="text-xs text-blue-600 mt-1" x-show="trabajo.estado === 'En Proceso'" x-text="'Progreso: ' + calcularProgreso(trabajo) + '%'"></div>
                                    </div>
                                    <span class="px-2 py-1 bg-blue-400 text-white text-xs rounded" x-text="trabajo.estado"></span>
                                </div>
                            </div>
                        </template>
                        <div x-show="trabajos.filter(t => t.estado === 'En Proceso').length === 0" class="text-gray-400 text-center py-4">
                            Impresora inactiva
                        </div>
                    </div>
                </div>

                <!-- Historial -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">📜 Historial</h3>
                    <div class="space-y-2 max-h-64 overflow-y-auto" id="historial-list">
                        <template x-for="trabajo in trabajos.filter(t => t.estado === 'Terminado' || t.estado === 'Bloqueado').slice(0, 10)" :key="trabajo.id">
                            <div :class="trabajo.estado === 'Terminado' ? 'bg-green-100 border-green-400' : 'bg-red-100 border-red-400'" class="p-3 rounded border-l-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold" x-text="trabajo.descripcion"></span>
                                        <div class="text-xs text-gray-600 mt-1" x-text="trabajo.motivo_bloqueo || ''"></div>
                                    </div>
                                    <span :class="trabajo.estado === 'Terminado' ? 'bg-green-400' : 'bg-red-400'" class="px-2 py-1 text-white text-xs rounded" x-text="trabajo.estado"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral: Usuarios -->
        <div>
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Usuarios</h2>
                <div class="space-y-3">
                    <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center p-2 <?php echo e($usuario->activo ? 'bg-gray-50' : 'bg-gray-200'); ?> rounded">
                        <div>
                            <div class="font-semibold"><?php echo e($usuario->nombre); ?></div>
                            <div class="text-xs text-gray-600">
                                Cuota: <span class="font-semibold" id="cuota-<?php echo e($usuario->id); ?>"><?php echo e($usuario->cuota_actual); ?></span>
                            </div>
                        </div>
                        <span class="px-2 py-1 <?php echo e($usuario->activo ? 'bg-green-400' : 'bg-gray-400'); ?> text-white text-xs rounded">
                            <?php echo e($usuario->activo ? 'Activo' : 'Inactivo'); ?>

                        </span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Acciones Rápidas</h2>
                <div class="space-y-2">
                    <a href="<?php echo e(route('trabajos.create', ['return_to' => 'dashboard'])); ?>" class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded">
                        Enviar Nueva Impresión
                    </a>
                    <a href="<?php echo e(route('reglas.index')); ?>" class="block w-full bg-gray-500 hover:bg-gray-600 text-white text-center py-2 px-4 rounded">
                        Gestionar Reglas
                    </a>
                </div>
            </div>
        </div>
    </div>
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
            // Procesar simulación cada 2 segundos
            this.intervalId = setInterval(() => {
                this.procesarSimulacion();
            }, 2000);
            // Actualizar visualización cada 500ms para animaciones suaves
            setInterval(() => {
                this.actualizarVisualizacion();
            }, 500);
            // Redibujar líneas si cambia el tamaño de la ventana
            window.addEventListener('resize', () => {
                this.dibujarLineasRed();
            });
        },

        dibujarLineasRed() {
            // Esperar a que el DOM esté listo
            setTimeout(() => {
                const svg = document.getElementById('network-lines');
                if (!svg) return;
                
                const container = svg.parentElement;
                if (!container) return;
                
                const width = container.offsetWidth || 800;
                const height = container.offsetHeight || 300;
                const centerX = width / 2;
                const centerY = height / 2;
                const clientX = 140;
                const serverX = width - 140;
                
                svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
                svg.setAttribute('width', '100%');
                svg.setAttribute('height', '100%');
                svg.setAttribute('preserveAspectRatio', 'none');
                
                // Limpiar líneas anteriores
                svg.innerHTML = '';
                
                // Línea Cliente -> Router
                const line1 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line1.setAttribute('id', 'line-client-router');
                line1.setAttribute('x1', clientX);
                line1.setAttribute('y1', centerY);
                line1.setAttribute('x2', centerX);
                line1.setAttribute('y2', centerY);
                line1.setAttribute('stroke', '#3b82f6');
                line1.setAttribute('stroke-width', '3');
                line1.setAttribute('stroke-dasharray', '10,5');
                line1.setAttribute('opacity', '0.6');
                svg.appendChild(line1);
                
                // Línea Router -> Servidor
                const line2 = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line2.setAttribute('id', 'line-router-server');
                line2.setAttribute('x1', centerX);
                line2.setAttribute('y1', centerY);
                line2.setAttribute('x2', serverX);
                line2.setAttribute('y2', centerY);
                line2.setAttribute('stroke', '#3b82f6');
                line2.setAttribute('stroke-width', '3');
                line2.setAttribute('stroke-dasharray', '10,5');
                line2.setAttribute('opacity', '0.6');
                svg.appendChild(line2);
            }, 100);
        },

        calcularProgreso(trabajo) {
            if (!trabajo.tiempo_inicio_proceso) return 0;
            const tiempoTotal = trabajo.paginas * 3; // 3 segundos por página
            const tiempoTranscurrido = (new Date() - new Date(trabajo.tiempo_inicio_proceso)) / 1000;
            const progreso = Math.min(100, Math.max(0, (tiempoTranscurrido / tiempoTotal) * 100));
            return Math.round(progreso);
        },

        actualizarVisualizacion() {
            // Encontrar trabajo en proceso o recién enviado
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

            // Limpiar animaciones anteriores
            container.innerHTML = '';
            this.packetAnimations = [];

            // Crear paquete visual
            const packet = document.createElement('div');
            packet.className = 'packet absolute bg-blue-500 text-white text-xs font-bold rounded-full w-12 h-12 flex items-center justify-center shadow-lg border-2 border-blue-700';
            packet.style.left = '140px';
            packet.style.top = '50%';
            packet.style.transform = 'translateY(-50%)';
            packet.textContent = '📄';
            packet.setAttribute('data-trabajo-id', trabajo.id);
            container.appendChild(packet);

            // Fase 1: Cliente -> Router (1.5 segundos)
            statusEl.textContent = `📤 Enviando desde PC: ${trabajo.descripcion}...`;
            packet.classList.add('moving');
            this.animarPaquete(packet, '140px', '50%', '50%', '50%', 1500, () => {
                // Fase 2: Router -> Servidor (1.5 segundos)
                statusEl.textContent = `🌐 Transmitiendo por red: ${trabajo.descripcion}...`;
                this.animarPaquete(packet, '50%', '50%', 'calc(100% - 140px)', '50%', 1500, () => {
                    // Fase 3: Procesamiento en servidor
                    packet.classList.remove('moving');
                    if (trabajo.estado === 'En Proceso' || this.trabajos.find(t => t.id === trabajo.id)?.estado === 'En Proceso') {
                        statusEl.textContent = `⚙️ Procesando en servidor: ${trabajo.descripcion}...`;
                        packet.style.left = 'calc(100% - 140px)';
                        packet.style.background = 'linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%)';
                        packet.textContent = '⚙️';
                        packet.style.animation = 'pulse 1.5s ease-in-out infinite';
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
            
            if (progressBar) {
                progressBar.style.width = progreso + '%';
            }
            
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/dashboard.blade.php ENDPATH**/ ?>