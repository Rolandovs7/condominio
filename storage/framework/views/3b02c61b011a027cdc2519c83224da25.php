<?php $__env->startSection('title', 'Propiedades'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-home me-2" style="color:#34d399;"></i> Gestión de Propiedades</h2>
        <a href="<?php echo e(route('propiedades.create')); ?>" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i> Nueva propiedad
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Lista de propiedades</span>
            <span class="badge" style="background:rgba(52,211,153,.12);color:#34d399;"><?php echo e($propiedades->count()); ?> propiedades</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Ubicación</th>
                            <th>Residente asignado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;"><?php echo e($propiedad->id); ?></td>
                            <td><code style="color:#38bdf8;background:rgba(56,189,248,.1);padding:2px 8px;border-radius:5px;font-size:.85rem;"><?php echo e($propiedad->codigo); ?></code></td>
                            <td style="font-size:.85rem;color:#cbd5e1;"><?php echo e($propiedad->tipo); ?></td>
                            <td style="font-size:.82rem;color:#94a3b8;"><i class="fas fa-map-marker-alt me-1" style="color:#64748b;"></i><?php echo e($propiedad->ubicacion); ?></td>
                            <td>
                                <?php if($propiedad->residente): ?>
                                    <span style="font-weight:600;color:#e2e8f0;font-size:.875rem;"><?php echo e($propiedad->residente->nombre_completo); ?></span>
                                <?php else: ?>
                                    <span style="color:#475569;font-size:.82rem;"><i class="fas fa-user-slash me-1"></i>Sin asignar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo e($propiedad->estado === 'disponible' ? 'pagado' : ($propiedad->estado === 'ocupada' ? 'en_curso' : 'pendiente')); ?>">
                                    <?php echo e(ucfirst($propiedad->estado)); ?>

                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('propiedades.show', $propiedad->id)); ?>" class="btn btn-secondary btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="<?php echo e(route('propiedades.edit', $propiedad->id)); ?>" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    <form action="<?php echo e(route('propiedades.destroy', $propiedad->id)); ?>" method="POST" class="d-inline delete-form">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-name="<?php echo e($propiedad->codigo); ?>" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-home d-block"></i>
                                    <p>No hay propiedades registradas.</p>
                                    <a href="<?php echo e(route('propiedades.create')); ?>" class="btn btn-success btn-sm">Registrar propiedad</a>
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
        Swal.fire({ title:`¿Eliminar propiedad ${nombre}?`, icon:'warning',
            showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#334155',
            confirmButtonText:'Eliminar', cancelButtonText:'Cancelar', background:'#111827', color:'#e2e8f0'
        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/propiedades/index.blade.php ENDPATH**/ ?>