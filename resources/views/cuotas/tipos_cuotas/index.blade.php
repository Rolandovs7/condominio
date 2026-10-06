@extends('plantilla')
@section('title', 'Tipos de Cuota')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-tags me-2" style="color:#fbbf24;"></i> Tipos de Cuota</h2>
        <a href="{{ route('tipos-cuotas.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo tipo
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Tipos registrados</span>
            <span class="badge" style="background:rgba(251,191,36,.12);color:#fbbf24;">{{ count($tipos) }} tipos</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Frecuencia</th>
                            <th>Editable</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tipos as $tipo)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $tipo->id }}</td>
                            <td>
                                <span style="font-weight:600;color:#e2e8f0;">{{ $tipo->nombre }}</span>
                            </td>
                            <td>
                                <span class="badge" style="background:rgba(56,189,248,.1);color:#38bdf8;font-size:.72rem;">
                                    {{ ucfirst($tipo->frecuencia) }}
                                </span>
                            </td>
                            <td>
                                @if($tipo->editable)
                                    <span class="badge badge-pagado"><i class="fas fa-check me-1"></i>Sí</span>
                                @else
                                    <span class="badge badge-inactivo"><i class="fas fa-lock me-1"></i>No</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('tipos-cuotas.edit', $tipo->id) }}"
                                       class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('tipos-cuotas.destroy', $tipo->id) }}"
                                          method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                data-name="{{ $tipo->nombre }}" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-tags d-block"></i>
                                    <p>No hay tipos de cuota registrados.</p>
                                    <a href="{{ route('tipos-cuotas.create') }}" class="btn btn-primary btn-sm">Crear tipo</a>
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
            title: `¿Eliminar tipo "${nombre}"?`,
            text: 'Las cuotas asociadas perderán su tipo.',
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
