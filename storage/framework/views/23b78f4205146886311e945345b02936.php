<?php $__env->startSection('title', 'Reporte de Pagos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-receipt me-2" style="color:#34d399;"></i> Reporte de Pagos</h2>
        <button class="btn btn-secondary btn-sm" onclick="window.print()">
            <i class="fas fa-print me-1"></i> Imprimir
        </button>
    </div>

    
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-filter me-2"></i> Parámetros</div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('informes.pagos')); ?>">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label">Desde</label>
                        <input type="date" name="desde" class="form-control" value="<?php echo e(request('desde')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Hasta</label>
                        <input type="date" name="hasta" class="form-control" value="<?php echo e(request('hasta')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Por mes</label>
                        <input type="month" name="mes" class="form-control" value="<?php echo e(request('mes')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Método</label>
                        <select name="metodo" class="form-select">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = ['efectivo','transferencia','qr','stripe']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m); ?>" <?php echo e(request('metodo') == $m ? 'selected' : ''); ?>><?php echo e(ucfirst($m)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fas fa-chart-bar me-1"></i> Generar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(52,211,153,.2);">
                    <i class="fas fa-dollar-sign" style="color:#34d399;"></i>
                </div>
                <div>
                    <div class="stat-number" style="font-size:1.5rem;">Bs <?php echo e(number_format($total, 2)); ?></div>
                    <div class="stat-label">Total recaudado</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(56,189,248,.2);">
                    <i class="fas fa-receipt" style="color:#38bdf8;"></i>
                </div>
                <div>
                    <div class="stat-number"><?php echo e($pagos->count()); ?></div>
                    <div class="stat-label">Pagos registrados</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(248,113,113,.2);">
                    <i class="fas fa-exclamation-triangle" style="color:#f87171;"></i>
                </div>
                <div>
                    <div class="stat-number"><?php echo e($morosos->count()); ?></div>
                    <div class="stat-label">Residentes morosos</div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Detalle de pagos</span>
            <?php if($pagos->isNotEmpty()): ?>
            <span class="badge" style="background:rgba(52,211,153,.12);color:#34d399;"><?php echo e($pagos->count()); ?> registros</span>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <?php if($pagos->isEmpty()): ?>
                <div class="empty-state">
                    <i class="fas fa-receipt d-block"></i>
                    <p>No se encontraron pagos con los filtros indicados.</p>
                </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th><th>Fecha</th><th>Residente</th><th>Cuota/Multa</th>
                            <th>Monto</th><th>Método</th><th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;"><?php echo e($loop->iteration); ?></td>
                            <td style="color:#94a3b8;font-size:.82rem;"><?php echo e(\Carbon\Carbon::parse($p->fecha_pago)->format('d/m/Y H:i')); ?></td>
                            <td style="font-weight:600;color:#e2e8f0;">
                                <?php echo e($p->cuota?->residente?->nombre_completo ?? ($p->multa?->residente?->nombre_completo ?? '—')); ?>

                            </td>
                            <td>
                                <?php if($p->cuota_id): ?>
                                <span class="badge" style="background:rgba(56,189,248,.1);color:#38bdf8;font-size:.7rem;">Cuota #<?php echo e($p->cuota_id); ?></span>
                                <?php elseif($p->multa_id): ?>
                                <span class="badge" style="background:rgba(248,113,113,.1);color:#f87171;font-size:.7rem;">Multa #<?php echo e($p->multa_id); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><strong style="color:#34d399;">Bs <?php echo e(number_format($p->monto_pagado, 2)); ?></strong></td>
                            <td style="color:#94a3b8;font-size:.82rem;"><?php echo e(ucfirst($p->metodo)); ?></td>
                            <td><span class="badge badge-<?php echo e(strtolower($p->estado ?? 'pendiente')); ?>"><?php echo e(ucfirst($p->estado)); ?></span></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr style="background:rgba(52,211,153,.06);">
                            <td colspan="4" style="font-weight:700;color:#e2e8f0;padding:.8rem 1rem;">
                                <i class="fas fa-sigma me-1"></i> Total recaudado:
                            </td>
                            <td style="font-weight:700;color:#34d399;font-size:1rem;padding:.8rem 1rem;">
                                Bs <?php echo e(number_format($total, 2)); ?>

                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if($morosos->isNotEmpty()): ?>
    <div class="card">
        <div class="card-header" style="border-left:3px solid #f87171;">
            <i class="fas fa-exclamation-triangle me-2" style="color:#f87171;"></i>
            Residentes con cuotas pendientes
            <span class="badge badge-vencido ms-2"><?php echo e($morosos->count()); ?></span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr><th>#</th><th>Nombre</th><th>CI</th><th>Email</th></tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $morosos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;"><?php echo e($loop->iteration); ?></td>
                            <td style="font-weight:600;color:#e2e8f0;"><?php echo e($m->nombre); ?> <?php echo e($m->apellido); ?></td>
                            <td style="color:#94a3b8;font-size:.85rem;"><?php echo e($m->ci); ?></td>
                            <td style="color:#94a3b8;font-size:.82rem;"><?php echo e($m->email); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/informes/pagos.blade.php ENDPATH**/ ?>