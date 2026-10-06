<?php $__env->startSection('title', 'Informe Administrativo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-file-alt me-2" style="color:#a78bfa;"></i> Informe Administrativo</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-secondary btn-sm" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Imprimir
            </button>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-filter me-2"></i> Parámetros del informe</div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('informes.administrativo')); ?>" id="informeForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Tipo de informe</label>
                        <select name="tipo" class="form-select" onchange="document.getElementById('informeForm').submit()">
                            <option value="residentes"     <?php echo e(request('tipo','residentes') == 'residentes'     ? 'selected' : ''); ?>>Residentes</option>
                            <option value="unidades"       <?php echo e(request('tipo') == 'unidades'       ? 'selected' : ''); ?>>Unidades habitacionales</option>
                            <option value="mantenimientos" <?php echo e(request('tipo') == 'mantenimientos' ? 'selected' : ''); ?>>Mantenimientos</option>
                            <option value="incidencias"    <?php echo e(request('tipo') == 'incidencias'    ? 'selected' : ''); ?>>Incidencias</option>
                        </select>
                    </div>
                    <?php if(in_array(request('tipo'), ['mantenimientos','incidencias'])): ?>
                    <div class="col-md-2">
                        <label class="form-label">Desde</label>
                        <input type="date" name="desde" class="form-control" value="<?php echo e(request('desde')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Hasta</label>
                        <input type="date" name="hasta" class="form-control" value="<?php echo e(request('hasta')); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fas fa-chart-bar me-1"></i> Generar informe
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card" id="informe-resultado">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> <?php echo e($titulo); ?></span>
            <?php if(isset($datos) && !$datos->isEmpty()): ?>
            <span class="badge" style="background:rgba(52,211,153,.12);color:#34d399;">
                <?php echo e($datos->count()); ?> registros
            </span>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <?php if(!isset($datos) || $datos->isEmpty()): ?>
                <div class="empty-state">
                    <i class="fas fa-file-alt d-block"></i>
                    <p>No se encontraron registros para los filtros seleccionados.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <?php if(request('tipo','residentes') === 'residentes'): ?>
                    <table class="table mb-0">
                        <thead>
                            <tr><th>#</th><th>Nombre</th><th>Apellido</th><th>CI</th><th>Email</th><th>Tipo</th></tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="color:#64748b;font-size:.8rem;"><?php echo e($loop->iteration); ?></td>
                                <td style="font-weight:600;color:#e2e8f0;"><?php echo e($r->nombre); ?></td>
                                <td style="color:#cbd5e1;"><?php echo e($r->apellido); ?></td>
                                <td style="color:#94a3b8;font-size:.85rem;"><?php echo e($r->ci); ?></td>
                                <td style="color:#94a3b8;font-size:.82rem;"><?php echo e($r->email); ?></td>
                                <td><span class="badge" style="background:rgba(167,139,250,.12);color:#a78bfa;font-size:.7rem;"><?php echo e(ucfirst($r->tipo_residente)); ?></span></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <?php elseif(request('tipo') === 'unidades'): ?>
                    <table class="table mb-0">
                        <thead>
                            <tr><th>#</th><th>Código</th><th>Residente</th><th>Tipo ocupación</th><th>Estado</th><th>Personas</th><th>Vehículos</th></tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="color:#64748b;font-size:.8rem;"><?php echo e($loop->iteration); ?></td>
                                <td><code style="color:#38bdf8;background:rgba(56,189,248,.1);padding:2px 7px;border-radius:4px;"><?php echo e($u->codigo); ?></code></td>
                                <td style="color:#cbd5e1;"><?php echo e($u->residente ? $u->residente->nombre.' '.$u->residente->apellido : '—'); ?></td>
                                <td style="color:#94a3b8;font-size:.85rem;"><?php echo e($u->tipo_ocupacion); ?></td>
                                <td><span class="badge badge-<?php echo e($u->estado === 'ocupada' ? 'pagado' : 'pendiente'); ?>"><?php echo e(ucfirst($u->estado)); ?></span></td>
                                <td style="text-align:center;color:#94a3b8;"><?php echo e($u->personas_por_unidad); ?></td>
                                <td style="text-align:center;color:#94a3b8;"><?php echo e($u->vehiculos); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <?php elseif(request('tipo') === 'mantenimientos'): ?>
                    <table class="table mb-0">
                        <thead>
                            <tr><th>#</th><th>Descripción</th><th>Empresa</th><th>Monto (Bs)</th><th>Fecha</th><th>Estado</th></tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="color:#64748b;font-size:.8rem;"><?php echo e($loop->iteration); ?></td>
                                <td style="font-weight:600;color:#e2e8f0;"><?php echo e(Str::limit($m->descripcion, 50)); ?></td>
                                <td style="color:#94a3b8;font-size:.85rem;"><?php echo e($m->empresa?->nombre ?? '—'); ?></td>
                                <td><strong style="color:#38bdf8;">Bs <?php echo e(number_format($m->monto, 2)); ?></strong></td>
                                <td style="color:#94a3b8;font-size:.82rem;"><?php echo e(\Carbon\Carbon::parse($m->fecha_hora)->format('d/m/Y')); ?></td>
                                <td><span class="badge <?php echo e($m->estado == 1 ? 'badge-activo' : 'badge-inactivo'); ?>"><?php echo e($m->estado == 1 ? 'Activo' : 'Inactivo'); ?></span></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr style="background:rgba(255,255,255,.04);">
                                <td colspan="3" style="font-weight:700;color:#e2e8f0;padding:.7rem 1rem;">Total:</td>
                                <td style="font-weight:700;color:#34d399;padding:.7rem 1rem;">Bs <?php echo e(number_format($datos->sum('monto'), 2)); ?></td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>

                    <?php elseif(request('tipo') === 'incidencias'): ?>
                    <table class="table mb-0">
                        <thead>
                            <tr><th>#</th><th>N° Seguimiento</th><th>Título</th><th>Residente</th><th>Prioridad</th><th>Estado</th><th>Fecha</th></tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="color:#64748b;font-size:.8rem;"><?php echo e($loop->iteration); ?></td>
                                <td><code style="color:#38bdf8;background:rgba(56,189,248,.1);padding:2px 7px;border-radius:4px;font-size:.8rem;"><?php echo e($inc->numero_seguimiento); ?></code></td>
                                <td style="font-weight:600;color:#e2e8f0;"><?php echo e(Str::limit($inc->titulo, 40)); ?></td>
                                <td style="color:#94a3b8;font-size:.82rem;"><?php echo e($inc->residente->nombre); ?> <?php echo e($inc->residente->apellido); ?></td>
                                <td>
                                    <?php $pc = ['baja'=>'#38bdf8','media'=>'#fbbf24','alta'=>'#f87171']; $c = $pc[$inc->prioridad] ?? '#94a3b8'; ?>
                                    <span class="badge" style="background:<?php echo e($c); ?>22;color:<?php echo e($c); ?>;border:1px solid <?php echo e($c); ?>44;font-size:.7rem;"><?php echo e(ucfirst($inc->prioridad)); ?></span>
                                </td>
                                <td><span class="badge badge-<?php echo e(['pendiente'=>'pendiente','en_revision'=>'en_curso','resuelto'=>'pagado','cerrado'=>'finalizada'][$inc->estado] ?? 'pendiente'); ?>"><?php echo e(ucfirst(str_replace('_',' ',$inc->estado))); ?></span></td>
                                <td style="color:#94a3b8;font-size:.8rem;"><?php echo e($inc->created_at->format('d/m/Y')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
                <div class="card-body border-top" style="font-size:.8rem;color:#64748b;">
                    <i class="fas fa-info-circle me-1"></i> Total de registros: <strong style="color:#94a3b8;"><?php echo e($datos->count()); ?></strong>
                    · Generado el <?php echo e(now()->format('d/m/Y H:i')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/informes/administrativo.blade.php ENDPATH**/ ?>