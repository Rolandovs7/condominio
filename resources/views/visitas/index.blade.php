@extends('plantilla')
@section('title', 'Visitas')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-door-open me-2" style="color:#fb923c;"></i> {{ $titulo ?? 'Visitas' }}</h2>
        <div class="d-flex gap-2 flex-wrap">
            @canany(['gestionar visitas','administrar visitas'])
            <a href="{{ route('visitas.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Nueva visita
            </a>
            @endcanany
            @canany(['operar porteria','administrar visitas'])
            <a href="{{ route('visitas.panel-guardia') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-shield-alt me-1"></i> Panel guardia
            </a>
            <a href="{{ route('visitas.mostrar-validar-codigo') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-key me-1"></i> Validar código
            </a>
            @endcanany
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('visitas.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Código, visitante, CI, motivo..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            @foreach(['pendiente','en_curso','finalizada','rechazada'] as $est)
                            <option value="{{ $est }}" {{ request('estado') == $est ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_',' ',$est)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="{{ route('visitas.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-3 text-end">
                        <span style="font-size:.78rem;color:#64748b;">{{ $visitas->total() }} visitas</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Registro de visitas</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Visitante</th>
                            <th>CI</th>
                            @canany(['administrar visitas','operar porteria'])
                            <th>Residente</th>
                            @endcanany
                            <th>Motivo</th>
                            <th>Estado</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visitas as $visita)
                        @php
                            $expirada = $visita->estado == 'pendiente' && now() > $visita->fecha_fin;
                        @endphp
                        <tr style="{{ $expirada ? 'opacity:.6;' : '' }}">
                            <td>
                                <code style="background:rgba(56,189,248,.1);color:#38bdf8;padding:2px 8px;border-radius:5px;font-size:.85rem;letter-spacing:.05em;">
                                    {{ $visita->codigo }}
                                </code>
                            </td>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ $visita->nombre_visitante }}</div>
                                @if($visita->placa_vehiculo)
                                <div style="font-size:.72rem;color:#64748b;"><i class="fas fa-car me-1"></i>{{ $visita->placa_vehiculo }}</div>
                                @endif
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">{{ $visita->ci_visitante }}</td>
                            @canany(['administrar visitas','operar porteria'])
                            <td style="font-size:.82rem;color:#94a3b8;">
                                {{ $visita->residente ? $visita->residente->nombre_completo : '—' }}
                            </td>
                            @endcanany
                            <td style="font-size:.82rem;color:#cbd5e1;">{{ Str::limit($visita->motivo, 35) }}</td>
                            <td>
                                @php
                                    $badges = ['pendiente'=>'pendiente','en_curso'=>'en_curso','finalizada'=>'finalizada','rechazada'=>'vencido'];
                                @endphp
                                <span class="badge badge-{{ $badges[$visita->estado] ?? 'pendiente' }}">
                                    {{ ucfirst(str_replace('_',' ',$visita->estado)) }}
                                </span>
                                @if($expirada)
                                <span class="badge badge-vencido ms-1" style="font-size:.65rem;">Expirada</span>
                                @endif
                            </td>
                            <td style="font-size:.78rem;color:#94a3b8;white-space:nowrap;">
                                {{ \Carbon\Carbon::parse($visita->fecha_inicio)->format('d/m/Y H:i') }}
                            </td>
                            <td style="font-size:.78rem;color:#94a3b8;white-space:nowrap;">
                                {{ \Carbon\Carbon::parse($visita->fecha_fin)->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('visitas.show', $visita->id) }}" class="btn btn-secondary btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($visita->estado == 'pendiente')
                                    <a href="{{ route('visitas.edit', $visita->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('visitas.destroy', $visita->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-door-open d-block"></i>
                                    <p>No hay visitas registradas.</p>
                                    @canany(['gestionar visitas','administrar visitas'])
                                    <a href="{{ route('visitas.create') }}" class="btn btn-primary btn-sm">Registrar visita</a>
                                    @endcanany
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($visitas->hasPages())
        <div class="card-body border-top py-2">
            {{ $visitas->withQueryString()->links() }}
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
            title: '¿Eliminar visita?',
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
