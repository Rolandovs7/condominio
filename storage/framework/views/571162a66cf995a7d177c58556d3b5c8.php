<?php $__env->startSection('title', 'Residentes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-building-user me-2" style="color:#34d399;"></i> Residentes</h2>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear residentes')): ?>
        <a href="<?php echo e(route('residentes.create')); ?>" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo residente
        </a>
        <?php endif; ?>
    </div>

    
    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="<?php echo e(route('residentes.index')); ?>">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nombre, apellido o CI..." value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="tipo_residente" class="form-select">
                            <option value="">Todos los tipos</option>
                            <option value="propietario" <?php echo e(request('tipo_residente') == 'propietario' ? 'selected' : ''); ?>>Propietario</option>
                            <option value="inquilino"   <?php echo e(request('tipo_residente') == 'inquilino'   ? 'selected' : ''); ?>>Inquilino</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-filter me-1"></i> Filtrar</button>
                        <a href="<?php echo e(route('residentes.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-2 text-end">
                        <span style="font-size:.8rem;color:#64748b;"><?php echo e($residentes->total()); ?> registros</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-2"></i> Lista de residentes
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre completo</th>
                            <th>CI</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Morosidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $residentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $residente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="color:#64748b;"><?php echo e($residente->id); ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                                          style="width:32px;height:32px;font-size:.75rem;background:linear-gradient(135deg,#1d4ed8,#2563eb);flex-shrink:0;">
                                        <?php echo e(strtoupper(substr($residente->nombre, 0, 1))); ?>

                                    </span>
                                    <div>
                                        <div style="font-weight:600;color:#e2e8f0;"><?php echo e($residente->nombre_completo); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#94a3b8;font-size:.85rem;"><?php echo e($residente->ci); ?></td>
                            <td style="color:#94a3b8;font-size:.82rem;"><?php echo e($residente->email); ?></td>
                            <td>
                                <span class="badge" style="background:rgba(167,139,250,.12);color:#a78bfa;font-size:.72rem;">
                                    <?php echo e(ucfirst($residente->tipo_residente)); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($residente->tieneMorosidad()): ?>
                                    <span class="badge badge-vencido"><i class="fas fa-exclamation-triangle me-1"></i>Moroso</span>
                                <?php else: ?>
                                    <span class="badge badge-pagado"><i class="fas fa-check me-1"></i>Al día</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar residentes')): ?>
                                    <a href="<?php echo e(route('residentes.edit', $residente->id)); ?>" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('eliminar residentes')): ?>
                                    <form action="<?php echo e(route('residentes.destroy', $residente->id)); ?>" method="POST" class="d-inline delete-form">
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
                                    <i class="fas fa-building-user d-block"></i>
                                    <p>No se encontraron residentes.</p>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear residentes')): ?>
                                    <a href="<?php echo e(route('residentes.create')); ?>" class="btn btn-success btn-sm">Agregar primer residente</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($residentes->hasPages()): ?>
        <div class="card-body border-top py-2">
            <?php echo e($residentes->withQueryString()->links()); ?>

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
            title: '¿Eliminar residente?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#334155',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#111827',
            color: '#e2e8f0',
        }).then(result => {
            if (result.isConfirmed) this.closest('form').submit();
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/residentes/index.blade.php ENDPATH**/ ?>