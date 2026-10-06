@extends('plantilla')
@section('title', 'Empleados')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-id-badge me-2" style="color:#34d399;"></i> Empleados</h2>
        @can('crear empleados')
        <a href="{{ route('empleados.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo empleado
        </a>
        @endcan
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('empleados.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nombre, apellido o CI..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activos</option>
                            <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="{{ route('empleados.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-3 text-end">
                        <span style="font-size:.78rem;color:#64748b;">{{ $empleados->total() }} empleados</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Personal registrado</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre completo</th>
                            <th>CI</th>
                            <th>Cargo</th>
                            <th>Fecha ingreso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($empleados as $empleado)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $empleado->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                                          style="width:32px;height:32px;font-size:.75rem;background:linear-gradient(135deg,#059669,#047857);flex-shrink:0;">
                                        {{ strtoupper(substr($empleado->nombre ?? 'E', 0, 1)) }}
                                    </span>
                                    <div>
                                        <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">
                                            {{ $empleado->nombre }} {{ $empleado->apellido }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#94a3b8;font-size:.85rem;">{{ $empleado->ci }}</td>
                            <td>
                                <span class="badge" style="background:rgba(167,139,250,.12);color:#a78bfa;font-size:.72rem;">
                                    {{ $empleado->cargo?->cargo ?? 'Sin cargo' }}
                                </span>
                            </td>
                            <td style="font-size:.8rem;color:#94a3b8;">
                                {{ $empleado->fecha_ingreso ? \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') : '—' }}
                            </td>
                            <td>
                                @if($empleado->estado)
                                    <span class="badge badge-activo"><i class="fas fa-circle me-1" style="font-size:.5rem;"></i>Activo</span>
                                @else
                                    <span class="badge badge-inactivo"><i class="fas fa-circle me-1" style="font-size:.5rem;"></i>Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('editar empleados')
                                    <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @endcan
                                    @can('eliminar empleados')
                                    <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-id-badge d-block"></i>
                                    <p>No hay empleados registrados.</p>
                                    @can('crear empleados')
                                    <a href="{{ route('empleados.create') }}" class="btn btn-success btn-sm">Registrar empleado</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($empleados->hasPages())
        <div class="card-body border-top py-2">
            {{ $empleados->appends(['search' => request('search'), 'estado' => request('estado')])->links() }}
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
            title: '¿Eliminar empleado?',
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
