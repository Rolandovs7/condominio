@extends('plantilla')
@section('title', 'Bitácora del Sistema')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-book me-2" style="color:#38bdf8;"></i> Bitácora del Sistema</h2>
        <span style="font-size:.8rem;color:#64748b;">Registro de todas las acciones realizadas en el sistema</span>
    </div>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('bitacora.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Buscar por usuario o acción..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="desde" class="form-control" value="{{ request('desde') }}" placeholder="Desde">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}" placeholder="Hasta">
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="{{ route('bitacora.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-2 text-end">
                        <span style="font-size:.8rem;color:#64748b;">{{ $bitacoras->total() }} registros</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-history me-2"></i> Historial de actividad
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Fecha y hora</th>
                            <th>IP</th>
                            <th>Ref.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bitacoras as $b)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $b->id }}</td>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.85rem;">
                                    {{ $b->usuario ?? ($b->user->name ?? 'Sistema') }}
                                </div>
                                @if($b->user)
                                <div style="font-size:.72rem;color:#64748b;">{{ $b->user->email ?? '' }}</div>
                                @endif
                            </td>
                            <td style="font-size:.85rem;color:#cbd5e1;">{{ $b->accion }}</td>
                            <td style="font-size:.8rem;color:#94a3b8;white-space:nowrap;">
                                {{ $b->fecha_hora ? \Carbon\Carbon::parse($b->fecha_hora)->format('d/m/Y H:i:s') : '—' }}
                            </td>
                            <td style="font-size:.78rem;color:#64748b;font-family:monospace;">{{ $b->ip ?? '—' }}</td>
                            <td style="font-size:.78rem;color:#64748b;">{{ $b->id_operacion ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-book d-block"></i>
                                    <p>No hay registros en la bitácora.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($bitacoras->hasPages())
        <div class="card-body border-top py-2">
            {{ $bitacoras->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
