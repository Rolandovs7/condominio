<?php $__env->startSection('title', 'Pagos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-money-bill-wave me-2" style="color:#34d399;"></i> Listado de Pagos</h2>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('pagos.mis_cuotas')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-list me-1"></i> Mis cuotas
            </a>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('pagos.index')); ?>" id="filtroForm">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Buscar residente / cuota</label>
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nombre, apellido, unidad..." value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Método de pago</label>
                        <select name="metodo" class="form-select">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = ['efectivo','transferencia','QR','Stripe']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($m); ?>" <?php echo e(request('metodo') == $m ? 'selected' : ''); ?>><?php echo e($m); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Filtro tiempo</label>
                        <select name="filtro_tiempo" id="filtro_tiempo" class="form-select" onchange="actualizarCampos()">
                            <option value="">Sin filtro</option>
                            <option value="fecha"  <?php echo e(request('filtro_tiempo') == 'fecha'  ? 'selected' : ''); ?>>Por fecha</option>
                            <option value="mes"    <?php echo e(request('filtro_tiempo') == 'mes'    ? 'selected' : ''); ?>>Por mes</option>
                            <option value="semana" <?php echo e(request('filtro_tiempo') == 'semana' ? 'selected' : ''); ?>>Por semana</option>
                            <option value="anio"   <?php echo e(request('filtro_tiempo') == 'anio'   ? 'selected' : ''); ?>>Por año</option>
                        </select>
                    </div>
                    <div class="col-md-2" id="fechaDesdeContainer" style="display:none;">
                        <label class="form-label">Desde</label>
                        <input type="date" name="fecha_desde" class="form-control" value="<?php echo e(request('fecha_desde')); ?>">
                    </div>
                    <div class="col-md-2" id="fechaHastaContainer" style="display:none;">
                        <label class="form-label">Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="<?php echo e(request('fecha_hasta')); ?>">
                    </div>
                    <div class="col-md-2" id="mesContainer" style="display:none;">
                        <label class="form-label">Mes</label>
                        <input type="month" name="mes" class="form-control" value="<?php echo e(request('mes')); ?>">
                    </div>
                    <div class="col-md-2" id="semanaContainer" style="display:none;">
                        <label class="form-label">Semana</label>
                        <input type="week" name="semana" class="form-control" value="<?php echo e(request('semana')); ?>">
                    </div>
                    <div class="col-md-2" id="anioContainer" style="display:none;">
                        <label class="form-label">Año</label>
                        <input type="number" name="anio" class="form-control" min="2000" max="<?php echo e(date('Y')+1); ?>" value="<?php echo e(request('anio')); ?>">
                    </div>
                    <div class="col-md-1 d-flex gap-1">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-filter"></i></button>
                        <a href="<?php echo e(route('pagos.index')); ?>" class="btn btn-secondary btn-sm" title="Limpiar"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Pagos registrados</span>
            <span class="badge" style="background:rgba(52,211,153,.15);color:#34d399;">
                Total: <?php echo e($pagos->total()); ?>

            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Residente</th>
                            <th>Cuota / Multa</th>
                            <th>Monto pagado</th>
                            <th>Fecha</th>
                            <th>Método</th>
                            <th>Estado</th>
                            <th>Registrado por</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="color:#64748b;"><?php echo e($pago->id); ?></td>
                            <td>
                                <?php if($pago->cuota && $pago->cuota->residente): ?>
                                    <span style="font-weight:600;color:#e2e8f0;"><?php echo e($pago->cuota->residente->nombre_completo); ?></span>
                                    <div style="font-size:.72rem;color:#64748b;"><?php echo e($pago->cuota->residente->ci ?? ''); ?></div>
                                <?php elseif($pago->multa && $pago->multa->residente): ?>
                                    <span style="font-weight:600;color:#e2e8f0;"><?php echo e($pago->multa->residente->nombre_completo); ?></span>
                                <?php else: ?>
                                    <span style="color:#475569;">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($pago->cuota_id): ?>
                                    <span class="badge" style="background:rgba(56,189,248,.12);color:#38bdf8;font-size:.72rem;">
                                        <i class="fas fa-file-invoice me-1"></i>Cuota #<?php echo e($pago->cuota_id); ?>

                                    </span>
                                <?php elseif($pago->multa_id): ?>
                                    <span class="badge" style="background:rgba(248,113,113,.12);color:#f87171;font-size:.72rem;">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Multa #<?php echo e($pago->multa_id); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><strong style="color:#34d399;">Bs <?php echo e(number_format($pago->monto_pagado, 2)); ?></strong></td>
                            <td style="color:#94a3b8;font-size:.82rem;"><?php echo e(\Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i')); ?></td>
                            <td>
                                <span class="badge" style="background:rgba(100,116,139,.15);color:#94a3b8;font-size:.72rem;">
                                    <?php echo e($pago->metodo ?? '—'); ?>

                                </span>
                            </td>
                            <td>
                                <?php $est = strtolower($pago->estado ?? 'pendiente'); ?>
                                <span class="badge badge-<?php echo e($est); ?>"><?php echo e(ucfirst($pago->estado ?? 'pendiente')); ?></span>
                            </td>
                            <td style="font-size:.8rem;color:#94a3b8;"><?php echo e($pago->user->name ?? '—'); ?></td>
                            <td>
                                <a href="<?php echo e(route('pagos.comprobante', $pago)); ?>" class="btn btn-sm btn-secondary" title="Ver comprobante">
                                    <i class="fas fa-receipt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-money-bill-wave d-block"></i>
                                    <p>No hay pagos que coincidan con los filtros aplicados.</p>
                                    <a href="<?php echo e(route('pagos.index')); ?>" class="btn btn-secondary btn-sm">Limpiar filtros</a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($pagos->hasPages()): ?>
        <div class="card-body border-top py-2">
            <?php echo e($pagos->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
function actualizarCampos() {
    const tipo = document.getElementById('filtro_tiempo').value;
    ['fechaDesde','fechaHasta','mes','semana','anio'].forEach(id => {
        document.getElementById(id + 'Container').style.display = 'none';
    });
    if (tipo === 'fecha')  { document.getElementById('fechaDesdeContainer').style.display = 'block'; document.getElementById('fechaHastaContainer').style.display = 'block'; }
    else if (tipo === 'mes')    document.getElementById('mesContainer').style.display = 'block';
    else if (tipo === 'semana') document.getElementById('semanaContainer').style.display = 'block';
    else if (tipo === 'anio')   document.getElementById('anioContainer').style.display = 'block';
}
document.addEventListener('DOMContentLoaded', actualizarCampos);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/pagos/index.blade.php ENDPATH**/ ?>