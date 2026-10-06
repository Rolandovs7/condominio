@extends('plantilla')
@section('title', 'Unidades Habitacionales')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-link me-2" style="color:#34d399;"></i> Unidades Habitacionales</h2>
        @can('crear unidades')
        <a href="{{ route('unidades.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nueva unidad
        </a>
        @endcan
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('unidades.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Código, residente..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="activa"    {{ request('estado') == 'activa'    ? 'selected' : '' }}>Activa</option>
                            <option value="inactiva"  {{ request('estado') == 'inactiva'  ? 'selected' : '' }}>Inactiva</option>
                            <option value="ocupada"   {{ request('estado') == 'ocupada'   ? 'selected' : '' }}>Ocupada</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="{{ route('unidades.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-3 text-end">
                        <span style="font-size:.78rem;color:#64748b;">{{ $unidades->total() }} unidades</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Lista de unidades</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Residente asignado</th>
                            <th>Tipo ocupación</th>
                            <th>Personas</th>
                            <th>Vehículos</th>
                            <th>Mascotas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($unidades as $u)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $u->id }}</td>
                            <td><code style="color:#38bdf8;background:rgba(56,189,248,.1);padding:2px 8px;border-radius:5px;font-size:.85rem;">{{ $u->codigo }}</code></td>
                            <td>
                                @if($u->residente)
                                    <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ $u->residente->nombre_completo }}</div>
                                @else
                                    <span style="color:#475569;font-size:.82rem;"><i class="fas fa-user-slash me-1"></i>Sin asignar</span>
                                @endif
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">{{ $u->tipo_ocupacion }}</td>
                            <td style="text-align:center;color:#94a3b8;font-size:.85rem;">{{ $u->personas_por_unidad }}</td>
                            <td style="text-align:center;color:#94a3b8;font-size:.85rem;">{{ $u->vehiculos }}</td>
                            <td style="text-align:center;">
                                @if($u->tiene_mascotas)
                                    <span class="badge badge-en_curso" style="font-size:.65rem;">Sí</span>
                                @else
                                    <span style="color:#475569;font-size:.78rem;">No</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $u->estado === 'activa' ? 'activo' : 'inactivo' }}">
                                    {{ ucfirst($u->estado) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('ver unidades')
                                    <a href="{{ route('unidades.show', $u->id) }}" class="btn btn-secondary btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('editar unidades')
                                    <a href="{{ route('unidades.edit', $u->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    @endcan
                                    @can('eliminar unidades')
                                    <form action="{{ route('unidades.destroy', $u->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-name="{{ $u->codigo }}" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-home d-block"></i>
                                    <p>No hay unidades registradas.</p>
                                    @can('crear unidades')
                                    <a href="{{ route('unidades.create') }}" class="btn btn-primary btn-sm">Crear unidad</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($unidades->hasPages())
        <div class="card-body border-top py-2">{{ $unidades->appends(request()->query())->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    const nombre = btn.dataset.name;
    btn.addEventListener('click', function() {
        Swal.fire({ title:`¿Eliminar unidad ${nombre}?`, icon:'warning',
            showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#334155',
            confirmButtonText:'Eliminar', cancelButtonText:'Cancelar', background:'#111827', color:'#e2e8f0'
        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); });
    });
});
</script>
@endpush
