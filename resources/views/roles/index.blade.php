@extends('plantilla')
@section('title', 'Roles y Permisos')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-user-shield me-2" style="color:#60a5fa;"></i> Roles y Permisos</h2>
        @can('crear roles')
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo rol
        </a>
        @endcan
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-shield-halved me-2"></i> Roles del sistema</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre del rol</th>
                            <th>Permisos asignados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $item)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $item->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                                         style="width:34px;height:34px;background:rgba(37,99,235,.2);flex-shrink:0;">
                                        <i class="fas fa-shield-halved fa-sm" style="color:#60a5fa;"></i>
                                    </div>
                                    <span style="font-weight:700;color:#e2e8f0;">{{ $item->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($item->permissions->take(5) as $perm)
                                    <span class="badge" style="background:rgba(56,189,248,.1);color:#38bdf8;border:1px solid rgba(56,189,248,.2);font-size:.65rem;">
                                        {{ $perm->name }}
                                    </span>
                                    @empty
                                    <span style="color:#475569;font-size:.8rem;">Sin permisos</span>
                                    @endforelse
                                    @if($item->permissions->count() > 5)
                                    <span class="badge" style="background:rgba(100,116,139,.15);color:#94a3b8;font-size:.65rem;">
                                        +{{ $item->permissions->count() - 5 }} más
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('editar roles')
                                    <a href="{{ route('roles.edit', ['role' => $item]) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @endcan
                                    @can('eliminar roles')
                                    <form action="{{ route('roles.destroy', ['role' => $item->id]) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar" data-name="{{ $item->name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-user-shield d-block"></i>
                                    <p>No hay roles registrados.</p>
                                    @can('crear roles')
                                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Crear primer rol</a>
                                    @endcan
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
    const nombre = btn.dataset.name;
    btn.addEventListener('click', function() {
        Swal.fire({
            title: `¿Eliminar rol "${nombre}"?`,
            text: 'Los usuarios con este rol perderán sus permisos.',
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
