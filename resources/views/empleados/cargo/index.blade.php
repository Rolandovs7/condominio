@extends('plantilla')
@section('title', 'Cargos de Empleados')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-briefcase me-2" style="color:#a78bfa;"></i> Cargos de Empleados</h2>
        <a href="{{ route('cargos.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo cargo
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Cargos registrados</span>
            <span class="badge" style="background:rgba(167,139,250,.12);color:#a78bfa;">{{ count($cargos) }} cargos</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre del cargo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cargos as $cargo)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $cargo->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:30px;height:30px;border-radius:8px;background:rgba(167,139,250,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="fas fa-briefcase fa-sm" style="color:#a78bfa;"></i>
                                    </div>
                                    <span style="font-weight:600;color:#e2e8f0;">{{ $cargo->cargo }}</span>
                                </div>
                            </td>
                            <td>
                                @if($cargo->estado)
                                    <span class="badge badge-activo"><i class="fas fa-circle me-1" style="font-size:.5rem;"></i>Activo</span>
                                @else
                                    <span class="badge badge-inactivo"><i class="fas fa-circle me-1" style="font-size:.5rem;"></i>Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('cargos.edit', $cargo->id) }}"
                                       class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('cargos.destroy', $cargo->id) }}"
                                          method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                data-name="{{ $cargo->cargo }}" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-briefcase d-block"></i>
                                    <p>No hay cargos registrados.</p>
                                    <a href="{{ route('cargos.create') }}" class="btn btn-primary btn-sm">Crear cargo</a>
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
            title: `¿Eliminar cargo "${nombre}"?`,
            text: 'Los empleados con este cargo quedarán sin cargo asignado.',
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
