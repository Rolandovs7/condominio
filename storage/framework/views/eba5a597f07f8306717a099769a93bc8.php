<?php $__env->startSection('title', 'Bitácora del Sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-book me-2" style="color:#38bdf8;"></i> Bitácora del Sistema</h2>
        <span style="font-size:.8rem;color:#64748b;">Registro de todas las acciones realizadas en el sistema</span>
    </div>

    
    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="<?php echo e(route('bitacora.index')); ?>">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Buscar por usuario o acción..." value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="desde" class="form-control" value="<?php echo e(request('desde')); ?>" placeholder="Desde">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="hasta" class="form-control" value="<?php echo e(request('hasta')); ?>" placeholder="Hasta">
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="<?php echo e(route('bitacora.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-2 text-end">
                        <span style="font-size:.8rem;color:#64748b;"><?php echo e($bitacoras->total()); ?> registros</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-history me-2"></i> Historial de actividad
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Fecha y hora</th>
                            <th>IP</th>
                            <th>Ref.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $bitacoras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;"><?php echo e($b->id); ?></td>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.85rem;">
                                    <?php echo e($b->usuario ?? ($b->user->name ?? 'Sistema')); ?>

                                </div>
                                <?php if($b->user): ?>
                                <div style="font-size:.72rem;color:#64748b;"><?php echo e($b->user->email ?? ''); ?></div>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:.85rem;color:#cbd5e1;"><?php echo e($b->accion); ?></td>
                            <td style="font-size:.8rem;color:#94a3b8;white-space:nowrap;">
                                <?php echo e($b->fecha_hora ? \Carbon\Carbon::parse($b->fecha_hora)->format('d/m/Y H:i:s') : '—'); ?>

                            </td>
                            <td style="font-size:.78rem;color:#64748b;font-family:monospace;"><?php echo e($b->ip ?? '—'); ?></td>
                            <td style="font-size:.78rem;color:#64748b;"><?php echo e($b->id_operacion ?? '—'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-book d-block"></i>
                                    <p>No hay registros en la bitácora.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($bitacoras->hasPages()): ?>
        <div class="card-body border-top py-2">
            <?php echo e($bitacoras->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/bitacora/index.blade.php ENDPATH**/ ?>