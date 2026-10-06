<?php $__env->startSection('title', 'Reclamos Administrativos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-exclamation-circle me-2" style="color:#a78bfa;"></i> Reclamos Administrativos</h2>
        <a href="<?php echo e(route('reclamos.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo reclamo
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="<?php echo e(route('reclamos.index')); ?>">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="N° seguimiento, título, residente..." value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            <?php $__currentLoopData = ['pendiente','en_revision','resuelto','rechazado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($est); ?>" <?php echo e(request('estado') == $est ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst(str_replace('_',' ',$est))); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="<?php echo e(route('reclamos.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-3 text-end">
                        <span style="font-size:.78rem;color:#64748b;"><?php echo e($reclamos->total()); ?> registros</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Lista de reclamos</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>N° Seguimiento</th>
                            <th>Título</th>
                            <th>Residente</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $reclamos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reclamo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <code style="background:rgba(167,139,250,.1);color:#a78bfa;padding:2px 8px;border-radius:5px;font-size:.82rem;">
                                    <?php echo e($reclamo->numero_seguimiento); ?>

                                </code>
                            </td>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;"><?php echo e(Str::limit($reclamo->titulo, 45)); ?></div>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">
                                <?php echo e($reclamo->residente ? $reclamo->residente->nombre_completo : '—'); ?>

                            </td>
                            <td>
                                <span class="badge" style="background:rgba(56,189,248,.1);color:#38bdf8;font-size:.7rem;">
                                    <?php echo e($reclamo->categoria ?? 'General'); ?>

                                </span>
                            </td>
                            <td>
                                <?php $map = ['pendiente'=>'pendiente','en_revision'=>'en_curso','resuelto'=>'pagado','rechazado'=>'rechazado']; ?>
                                <span class="badge badge-<?php echo e($map[$reclamo->estado] ?? 'pendiente'); ?>">
                                    <?php echo e(ucfirst(str_replace('_',' ',$reclamo->estado))); ?>

                                </span>
                            </td>
                            <td style="font-size:.78rem;color:#94a3b8;"><?php echo e($reclamo->created_at->format('d/m/Y')); ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('reclamos.show', $reclamo->id)); ?>" class="btn btn-secondary btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="<?php echo e(route('reclamos.edit', $reclamo->id)); ?>" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    <form action="<?php echo e(route('reclamos.destroy', $reclamo->id)); ?>" method="POST" class="d-inline delete-form">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-exclamation-circle d-block"></i>
                                    <p>No hay reclamos registrados.</p>
                                    <a href="<?php echo e(route('reclamos.create')); ?>" class="btn btn-primary btn-sm">Registrar reclamo</a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($reclamos->hasPages()): ?>
        <div class="card-body border-top py-2"><?php echo e($reclamos->withQueryString()->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        Swal.fire({ title:'¿Eliminar reclamo?', text:'Esta acción no se puede deshacer.', icon:'warning',
            showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#334155',
            confirmButtonText:'Eliminar', cancelButtonText:'Cancelar', background:'#111827', color:'#e2e8f0'
        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/reclamos/index.blade.php ENDPATH**/ ?>