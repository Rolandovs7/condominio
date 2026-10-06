@extends('plantilla')
@section('title', 'Mantenimientos')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-tools me-2" style="color:#fb923c;"></i> Mantenimientos</h2>
        <a href="{{ route('mantenimientos.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo mantenimiento
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('mantenimientos.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Buscar..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="filter" class="form-select">
                            <option value="descripcion" {{ request('filter','descripcion') == 'descripcion' ? 'selected' : '' }}>Descripción</option>
                            <option value="usuario"     {{ request('filter') == 'usuario'     ? 'selected' : '' }}>Usuario</option>
                            <option value="empresa"     {{ request('filter') == 'empresa'     ? 'selected' : '' }}>Empresa</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                            <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelado"  {{ request('estado') == 'cancelado'  ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-2 text-end">
                        <span style="font-size:.78rem;color:#64748b;">{{ $mantenimientos->total() }} registros</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-2"></i> Lista de mantenimientos
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            @php
                                $dir = request('direction') === 'asc' ? 'desc' : 'asc';
                                $sortLink = fn($col) => route('mantenimientos.index', array_merge(request()->all(), ['sort' => $col, 'direction' => $dir]));
                                $arrow = fn($col) => request('sort') === $col ? (request('direction') === 'asc' ? ' ↑' : ' ↓') : '';
                            @endphp
                            <th><a href="{{ $sortLink('id') }}" style="color:inherit;text-decoration:none;">#{{ $arrow('id') }}</a></th>
                            <th><a href="{{ $sortLink('descripcion') }}" style="color:inherit;text-decoration:none;">Descripción{{ $arrow('descripcion') }}</a></th>
                            <th><a href="{{ $sortLink('monto') }}" style="color:inherit;text-decoration:none;">Monto{{ $arrow('monto') }}</a></th>
                            <th><a href="{{ $sortLink('fecha_hora') }}" style="color:inherit;text-decoration:none;">Fecha{{ $arrow('fecha_hora') }}</a></th>
                            <th>Responsable</th>
                            <th>Empresa</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mantenimientos as $m)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $m->id }}</td>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ Str::limit($m->descripcion, 50) }}</div>
                            </td>
                            <td>
                                @if($m->monto)
                                    <strong style="color:#38bdf8;">Bs {{ number_format($m->monto, 2) }}</strong>
                                @else
                                    <span style="color:#475569;">—</span>
                                @endif
                            </td>
                            <td style="font-size:.78rem;color:#94a3b8;white-space:nowrap;">
                                {{ $m->fecha_hora ? \Carbon\Carbon::parse($m->fecha_hora)->format('d/m/Y H:i') : '—' }}
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">{{ $m->usuario->name ?? '—' }}</td>
                            <td style="font-size:.82rem;color:#94a3b8;">{{ $m->empresa?->nombre ?? '—' }}</td>
                            <td>
                                @php
                                    $est = $m->estado;
                                    if ($est === 1 || $est === 'en_proceso') { $cls = 'en_curso'; $label = 'En proceso'; }
                                    elseif ($est === 0 || $est === 'completado') { $cls = 'pagado'; $label = 'Completado'; }
                                    elseif ($est === 'cancelado') { $cls = 'rechazado'; $label = 'Cancelado'; }
                                    else { $cls = 'pendiente'; $label = ucfirst($est); }
                                @endphp
                                <span class="badge badge-{{ $cls }}">{{ $label }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('mantenimientos.edit', $m->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('mantenimientos.destroy', $m->id) }}" method="POST" class="d-inline delete-form">
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
                                    <i class="fas fa-tools d-block"></i>
                                    <p>No hay mantenimientos registrados.</p>
                                    <a href="{{ route('mantenimientos.create') }}" class="btn btn-primary btn-sm">Registrar mantenimiento</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($mantenimientos->hasPages())
        <div class="card-body border-top py-2">
            {{ $mantenimientos->appends(request()->all())->links() }}
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
            title: '¿Eliminar mantenimiento?',
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
