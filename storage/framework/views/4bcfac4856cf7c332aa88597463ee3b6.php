<?php $__env->startSection('title', 'Nuevo Usuario'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <h2 class="mb-4">Registrar Usuario</h2>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('users.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <div class="form-text">Mínimo 8 caracteres, debe incluir mayúsculas, números y símbolos.</div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="role" class="form-select" required>
                <option value="">-- Seleccionar rol --</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($rol->name); ?>" <?php echo e(old('role') == $rol->name ? 'selected' : ''); ?>>
                    <?php echo e(ucfirst($rol->name)); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Empleado (si aplica)</label>
            <select name="empleado_id" class="form-select">
                <option value="">-- No asignar empleado --</option>
                <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($empleado->id); ?>" <?php echo e(old('empleado_id') == $empleado->id ? 'selected' : ''); ?>>
                    <?php echo e($empleado->nombre); ?> <?php echo e($empleado->apellido); ?> - <?php echo e($empleado->ci); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Residente (si aplica)</label>
            <select name="residente_id" class="form-select">
                <option value="">-- No asignar residente --</option>
                <?php $__currentLoopData = $residentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $residente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($residente->id); ?>" <?php echo e(old('residente_id') == $residente->id ? 'selected' : ''); ?>>
                    <?php echo e($residente->nombre); ?> <?php echo e($residente->apellido); ?> - <?php echo e($residente->ci); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/users/create.blade.php ENDPATH**/ ?>