@extends('plantilla')
@section('title', 'Usuarios')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-users me-2" style="color:#60a5fa;"></i> Usuarios del Sistema</h2>
        @can('crear usuarios')
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo usuario
        </a>
        @endcan
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Lista de usuarios</span>
            <span class="badge" style="background:rgba(56,189,248,.12);color:#38bdf8;">{{ count($users) }} usuarios</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Asociado a</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                                          style="width:34px;height:34px;font-size:.78rem;background:linear-gradient(135deg,#1d4ed8,#2563eb);flex-shrink:0;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ $user->name }}</div>
                                        @if($user->id === auth()->id())
                                        <div style="font-size:.65rem;color:#34d399;">Tú</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">{{ $user->email }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($user->roles as $role)
                                    <span class="badge" style="background:rgba(37,99,235,.15);color:#60a5fa;border:1px solid rgba(37,99,235,.3);font-size:.7rem;">
                                        {{ $role->name }}
                                    </span>
                                    @empty
                                    <span style="color:#475569;font-size:.8rem;">Sin rol</span>
                                    @endforelse
                                </div>
                            </td>
                            <td style="font-size:.8rem;color:#94a3b8;">
                                @if($user->residente_id)
                                    <span class="badge" style="background:rgba(52,211,153,.1);color:#34d399;font-size:.7rem;">
                                        <i class="fas fa-building-user me-1"></i>Residente
                                    </span>
                                @elseif($user->empleado_id)
                                    <span class="badge" style="background:rgba(251,191,36,.1);color:#fbbf24;font-size:.7rem;">
                                        <i class="fas fa-id-badge me-1"></i>Empleado
                                    </span>
                                @else
                                    <span style="color:#475569;">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('editar usuarios')
                                    <a href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @endcan
                                    @can('eliminar usuarios')
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar" data-name="{{ $user->name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
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
            title: `¿Eliminar usuario "${nombre}"?`,
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
