<?php $__env->startSection('title', 'Panel de Control'); ?>

<?php $__env->startPush('css'); ?>
<style>
.dark-page { background: #0b1120; min-height: calc(100vh - 56px); }

/* KPI cards */
.kpi-card {
    background: #111827;
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 14px;
    padding: 1.15rem 1.3rem;
    transition: box-shadow .2s, transform .2s;
    height: 100%;
}
.kpi-card:hover { box-shadow: 0 6px 28px rgba(0,0,0,.4); transform: translateY(-2px); }
.kpi-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; flex-shrink: 0;
}
.kpi-number { font-size: 1.9rem; font-weight: 800; line-height: 1; color: #f1f5f9; }
.kpi-label { font-size: .72rem; color: #64748b; text-transform: uppercase; letter-spacing: .05em; font-weight: 600; margin-top: .2rem; }
.kpi-trend { font-size: .75rem; font-weight: 600; }

/* Package cards */
.pkg-card {
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,.07);
    background: #111827;
    margin-bottom: 1.25rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.3);
    transition: box-shadow .2s;
}
.pkg-card:hover { box-shadow: 0 6px 30px rgba(0,0,0,.45); }
.pkg-header {
    padding: .85rem 1.25rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 700;
    font-size: .9rem;
    user-select: none;
    border-bottom: 1px solid rgba(255,255,255,.06);
}
.pkg-body { padding: .85rem 1.25rem; }

