<?php $__env->startSection('title', 'Eventos Comunitarios'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-calendar-star me-2" style="color:#a78bfa;"></i> Eventos Comunitarios</h2>
        <a href="<?php echo e(route('eventos.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo evento
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="<?php echo e(route('eventos.index')); ?>">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Nombre, lugar..." value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            <?php $__currentLoopData = ['programado','en_curso','finalizado','cancelado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($est); ?>" <?php echo e(request('estado') == $est ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_',' ',$est))); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="<?php echo e(route('eventos.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-4 text-end">
                        <span style="font-size:.78rem;color:#64748b;"><?php echo e($eventos->total()); ?> eventos</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Calendario de eventos</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Lugar</th>
                            <th>Fecha y hora</th>
                            <th>Cupo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;"><?php echo e(Str::limit($ev->nombre, 45)); ?></div>
                                <?php if($ev->descripcion): ?>
                                <div style="font-size:.72rem;color:#64748b;"><?php echo e(Str::limit($ev->descripcion, 60)); ?></div>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">
                                <i class="fas fa-map-marker-alt me-1" style="color:#64748b;"></i><?php echo e($ev->lugar); ?>

                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;white-space:nowrap;">
                                <?php echo e(\Carbon\Carbon::parse($ev->fecha_hora)->format('d/m/Y H:i')); ?>

                            </td>
                            <td style="font-size:.85rem;color:#94a3b8;text-align:center;">
                                <?php echo e($ev->cupo_maximo ?? '∞'); ?>

                            </td>
                            <td>
                                <?php $map = ['programado'=>'en_curso','en_curso'=>'en_curso','finalizado'=>'pagado','cancelado'=>'rechazado']; ?>
                                <span class="badge badge-<?php echo e($map[$ev->estado] ?? 'pendiente'); ?>">
                                    <?php echo e(ucfirst(str_replace('_',' ',$ev->estado))); ?>

                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('eventos.show', $ev->id)); ?>" class="btn btn-secondary btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="<?php echo e(route('eventos.edit', $ev->id)); ?>" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    <form action="<?php echo e(route('eventos.destroy', $ev->id)); ?>" method="POST" class="d-inline delete-form">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-star d-block"></i>
                                    <p>No hay eventos registrados.</p>
                                    <a href="<?php echo e(route('eventos.create')); ?>" class="btn btn-primary btn-sm">Crear evento</a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($eventos->hasPages()): ?>
        <div class="card-body border-top py-2"><?php echo e($eventos->withQueryString()->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        Swal.fire({ title:'¿Eliminar evento?', text:'Esta acción no se puede deshacer.', icon:'warning',
            showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#334155',
            confirmButtonText:'Eliminar', cancelButtonText:'Cancelar', background:'#111827', color:'#e2e8f0'
        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/eventos/index.blade.php ENDPATH**/ ?>