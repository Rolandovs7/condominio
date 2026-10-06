@extends('plantilla')
@section('title', 'Cuotas')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-file-invoice-dollar me-2" style="color:#fbbf24;"></i> Cuotas y Pagos</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('tipos-cuotas.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-tags me-1"></i> Tipos de cuota
            </a>
            <a href="{{ route('cuotas.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Emitir cuota
            </a>
        </div>
    </div>

    {{-- Resumen estado --}}
    @php
        $totalPendientes = $cuotas->where('estado','pendiente')->count();
        $totalPagadas    = $cuotas->where('estado','pagado')->count();
        $totalMonto      = $cuotas->sum('monto');
    @endphp
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(251,191,36,.2);"><i class="fas fa-clock" style="color:#fbbf24;"></i></div>
                <div>
                    <div class="stat-number">{{ $totalPendientes }}</div>
                    <div class="stat-label">Pendientes</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(52,211,153,.2);"><i class="fas fa-check" style="color:#34d399;"></i></div>
                <div>
                    <div class="stat-number">{{ $totalPagadas }}</div>
                    <div class="stat-label">Pagadas</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(56,189,248,.2);"><i class="fas fa-dollar-sign" style="color:#38bdf8;"></i></div>
                <div>
                    <div class="stat-number" style="font-size:1.4rem;">Bs {{ number_format($totalMonto, 2) }}</div>
                    <div class="stat-label">Total emitido</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Lista de cuotas</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Residente</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Vencimiento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuotas as $cuota)
                        @php
                            $vencida = $cuota->estado != 'pagado' && \Carbon\Carbon::parse($cuota->fecha_vencimiento)->isPast();
                        @endphp
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $cuota->id }}</td>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">
                                    {{ $cuota->residente->nombre_completo ?? 'N/A' }}
                                </div>
                            </td>
                            <td style="font-size:.85rem;color:#cbd5e1;">{{ Str::limit($cuota->titulo ?? $cuota->concepto ?? 'Cuota mensual', 40) }}</td>
                            <td><strong style="color:#38bdf8;">Bs {{ number_format($cuota->monto, 2) }}</strong></td>
                            <td style="font-size:.8rem;color:{{ $vencida ? '#f87171' : '#94a3b8' }};">
                                {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}
                                @if($vencida)<span class="badge badge-vencido ms-1" style="font-size:.65rem;">Vencida</span>@endif
                            </td>
                            <td>
                                @php $estados = ['pagado'=>'pagado','pendiente'=>'pendiente','activa'=>'en_curso','cancelada'=>'rechazado']; @endphp
                                <span class="badge badge-{{ $estados[$cuota->estado] ?? 'pendiente' }}">{{ ucfirst($cuota->estado) }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('ver cuotas')
                                    <a href="{{ route('cuotas.show', $cuota->id) }}" class="btn btn-secondary btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endcan
                                    <a href="{{ route('cuotas.edit', $cuota->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('cuotas.destroy', $cuota->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-file-invoice d-block"></i>
                                    <p>No hay cuotas registradas.</p>
                                    <a href="{{ route('cuotas.create') }}" class="btn btn-primary btn-sm">Emitir primera cuota</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        Swal.fire({
            title: '¿Eliminar cuota?',
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
@endpush
