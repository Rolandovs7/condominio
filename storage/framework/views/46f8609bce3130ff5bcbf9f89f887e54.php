<?php $__env->startSection('title', 'Roles y Permisos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-user-shield me-2" style="color:#60a5fa;"></i> Roles y Permisos</h2>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear roles')): ?>
        <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo rol
        </a>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-shield-halved me-2"></i> Roles del sistema</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre del rol</th>
                            <th>Permisos asignados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;"><?php echo e($item->id); ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                                         style="width:34px;height:34px;background:rgba(37,99,235,.2);flex-shrink:0;">
                                        <i class="fas fa-shield-halved fa-sm" style="color:#60a5fa;"></i>
                                    </div>
                                    <span style="font-weight:700;color:#e2e8f0;"><?php echo e($item->name); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php $__empty_2 = true; $__currentLoopData = $item->permissions->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <span class="badge" style="background:rgba(56,189,248,.1);color:#38bdf8;border:1px solid rgba(56,189,248,.2);font-size:.65rem;">
                                        <?php echo e($perm->name); ?>

                                    </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <span style="color:#475569;font-size:.8rem;">Sin permisos</span>
                                    <?php endif; ?>
                                    <?php if($item->permissions->count() > 5): ?>
                                    <span class="badge" style="background:rgba(100,116,139,.15);color:#94a3b8;font-size:.65rem;">
                                        +<?php echo e($item->permissions->count() - 5); ?> más
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar roles')): ?>
                                    <a href="<?php echo e(route('roles.edit', ['role' => $item])); ?>" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('eliminar roles')): ?>
                                    <form action="<?php echo e(route('roles.destroy', ['role' => $item->id])); ?>" method="POST" class="d-inline delete-form">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar" data-name="<?php echo e($item->name); ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-user-shield d-block"></i>
                                    <p>No hay roles registrados.</p>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear roles')): ?>
                                    <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary btn-sm">Crear primer rol</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    const nombre = btn.dataset.name;
    btn.addEventListener('click', function() {
        Swal.fire({
            title: `¿Eliminar rol "${nombre}"?`,
            text: 'Los usuarios con este rol perderán sus permisos.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#334155',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            background: '#111827',
            color: '#e2e8f0',
        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/roles/index.blade.php ENDPATH**/ ?>