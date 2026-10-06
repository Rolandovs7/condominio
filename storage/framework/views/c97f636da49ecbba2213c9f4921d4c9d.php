<?php $__env->startSection('title', 'Empleados'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-id-badge me-2" style="color:#34d399;"></i> Empleados</h2>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear empleados')): ?>
        <a href="<?php echo e(route('empleados.create')); ?>" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo empleado
        </a>
        <?php endif; ?>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="<?php echo e(route('empleados.index')); ?>">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nombre, apellido o CI..." value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" <?php echo e(request('estado') === '1' ? 'selected' : ''); ?>>Activos</option>
                            <option value="0" <?php echo e(request('estado') === '0' ? 'selected' : ''); ?>>Inactivos</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="<?php echo e(route('empleados.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-3 text-end">
                        <span style="font-size:.78rem;color:#64748b;"><?php echo e($empleados->total()); ?> empleados</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Personal registrado</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre completo</th>
                            <th>CI</th>
                            <th>Cargo</th>
                            <th>Fecha ingreso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;"><?php echo e($empleado->id); ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                                          style="width:32px;height:32px;font-size:.75rem;background:linear-gradient(135deg,#059669,#047857);flex-shrink:0;">
                                        <?php echo e(strtoupper(substr($empleado->nombre ?? 'E', 0, 1))); ?>

                                    </span>
                                    <div>
                                        <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">
                                            <?php echo e($empleado->nombre); ?> <?php echo e($empleado->apellido); ?>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#94a3b8;font-size:.85rem;"><?php echo e($empleado->ci); ?></td>
                            <td>
                                <span class="badge" style="background:rgba(167,139,250,.12);color:#a78bfa;font-size:.72rem;">
                                    <?php echo e($empleado->cargo?->cargo ?? 'Sin cargo'); ?>

                                </span>
                            </td>
                            <td style="font-size:.8rem;color:#94a3b8;">
                                <?php echo e($empleado->fecha_ingreso ? \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') : '—'); ?>

                            </td>
                            <td>
                                <?php if($empleado->estado): ?>
                                    <span class="badge badge-activo"><i class="fas fa-circle me-1" style="font-size:.5rem;"></i>Activo</span>
                                <?php else: ?>
                                    <span class="badge badge-inactivo"><i class="fas fa-circle me-1" style="font-size:.5rem;"></i>Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar empleados')): ?>
                                    <a href="<?php echo e(route('empleados.edit', $empleado->id)); ?>" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('eliminar empleados')): ?>
                                    <form action="<?php echo e(route('empleados.destroy', $empleado->id)); ?>" method="POST" class="d-inline delete-form">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-id-badge d-block"></i>
                                    <p>No hay empleados registrados.</p>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear empleados')): ?>
                                    <a href="<?php echo e(route('empleados.create')); ?>" class="btn btn-success btn-sm">Registrar empleado</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($empleados->hasPages()): ?>
        <div class="card-body border-top py-2">
            <?php echo e($empleados->appends(['search' => request('search'), 'estado' => request('estado')])->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        Swal.fire({
            title: '¿Eliminar empleado?',
            text: 'Esta acción no se puede deshacer.',
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

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/empleados/index.blade.php ENDPATH**/ ?>