<?php $__env->startSection('title', 'Comunicados'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-envelope me-2" style="color:#a78bfa;"></i> Comunicados</h2>
        <?php if(auth()->check() && !auth()->user()->residente_id && !auth()->user()->empleado_id): ?>
        <a href="<?php echo e(route('comunicados.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo comunicado
        </a>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Lista de comunicados</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Contenido</th>
                            <th>Autor</th>
                            <th>Fecha publicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $comunicados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comunicado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;"><?php echo e($comunicado->titulo); ?></div>
                            </td>
                            <td>
                                <?php $tipoColors = ['Aviso'=>'#38bdf8','Reglamento'=>'#a78bfa','Evento'=>'#34d399','Urgente'=>'#f87171']; $tc = $tipoColors[$comunicado->tipo] ?? '#94a3b8'; ?>
                                <span class="badge" style="background:<?php echo e($tc); ?>22;color:<?php echo e($tc); ?>;border:1px solid <?php echo e($tc); ?>44;font-size:.7rem;">
                                    <?php echo e($comunicado->tipo); ?>

                                </span>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;"><?php echo e(Str::limit($comunicado->contenido, 60)); ?></td>
                            <td style="font-size:.82rem;color:#94a3b8;"><?php echo e($comunicado->usuario->name ?? '—'); ?></td>
                            <td style="font-size:.78rem;color:#94a3b8;">
                                <?php echo e($comunicado->fecha_publicacion ? $comunicado->fecha_publicacion->format('d/m/Y H:i') : 'Inmediato'); ?>

                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('comunicados.show', $comunicado->id)); ?>" class="btn btn-secondary btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if(auth()->check() && !auth()->user()->residente_id && !auth()->user()->empleado_id): ?>
                                    <a href="<?php echo e(route('comunicados.edit', $comunicado->id)); ?>" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="<?php echo e(route('comunicados.destroy', $comunicado->id)); ?>" method="POST" class="d-inline delete-form">
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
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-envelope d-block"></i>
                                    <p>No hay comunicados publicados.</p>
                                    <?php if(auth()->check() && !auth()->user()->residente_id): ?>
                                    <a href="<?php echo e(route('comunicados.create')); ?>" class="btn btn-primary btn-sm">Crear comunicado</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($comunicados->hasPages()): ?>
        <div class="card-body border-top py-2">
            <?php echo e($comunicados->links()); ?>

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
            title: '¿Eliminar comunicado?',
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

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/comunicados/index.blade.php ENDPATH**/ ?>