.cu-item {
    display: flex; align-items: center; gap: 10px;
    padding: .5rem .8rem;
    border-radius: 9px;
    margin-bottom: .25rem;
    text-decoration: none;
    font-size: .855rem;
    transition: background .15s, transform .1s;
    color: #cbd5e1;
}
a.cu-item:hover { background: rgba(255,255,255,.065); transform: translateX(3px); color: #f1f5f9; }
.cu-badge {
    font-size: .65rem; font-weight: 700;
    padding: 2px 7px; border-radius: 6px;
    min-width: 36px; text-align: center; flex-shrink: 0;
}
.badge-done    { background: rgba(52,211,153,.12); color: #34d399; border: 1px solid rgba(52,211,153,.3); }
.badge-pending { background: rgba(255,255,255,.05); color: #475569; border: 1px solid rgba(255,255,255,.08); }

.hdr-p1 { background: linear-gradient(120deg,#1e3a8a,#1d4ed8); }
.hdr-p2 { background: linear-gradient(120deg,#064e3b,#059669); }
.hdr-p3 { background: linear-gradient(120deg,#7c2d12,#ea580c); }
.hdr-p4 { background: linear-gradient(120deg,#4c1d95,#7c3aed); }

.chevron { transition: transform .22s; }
.pkg-header.collapsed .chevron { transform: rotate(-90deg); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4 dark-page fade-in">

    
    <div class="d-flex align-items-end justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-light mb-1" style="font-size:1.4rem;">
                🏢 Panel de Control
            </h2>
            <p class="mb-0" style="color:#64748b;font-size:.82rem;">
                Bienvenido, <strong style="color:#94a3b8;"><?php echo e(auth()->user()->name); ?></strong> ·
                <?php echo e(now()->format('d M Y, H:i')); ?>

            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <span class="badge" style="background:rgba(52,211,153,.12);color:#34d399;border:1px solid rgba(52,211,153,.25);font-size:.75rem;padding:.4em .8em;">
                <i class="fas fa-circle-check me-1"></i> 20 CU implementados
            </span>
            <span class="badge" style="background:rgba(56,189,248,.12);color:#38bdf8;border:1px solid rgba(56,189,248,.25);font-size:.75rem;padding:.4em .8em;">
                <i class="fas fa-boxes-stacked me-1"></i> 4 paquetes
            </span>
        </div>
    </div>

    
    <?php
        $totalResidentes = \App\Models\Residente::count();
        $cuotasPendientes = \App\Models\Cuota::where('estado','pendiente')->count();
        $visitasHoy = \App\Models\Visita::whereDate('created_at', today())->count();
        $pagosMes = \App\Models\Pago::whereMonth('fecha_pago', now()->month)->whereYear('fecha_pago', now()->year)->sum('monto_pagado');
        $incidenciasAbiertas = \App\Models\Incidencia::where('estado', 'pendiente')->count();
        $mantenimientosActivos = \App\Models\Mantenimiento::where('estado', 'en_proceso')->count();
    ?>
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <div class="kpi-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="kpi-icon" style="background:rgba(37,99,235,.2);">
                        <i class="fas fa-users" style="color:#60a5fa;"></i>
                    </div>
                </div>
                <div class="kpi-number"><?php echo e($totalResidentes); ?></div>
                <div class="kpi-label">Residentes</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="kpi-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="kpi-icon" style="background:rgba(251,191,36,.2);">
                        <i class="fas fa-file-invoice-dollar" style="color:#fbbf24;"></i>
                    </div>
                </div>
                <div class="kpi-number"><?php echo e($cuotasPendientes); ?></div>
                <div class="kpi-label">Cuotas pendientes</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="kpi-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="kpi-icon" style="background:rgba(52,211,153,.2);">
                        <i class="fas fa-dollar-sign" style="color:#34d399;"></i>
                    </div>
                </div>
                <div class="kpi-number" style="font-size:1.35rem;">Bs <?php echo e(number_format($pagosMes, 0)); ?></div>
                <div class="kpi-label">Cobrado este mes</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="kpi-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="kpi-icon" style="background:rgba(167,139,250,.2);">
                        <i class="fas fa-door-open" style="color:#a78bfa;"></i>
                    </div>
                </div>
                <div class="kpi-number"><?php echo e($visitasHoy); ?></div>
                <div class="kpi-label">Visitas hoy</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="kpi-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="kpi-icon" style="background:rgba(248,113,113,.2);">
                        <i class="fas fa-flag" style="color:#f87171;"></i>
                    </div>
                </div>
                <div class="kpi-number"><?php echo e($incidenciasAbiertas); ?></div>
                <div class="kpi-label">Incidencias abiertas</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="kpi-card">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="kpi-icon" style="background:rgba(251,146,60,.2);">
                        <i class="fas fa-tools" style="color:#fb923c;"></i>
                    </div>
                </div>
                <div class="kpi-number"><?php echo e($mantenimientosActivos); ?></div>
                <div class="kpi-label">Mantenimientos activos</div>
            </div>
        </div>
    </div>

    <hr style="border-color:rgba(255,255,255,.07);margin:0 0 1.5rem;">

    
    <div class="row g-3">

    
    <div class="col-12 col-lg-6">
        <div class="pkg-card">
            <div class="pkg-header hdr-p1 text-white" data-bs-toggle="collapse" data-bs-target="#pkg1">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-shield-halved"></i>
                    <span>PKG 1 — Acceso y Seguridad</span>
                    <span style="font-size:.65rem;opacity:.65;font-weight:400;">CU1·CU2·CU3·CU4</span>
                </div>
                <i class="fas fa-chevron-down chevron"></i>
            </div>
            <div id="pkg1" class="collapse show">
                <div class="pkg-body">
                    <div class="row g-0">
                        <div class="col-6">
                            <a href="<?php echo e(route('login')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU1</span>
                                <i class="fas fa-sign-in-alt" style="color:#60a5fa;width:14px;text-align:center;"></i> Iniciar sesión
                            </a>
                            <a href="<?php echo e(route('logout')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU2</span>
                                <i class="fas fa-sign-out-alt" style="color:#60a5fa;width:14px;text-align:center;"></i> Cerrar sesión
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo e(route('users.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU3</span>
                                <i class="fas fa-users" style="color:#60a5fa;width:14px;text-align:center;"></i> Usuarios
                            </a>
                            <a href="<?php echo e(route('roles.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU4</span>
                                <i class="fas fa-user-shield" style="color:#60a5fa;width:14px;text-align:center;"></i> Roles y permisos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-12 col-lg-6">
        <div class="pkg-card">
            <div class="pkg-header hdr-p2 text-white" data-bs-toggle="collapse" data-bs-target="#pkg2">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-people-roof"></i>
                    <span>PKG 2 — Personas y Estructura</span>
                    <span style="font-size:.65rem;opacity:.65;font-weight:400;">CU5·CU6·CU13·CU20</span>
                </div>
                <i class="fas fa-chevron-down chevron"></i>
            </div>
            <div id="pkg2" class="collapse show">
                <div class="pkg-body">
                    <div class="row g-0">
                        <div class="col-6">
                            <a href="<?php echo e(route('empleados.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU5</span>
                                <i class="fas fa-id-badge" style="color:#34d399;width:14px;text-align:center;"></i> Empleados
                            </a>
                            <a href="<?php echo e(route('residentes.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU6</span>
                                <i class="fas fa-building-user" style="color:#34d399;width:14px;text-align:center;"></i> Residentes
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo e(route('unidades.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU13</span>
                                <i class="fas fa-link" style="color:#34d399;width:14px;text-align:center;"></i> Vincular unidad
                            </a>
                            <a href="<?php echo e(route('propiedades.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU20</span>
                                <i class="fas fa-home" style="color:#34d399;width:14px;text-align:center;"></i> Propiedades
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-12 col-lg-6">
        <div class="pkg-card">
            <div class="pkg-header hdr-p3 text-white" data-bs-toggle="collapse" data-bs-target="#pkg3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-cogs"></i>
                    <span>PKG 3 — Gestión Operativa</span>
                    <span style="font-size:.65rem;opacity:.65;font-weight:400;">CU7·CU8·CU9·CU10·CU15·CU16·CU17</span>
                </div>
                <i class="fas fa-chevron-down chevron"></i>
            </div>
            <div id="pkg3" class="collapse show">
                <div class="pkg-body">
                    <div class="row g-0">
                        <div class="col-6">
                            <a href="<?php echo e(route('cuotas.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU7</span>
                                <i class="fas fa-dollar-sign" style="color:#fb923c;width:14px;text-align:center;"></i> Cuotas y pagos
                            </a>
                            <a href="<?php echo e(route('reservas.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU8</span>
                                <i class="fas fa-calendar-check" style="color:#fb923c;width:14px;text-align:center;"></i> Reservas
                            </a>
                            <a href="<?php echo e(route('mantenimientos.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU9</span>
                                <i class="fas fa-tools" style="color:#fb923c;width:14px;text-align:center;"></i> Mantenimientos
                            </a>
                            <a href="<?php echo e(route('visitas.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU10</span>
                                <i class="fas fa-door-open" style="color:#fb923c;width:14px;text-align:center;"></i> Visitas
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo e(route('empresas.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU15</span>
                                <i class="fas fa-handshake" style="color:#fb923c;width:14px;text-align:center;"></i> Empresas externas
                            </a>
                            <a href="<?php echo e(route('incidencias.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU16</span>
                                <i class="fas fa-flag" style="color:#fb923c;width:14px;text-align:center;"></i> Incidencias
                            </a>
                            <a href="<?php echo e(route('notificaciones.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU17</span>
                                <i class="fas fa-bell" style="color:#fb923c;width:14px;text-align:center;"></i> Notificaciones
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-12 col-lg-6">
        <div class="pkg-card">
            <div class="pkg-header hdr-p4 text-white" data-bs-toggle="collapse" data-bs-target="#pkg4">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-chart-bar"></i>
                    <span>PKG 4 — Comunicación y Reportes</span>
                    <span style="font-size:.65rem;opacity:.65;font-weight:400;">CU11·CU12·CU14·CU18·CU19</span>
                </div>
                <i class="fas fa-chevron-down chevron"></i>
            </div>
            <div id="pkg4" class="collapse show">
                <div class="pkg-body">
                    <div class="row g-0">
                        <div class="col-6">
                            <a href="<?php echo e(route('comunicados.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU11</span>
                                <i class="fas fa-envelope" style="color:#a78bfa;width:14px;text-align:center;"></i> Comunicados
                            </a>
                            <a href="<?php echo e(route('informes.administrativo')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU12</span>
                                <i class="fas fa-file-alt" style="color:#a78bfa;width:14px;text-align:center;"></i> Informes admin.
                            </a>
                            <a href="<?php echo e(route('informes.pagos')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU14</span>
                                <i class="fas fa-receipt" style="color:#a78bfa;width:14px;text-align:center;"></i> Reporte pagos
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo e(route('reclamos.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU18</span>
                                <i class="fas fa-exclamation-circle" style="color:#a78bfa;width:14px;text-align:center;"></i> Reclamos
                            </a>
                            <a href="<?php echo e(route('eventos.index')); ?>" class="cu-item">
                                <span class="cu-badge badge-done">CU19</span>
                                <i class="fas fa-calendar-star" style="color:#a78bfa;width:14px;text-align:center;"></i> Eventos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rolando/Escritorio/condominio/resources/views/panel/index.blade.php ENDPATH**/ ?>