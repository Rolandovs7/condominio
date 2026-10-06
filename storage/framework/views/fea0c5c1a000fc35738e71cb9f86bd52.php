<?php $__env->startSection('title', 'Multas'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-exclamation-triangle me-2" style="color:#fbbf24;"></i> Panel de Multas</h2>
        <?php if(auth()->check() && !auth()->user()->residente_id && !auth()->user()->empleado_id): ?>
        <a href="<?php echo e(route('multas.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nueva multa
        </a>
        <?php endif; ?>
    </div>

    
    <?php
        $pendientes = $multas->where('estado','pendiente')->count();
        $pagadas    = $multas->where('estado','pagada')->count();
        $totalMonto = $multas->where('estado','pendiente')->sum('monto');
    ?>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(251,191,36,.2);">
                    <i class="fas fa-clock" style="color:#fbbf24;"></i>
                </div>
                <div>
                    <div class="stat-number"><?php echo e($pendientes); ?></div>
                    <div class="stat-label">Pendientes</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(52,211,153,.2);">
                    <i class="fas fa-check" style="color:#34d399;"></i>
                </div>
                <div>
                    <div class="stat-number"><?php echo e($pagadas); ?></div>
                    <div class="stat-label">Pagadas</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(248,113,113,.2);">
                    <i class="fas fa-dollar-sign" style="color:#f87171;"></i>
                </div>
                <div>
                    <div class="stat-number" style="font-size:1.4rem;">Bs <?php echo e(number_format($totalMonto, 2)); ?></div>
                    <div class="stat-label">Total pendiente</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Lista de multas</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Afectado</th>
                            <th>Motivo</th>
                            <th>Monto</th>
                            <th>Emitida</th>
                            <th>Vencimiento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $multas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $multa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">
                                    <?php echo e(optional($multa->residente)->nombre_completo
                                       ?? optional($multa->empleado)->nombre_completo
                                       ?? 'N/A'); ?>

                                </div>
                                <?php if($multa->residente): ?>
                                    <div style="font-size:.7rem;color:#64748b;">Residente</div>
                                <?php elseif($multa->empleado): ?>
                                    <div style="font-size:.7rem;color:#64748b;">Empleado</div>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:.85rem;color:#cbd5e1;"><?php echo e(Str::limit($multa->motivo, 50)); ?></td>
                            <td><strong style="color:#f87171;">Bs <?php echo e(number_format($multa->monto, 2)); ?></strong></td>
                            <td style="font-size:.8rem;color:#94a3b8;"><?php echo e(\Carbon\Carbon::parse($multa->fechaEmision)->format('d/m/Y')); ?></td>
                            <td style="font-size:.8rem;color:#94a3b8;"><?php echo e(\Carbon\Carbon::parse($multa->fechaLimite)->format('d/m/Y')); ?></td>
                            <td>
                                <?php $est = strtolower($multa->estado); ?>
                                <span class="badge badge-<?php echo e(in_array($est, ['pendiente','pagada','anulada']) ? $est : 'pendiente'); ?>">
                                    <?php echo e(ucfirst($multa->estado)); ?>

                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <?php if(auth()->check() && (auth()->user()->residente_id || auth()->user()->empleado_id) && $multa->estado == 'pendiente'): ?>
                                    <a href="<?php echo e(route('pagos.create.multa', ['multa' => $multa->id])); ?>" class="btn btn-success btn-sm" title="Pagar">
                                        <i class="fas fa-credit-card"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if(!auth()->user()->residente_id && !auth()->user()->empleado_id): ?>
                                    <a href="<?php echo e(route('multas.edit', $multa->id)); ?>" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="<?php echo e(route('multas.destroy', $multa->id)); ?>" method="POST" class="d-inline delete-form">
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
                                    <i class="fas fa-check-circle d-block" style="color:#34d399;"></i>
                                    <p>No hay multas registradas.</p>
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
    btn.addEventListener('click', function() {
        Swal.fire({
            title: '¿Eliminar multa?',
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

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/multas/index.blade.php ENDPATH**/ ?>