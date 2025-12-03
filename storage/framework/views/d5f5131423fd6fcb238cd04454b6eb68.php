<?php $__env->startSection('title', 'Enviar Trabajo'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Enviar Nuevo Trabajo de Impresión</h2>

    <form action="<?php echo e(route('trabajos.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="return_to" value="<?php echo e($returnTo ?? 'dashboard'); ?>">

        <div class="mb-4">
            <label for="usuario_id" class="block text-sm font-medium text-gray-700 mb-2">
                Usuario
            </label>
            <select name="usuario_id" id="usuario_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccione un usuario</option>
                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($usuario->id); ?>" <?php echo e(old('usuario_id') == $usuario->id ? 'selected' : ''); ?>>
                        <?php echo e($usuario->nombre); ?> (Cuota: <?php echo e($usuario->cuota_actual); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="impresora_id" class="block text-sm font-medium text-gray-700 mb-2">
                Impresora
            </label>
            <select name="impresora_id" id="impresora_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccione una impresora</option>
                <?php $__currentLoopData = $impresoras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $impresora): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($impresora->id); ?>" <?php echo e(old('impresora_id') == $impresora->id ? 'selected' : ''); ?>>
                        <?php echo e($impresora->nombre); ?> 
                        <?php if($impresora->estado === 'funcional'): ?>
                            ✅ Funcional
                        <?php elseif($impresora->estado === 'sin_tinta'): ?>
                            ⚠️ Sin Tinta
                        <?php elseif($impresora->estado === 'sin_hojas'): ?>
                            📄 Sin Hojas
                        <?php elseif($impresora->estado === 'desconectada'): ?>
                            🔌 Desconectada
                        <?php endif; ?>
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <p class="mt-1 text-sm text-gray-500">Seleccione la impresora a la que desea enviar el trabajo</p>
        </div>

        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                Descripción del Trabajo
            </label>
            <input type="text" name="descripcion" id="descripcion" value="<?php echo e(old('descripcion')); ?>" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Ej: Reporte Mensual">
        </div>

        <div class="mb-4">
            <label for="paginas" class="block text-sm font-medium text-gray-700 mb-2">
                Número de Páginas (1-500)
            </label>
            <input type="number" name="paginas" id="paginas" value="<?php echo e(old('paginas', 1)); ?>" required
                   min="1" max="500"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tipo de Impresión
            </label>
            <div class="flex items-center">
                <input type="checkbox" name="es_color" id="es_color" value="1" <?php echo e(old('es_color') ? 'checked' : ''); ?>

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
                    <input type="radio" name="prioridad" id="prioridad_normal" value="3" <?php echo e(old('prioridad', 3) == 3 ? 'checked' : ''); ?> required
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <label for="prioridad_normal" class="ml-2 block text-sm text-gray-900">
                        Normal
                    </label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="prioridad" id="prioridad_urgente" value="5" <?php echo e(old('prioridad') == 5 ? 'checked' : ''); ?>

                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <label for="prioridad_urgente" class="ml-2 block text-sm text-gray-900">
                        Urgente
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="<?php echo e(route($returnTo ?? 'dashboard')); ?>" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                Enviar Trabajo
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/trabajos/create.blade.php ENDPATH**/ ?>