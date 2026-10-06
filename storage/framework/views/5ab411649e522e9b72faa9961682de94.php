<?php $__env->startSection('title', 'Tipos de Cuota'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-tags me-2" style="color:#fbbf24;"></i> Tipos de Cuota</h2>
        <a href="<?php echo e(route('tipos-cuotas.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo tipo
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Tipos registrados</span>
            <span class="badge" style="background:rgba(251,191,36,.12);color:#fbbf24;"><?php echo e(count($tipos)); ?> tipos</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Frecuencia</th>
                            <th>Editable</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;"><?php echo e($tipo->id); ?></td>
                            <td>
                                <span style="font-weight:600;color:#e2e8f0;"><?php echo e($tipo->nombre); ?></span>
                            </td>
                            <td>
                                <span class="badge" style="background:rgba(56,189,248,.1);color:#38bdf8;font-size:.72rem;">
                                    <?php echo e(ucfirst($tipo->frecuencia)); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($tipo->editable): ?>
                                    <span class="badge badge-pagado"><i class="fas fa-check me-1"></i>Sí</span>
                                <?php else: ?>
                                    <span class="badge badge-inactivo"><i class="fas fa-lock me-1"></i>No</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('tipos-cuotas.edit', $tipo->id)); ?>"
                                       class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="<?php echo e(route('tipos-cuotas.destroy', $tipo->id)); ?>"
                                          method="POST" class="d-inline delete-form">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                data-name="<?php echo e($tipo->nombre); ?>" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-tags d-block"></i>
                                    <p>No hay tipos de cuota registrados.</p>
                                    <a href="<?php echo e(route('tipos-cuotas.create')); ?>" class="btn btn-primary btn-sm">Crear tipo</a>
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
            title: `¿Eliminar tipo "${nombre}"?`,
            text: 'Las cuotas asociadas perderán su tipo.',
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

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/cuotas/tipos_cuotas/index.blade.php ENDPATH**/ ?>