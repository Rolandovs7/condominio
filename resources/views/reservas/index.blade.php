@extends('plantilla')
@section('title', 'Reservas')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-calendar-check me-2" style="color:#34d399;"></i> Panel de Reservas</h2>
        @if(auth()->check() && auth()->user()->residente_id)
        <a href="{{ route('reservas.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Agendar reserva
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Lista de reservas</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Área Común</th>
                            <th>Residente</th>
                            <th>Fecha</th>
                            <th>Horario</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservas as $reserva)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $reserva->id }}</td>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">
                                    {{ $reserva->areaComun->nombre ?? 'N/D' }}
                                </div>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">
                                {{ $reserva->residente->nombre_completo ?? $reserva->residente->nombre ?? 'N/D' }}
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;white-space:nowrap;">
                                {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}
                            </td>
                            <td style="font-size:.8rem;color:#94a3b8;white-space:nowrap;">
                                {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }}
                                — {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}
                            </td>
                            <td>
                                @if($reserva->areaComun && $reserva->areaComun->monto)
                                    <strong style="color:#38bdf8;">Bs {{ number_format($reserva->areaComun->monto, 2) }}</strong>
                                @else
                                    <span style="color:#475569;">—</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $est = strtolower($reserva->estado ?? '');
                                    $bMap = ['pendiente'=>'pendiente','confirmada'=>'pagado','cancelado'=>'rechazado'];
                                @endphp
                                <span class="badge badge-{{ $bMap[$est] ?? 'pendiente' }}">
                                    {{ ucfirst($reserva->estado ?? 'N/D') }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('reservas.verificar-inventario', $reserva->id) }}"
                                       class="btn btn-secondary btn-sm" title="Verificar inventario">
                                        <i class="fas fa-clipboard-check"></i>
                                    </a>
                                    @if(auth()->check() && auth()->user()->residente_id)
                                    <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @endif
                                    <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" class="d-inline delete-form">
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
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-check d-block"></i>
                                    <p>No hay reservas registradas.</p>
                                    @if(auth()->user()->residente_id)
                                    <a href="{{ route('reservas.create') }}" class="btn btn-primary btn-sm">Agendar reserva</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($reservas,'hasPages') && $reservas->hasPages())
        <div class="card-body border-top py-2">
            {{ $reservas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        Swal.fire({
            title: '¿Eliminar reserva?',
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
