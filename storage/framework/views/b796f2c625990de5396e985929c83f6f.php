<?php $__env->startSection('title', 'Editar Regla'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Editar Regla</h2>

    <form action="<?php echo e(route('reglas.update', $regla)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                Nombre de la Regla
            </label>
            <input type="text" name="nombre" id="nombre" value="<?php echo e(old('nombre', $regla->nombre)); ?>" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-2">
                Tipo de Regla
            </label>
            <select name="tipo" id="tipo" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="Cuota Usuario" <?php echo e(old('tipo', $regla->tipo) == 'Cuota Usuario' ? 'selected' : ''); ?>>Cuota Usuario</option>
                <option value="Restricción Trabajo" <?php echo e(old('tipo', $regla->tipo) == 'Restricción Trabajo' ? 'selected' : ''); ?>>Restricción Trabajo</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="parametro_objetivo" class="block text-sm font-medium text-gray-700 mb-2">
                Parámetro Objetivo
            </label>
            <select name="parametro_objetivo" id="parametro_objetivo" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="cuota_actual" <?php echo e(old('parametro_objetivo', $regla->parametro_objetivo) == 'cuota_actual' ? 'selected' : ''); ?>>Cuota Actual</option>
                <option value="paginas" <?php echo e(old('parametro_objetivo', $regla->parametro_objetivo) == 'paginas' ? 'selected' : ''); ?>>Páginas</option>
                <option value="es_color" <?php echo e(old('parametro_objetivo', $regla->parametro_objetivo) == 'es_color' ? 'selected' : ''); ?>>Impresión a Color</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="valor_limite" class="block text-sm font-medium text-gray-700 mb-2">
                Valor Límite
            </label>
            <input type="text" name="valor_limite" id="valor_limite" value="<?php echo e(old('valor_limite', $regla->valor_limite)); ?>" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="accion" class="block text-sm font-medium text-gray-700 mb-2">
                Acción
            </label>
            <select name="accion" id="accion" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="Bloquear" <?php echo e(old('accion', $regla->accion) == 'Bloquear' ? 'selected' : ''); ?>>Bloquear</option>
                <option value="Advertir" <?php echo e(old('accion', $regla->accion) == 'Advertir' ? 'selected' : ''); ?>>Advertir</option>
                <option value="Reducir Prioridad" <?php echo e(old('accion', $regla->accion) == 'Reducir Prioridad' ? 'selected' : ''); ?>>Reducir Prioridad</option>
            </select>
        </div>

        <div class="mb-6">
            <div class="flex items-center">
                <input type="checkbox" name="activa" id="activa" value="1" <?php echo e(old('activa', $regla->activa) ? 'checked' : ''); ?>

                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="activa" class="ml-2 block text-sm text-gray-900">
                    Regla Activa
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="<?php echo e(route('reglas.index')); ?>" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                Actualizar Regla
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/reglas/edit.blade.php ENDPATH**/ ?>