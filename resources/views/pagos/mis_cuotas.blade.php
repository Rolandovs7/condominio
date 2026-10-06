@extends('plantilla')
@section('title', 'Mis Cuotas')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-file-invoice-dollar me-2" style="color:#fbbf24;"></i> Mis Cuotas</h2>
        <span style="font-size:.82rem;color:#64748b;">Gestiona tus pagos pendientes y consulta tu historial</span>
    </div>

    {{-- Resumen --}}
    @php
        $pendientes = $cuotas->where(fn($c) => !$c->estaPagada());
        $pagadas    = $cuotas->where(fn($c) => $c->estaPagada());
        $totalPend  = $pendientes->sum('monto');
    @endphp
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(251,191,36,.2);">
                    <i class="fas fa-clock" style="color:#fbbf24;"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $pendientes->count() }}</div>
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
                    <div class="stat-number">{{ $pagadas->count() }}</div>
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
                    <div class="stat-number" style="font-size:1.4rem;">Bs {{ number_format($totalPend, 2) }}</div>
                    <div class="stat-label">Total adeudado</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Detalle de cuotas</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Vencimiento</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuotas as $cuota)
                        @php $vencida = !$cuota->estaPagada() && \Carbon\Carbon::parse($cuota->fecha_vencimiento)->isPast(); @endphp
                        <tr>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ $cuota->titulo }}</div>
                                @if($cuota->descripcion)
                                <div style="font-size:.75rem;color:#64748b;">{{ $cuota->descripcion }}</div>
                                @endif
                            </td>
                            <td><strong style="color:#38bdf8;">Bs {{ number_format($cuota->monto, 2) }}</strong></td>
                            <td style="font-size:.82rem;color:{{ $vencida ? '#f87171' : '#94a3b8' }};">
                                {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}
                                @if($vencida)
                                <div style="font-size:.7rem;"><i class="fas fa-exclamation-triangle me-1"></i>Vencida</div>
                                @endif
                            </td>
                            <td>
                                @if($cuota->estaPagada())
                                    <span class="badge badge-pagado"><i class="fas fa-check me-1"></i>Pagada</span>
                                @elseif($vencida)
                                    <span class="badge badge-vencido"><i class="fas fa-times me-1"></i>Vencida</span>
                                @else
                                    <span class="badge badge-pendiente"><i class="fas fa-clock me-1"></i>Pendiente</span>
                                @endif
                            </td>
                            <td>
                                @if(!$cuota->estaPagada())
                                    <a href="{{ route('pagos.create.cuota', ['cuota' => $cuota->id]) }}"
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-credit-card me-1"></i> Pagar
                                    </a>
                                @else
                                    @if($cuota->pagos->isNotEmpty())
                                    <a href="{{ route('pagos.comprobante', $cuota->pagos->first()->id) }}"
                                       class="btn btn-secondary btn-sm" target="_blank">
                                        <i class="fas fa-receipt me-1"></i> Comprobante
                                    </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-file-invoice d-block" style="color:#34d399;"></i>
                                    <p>No tienes cuotas registradas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($cuotas->hasPages())
        <div class="card-body border-top py-2">{{ $cuotas->links() }}</div>
        @endif
    </div>
</div>
@endsection
