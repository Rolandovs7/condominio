@extends('plantilla')
@section('title', 'Pagos')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-money-bill-wave me-2" style="color:#34d399;"></i> Listado de Pagos</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('pagos.mis_cuotas') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list me-1"></i> Mis cuotas
            </a>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pagos.index') }}" id="filtroForm">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Buscar residente / cuota</label>
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nombre, apellido, unidad..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Método de pago</label>
                        <select name="metodo" class="form-select">
                            <option value="">Todos</option>
                            @foreach(['efectivo','transferencia','QR','Stripe'] as $m)
                                <option value="{{ $m }}" {{ request('metodo') == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Filtro tiempo</label>
                        <select name="filtro_tiempo" id="filtro_tiempo" class="form-select" onchange="actualizarCampos()">
                            <option value="">Sin filtro</option>
                            <option value="fecha"  {{ request('filtro_tiempo') == 'fecha'  ? 'selected' : '' }}>Por fecha</option>
                            <option value="mes"    {{ request('filtro_tiempo') == 'mes'    ? 'selected' : '' }}>Por mes</option>
                            <option value="semana" {{ request('filtro_tiempo') == 'semana' ? 'selected' : '' }}>Por semana</option>
                            <option value="anio"   {{ request('filtro_tiempo') == 'anio'   ? 'selected' : '' }}>Por año</option>
                        </select>
                    </div>
                    <div class="col-md-2" id="fechaDesdeContainer" style="display:none;">
                        <label class="form-label">Desde</label>
                        <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-2" id="fechaHastaContainer" style="display:none;">
                        <label class="form-label">Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-md-2" id="mesContainer" style="display:none;">
                        <label class="form-label">Mes</label>
                        <input type="month" name="mes" class="form-control" value="{{ request('mes') }}">
                    </div>
                    <div class="col-md-2" id="semanaContainer" style="display:none;">
                        <label class="form-label">Semana</label>
                        <input type="week" name="semana" class="form-control" value="{{ request('semana') }}">
                    </div>
                    <div class="col-md-2" id="anioContainer" style="display:none;">
                        <label class="form-label">Año</label>
                        <input type="number" name="anio" class="form-control" min="2000" max="{{ date('Y')+1 }}" value="{{ request('anio') }}">
                    </div>
                    <div class="col-md-1 d-flex gap-1">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-filter"></i></button>
                        <a href="{{ route('pagos.index') }}" class="btn btn-secondary btn-sm" title="Limpiar"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Pagos registrados</span>
            <span class="badge" style="background:rgba(52,211,153,.15);color:#34d399;">
                Total: {{ $pagos->total() }}
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
                        @forelse($pagos as $pago)
                        <tr>
                            <td style="color:#64748b;">{{ $pago->id }}</td>
                            <td>
                                @if($pago->cuota && $pago->cuota->residente)
                                    <span style="font-weight:600;color:#e2e8f0;">{{ $pago->cuota->residente->nombre_completo }}</span>
                                    <div style="font-size:.72rem;color:#64748b;">{{ $pago->cuota->residente->ci ?? '' }}</div>
                                @elseif($pago->multa && $pago->multa->residente)
                                    <span style="font-weight:600;color:#e2e8f0;">{{ $pago->multa->residente->nombre_completo }}</span>
                                @else
                                    <span style="color:#475569;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($pago->cuota_id)
                                    <span class="badge" style="background:rgba(56,189,248,.12);color:#38bdf8;font-size:.72rem;">
                                        <i class="fas fa-file-invoice me-1"></i>Cuota #{{ $pago->cuota_id }}
                                    </span>
                                @elseif($pago->multa_id)
                                    <span class="badge" style="background:rgba(248,113,113,.12);color:#f87171;font-size:.72rem;">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Multa #{{ $pago->multa_id }}
                                    </span>
                                @endif
                            </td>
                            <td><strong style="color:#34d399;">Bs {{ number_format($pago->monto_pagado, 2) }}</strong></td>
                            <td style="color:#94a3b8;font-size:.82rem;">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge" style="background:rgba(100,116,139,.15);color:#94a3b8;font-size:.72rem;">
                                    {{ $pago->metodo ?? '—' }}
                                </span>
                            </td>
                            <td>
                                @php $est = strtolower($pago->estado ?? 'pendiente'); @endphp
                                <span class="badge badge-{{ $est }}">{{ ucfirst($pago->estado ?? 'pendiente') }}</span>
                            </td>
                            <td style="font-size:.8rem;color:#94a3b8;">{{ $pago->user->name ?? '—' }}</td>
                            <td>
                                <a href="{{ route('pagos.comprobante', $pago) }}" class="btn btn-sm btn-secondary" title="Ver comprobante">
                                    <i class="fas fa-receipt"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-money-bill-wave d-block"></i>
                                    <p>No hay pagos que coincidan con los filtros aplicados.</p>
                                    <a href="{{ route('pagos.index') }}" class="btn btn-secondary btn-sm">Limpiar filtros</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($pagos->hasPages())
        <div class="card-body border-top py-2">
            {{ $pagos->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('js')
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
@endpush
