@extends('plantilla')
@section('title', 'Áreas Comunes')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-building me-2" style="color:#38bdf8;"></i> Áreas Comunes</h2>
        @if(auth()->check() && !auth()->user()->residente_id)
        <a href="{{ route('areas-comunes.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nueva área común
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> Catálogo de áreas comunes</span>
            <span class="badge" style="background:rgba(56,189,248,.12);color:#38bdf8;">
                {{ count($areasComunes) }} áreas
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Capacidad</th>
                            <th>Costo/hora (Bs)</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($areasComunes as $area)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $area->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center justify-content-center rounded"
                                         style="width:34px;height:34px;background:rgba(56,189,248,.15);flex-shrink:0;">
                                        <i class="fas fa-building fa-sm" style="color:#38bdf8;"></i>
                                    </div>
                                    <span style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ $area->nombre }}</span>
                                </div>
                            </td>
                            <td style="color:#94a3b8;font-size:.85rem;">{{ $area->capacidad ?? '—' }}</td>
                            <td>
                                <strong style="color:#38bdf8;">Bs {{ number_format($area->monto, 2) }}</strong>
                            </td>
                            <td>
                                @php
                                    $est = strtolower($area->estado);
                                    $cl  = match($est) { 'activo' => 'activo', 'inactivo' => 'inactivo', 'mantenimiento' => 'pendiente', default => 'pendiente' };
                                @endphp
                                <span class="badge badge-{{ $cl }}">{{ ucfirst($area->estado) }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if(auth()->check() && auth()->user()->residente_id)
                                    <a href="{{ route('reservas.create') }}?area={{ $area->id }}"
                                       class="btn btn-success btn-sm" title="Reservar">
                                        <i class="fas fa-calendar-plus"></i>
                                    </a>
                                    @endif
                                    @if(auth()->check() && !auth()->user()->residente_id)
                                    <a href="{{ route('areas-comunes.edit', $area->id) }}"
                                       class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('areas-comunes.destroy', $area->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                data-name="{{ $area->nombre }}" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-building d-block"></i>
                                    <p>No hay áreas comunes registradas.</p>
                                    @if(auth()->check() && !auth()->user()->residente_id)
                                    <a href="{{ route('areas-comunes.create') }}" class="btn btn-primary btn-sm">Crear área común</a>
                                    @endif
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
        Swal.fire({ title: `¿Eliminar área "${nombre}"?`, icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#334155',
            confirmButtonText: 'Eliminar', cancelButtonText: 'Cancelar', background: '#111827', color: '#e2e8f0'
        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); });
    });
});
</script>
@endpush
