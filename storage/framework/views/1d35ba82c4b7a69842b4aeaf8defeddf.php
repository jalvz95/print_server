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
                <a href="<?php echo e(route('trabajos.create', ['return_to' => request()->route()->getName()])); ?>" class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded">
                    Enviar Nueva Impresión
                </a>
            </div>
        </div>
    </div>
</div>

<?php /**PATH /var/www/html/resources/views/servidores/partials/flujo-trabajos.blade.php ENDPATH**/ ?>