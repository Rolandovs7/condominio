@extends('plantilla')
@section('title', 'Propiedades')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-home me-2" style="color:#34d399;"></i> Gestión de Propiedades</h2>
        <a href="{{ route('propiedades.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i> Nueva propiedad
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Lista de propiedades</span>
            <span class="badge" style="background:rgba(52,211,153,.12);color:#34d399;">{{ $propiedades->count() }} propiedades</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Ubicación</th>
                            <th>Residente asignado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($propiedades as $propiedad)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $propiedad->id }}</td>
                            <td><code style="color:#38bdf8;background:rgba(56,189,248,.1);padding:2px 8px;border-radius:5px;font-size:.85rem;">{{ $propiedad->codigo }}</code></td>
                            <td style="font-size:.85rem;color:#cbd5e1;">{{ $propiedad->tipo }}</td>
                            <td style="font-size:.82rem;color:#94a3b8;"><i class="fas fa-map-marker-alt me-1" style="color:#64748b;"></i>{{ $propiedad->ubicacion }}</td>
                            <td>
                                @if($propiedad->residente)
                                    <span style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ $propiedad->residente->nombre_completo }}</span>
                                @else
                                    <span style="color:#475569;font-size:.82rem;"><i class="fas fa-user-slash me-1"></i>Sin asignar</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $propiedad->estado === 'disponible' ? 'pagado' : ($propiedad->estado === 'ocupada' ? 'en_curso' : 'pendiente') }}">
                                    {{ ucfirst($propiedad->estado) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('propiedades.show', $propiedad->id) }}" class="btn btn-secondary btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('propiedades.edit', $propiedad->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('propiedades.destroy', $propiedad->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-name="{{ $propiedad->codigo }}" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-home d-block"></i>
                                    <p>No hay propiedades registradas.</p>
                                    <a href="{{ route('propiedades.create') }}" class="btn btn-success btn-sm">Registrar propiedad</a>
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
        Swal.fire({ title:`¿Eliminar propiedad ${nombre}?`, icon:'warning',
            showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#334155',
            confirmButtonText:'Eliminar', cancelButtonText:'Cancelar', background:'#111827', color:'#e2e8f0'
        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); });
    });
});
</script>
@endpush
