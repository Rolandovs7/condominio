<?php $__env->startSection('title', 'Notificaciones'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-bell me-2" style="color:#fbbf24;"></i> Notificaciones a Residentes</h2>
        <a href="<?php echo e(route('notificaciones.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-paper-plane me-1"></i> Enviar notificación
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="<?php echo e(route('notificaciones.index')); ?>">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Título o contenido..." value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="tipo" class="form-select">
                            <option value="">Todos los tipos</option>
                            <?php $__currentLoopData = ['Urgente','Informativa','Recordatorio']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t); ?>" <?php echo e(request('tipo') == $t ? 'selected' : ''); ?>><?php echo e($t); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="leida" class="form-select">
                            <option value="">Todas</option>
                            <option value="0" <?php echo e(request('leida') === '0' ? 'selected' : ''); ?>>No leídas</option>
                            <option value="1" <?php echo e(request('leida') === '1' ? 'selected' : ''); ?>>Leídas</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="<?php echo e(route('notificaciones.index')); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-1 text-end">
                        <span style="font-size:.78rem;color:#64748b;"><?php echo e($notificaciones->total()); ?></span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Historial de notificaciones</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Destinatario</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $notificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;"><?php echo e(Str::limit($n->titulo, 50)); ?></div>
                                <div style="font-size:.72rem;color:#64748b;"><?php echo e(Str::limit($n->contenido, 60)); ?></div>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">
                                <?php if($n->residente): ?>
                                    <i class="fas fa-user me-1" style="color:#64748b;"></i>
                                    <?php echo e($n->residente->nombre_completo); ?>

                                <?php else: ?>
                                    <span class="badge" style="background:rgba(56,189,248,.12);color:#38bdf8;font-size:.7rem;">
                                        <i class="fas fa-users me-1"></i>Todos
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $colors = ['Urgente' => '#f87171', 'Informativa' => '#38bdf8', 'Recordatorio' => '#fbbf24']; ?>
                                <span class="badge" style="background:rgba(0,0,0,.2);color:<?php echo e($colors[$n->tipo] ?? '#94a3b8'); ?>;border:1px solid <?php echo e($colors[$n->tipo] ?? '#94a3b8'); ?>44;font-size:.7rem;">
                                    <?php echo e($n->tipo); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($n->leida): ?>
                                    <span class="badge badge-pagado">Leída</span>
                                <?php else: ?>
                                    <span class="badge badge-pendiente">Pendiente</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:.78rem;color:#94a3b8;white-space:nowrap;">
                                <?php echo e($n->fecha_hora ? \Carbon\Carbon::parse($n->fecha_hora)->format('d/m/Y H:i') : '—'); ?>

                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('notificaciones.show', $n->id)); ?>" class="btn btn-secondary btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if(!$n->leida): ?>
                                    <form action="<?php echo e(route('notificaciones.marcar-leida', $n->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-success btn-sm" title="Marcar leída">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('notificaciones.destroy', $n->id)); ?>" method="POST" class="d-inline delete-form">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-bell d-block"></i>
                                    <p>No hay notificaciones registradas.</p>
                                    <a href="<?php echo e(route('notificaciones.create')); ?>" class="btn btn-primary btn-sm">Enviar primera notificación</a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($notificaciones->hasPages()): ?>
        <div class="card-body border-top py-2">
            <?php echo e($notificaciones->withQueryString()->links()); ?>

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
            title: '¿Eliminar notificación?',
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

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/notificaciones/index.blade.php ENDPATH**/ ?>