@extends('plantilla')
@section('title', 'Residentes')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-building-user me-2" style="color:#34d399;"></i> Residentes</h2>
        @can('crear residentes')
        <a href="{{ route('residentes.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo residente
        </a>
        @endcan
    </div>

    {{-- Buscador --}}
    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('residentes.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nombre, apellido o CI..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="tipo_residente" class="form-select">
                            <option value="">Todos los tipos</option>
                            <option value="propietario" {{ request('tipo_residente') == 'propietario' ? 'selected' : '' }}>Propietario</option>
                            <option value="inquilino"   {{ request('tipo_residente') == 'inquilino'   ? 'selected' : '' }}>Inquilino</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-filter me-1"></i> Filtrar</button>
                        <a href="{{ route('residentes.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-2 text-end">
                        <span style="font-size:.8rem;color:#64748b;">{{ $residentes->total() }} registros</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-2"></i> Lista de residentes
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre completo</th>
                            <th>CI</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Morosidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($residentes as $residente)
                        <tr>
                            <td style="color:#64748b;">{{ $residente->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                                          style="width:32px;height:32px;font-size:.75rem;background:linear-gradient(135deg,#1d4ed8,#2563eb);flex-shrink:0;">
                                        {{ strtoupper(substr($residente->nombre, 0, 1)) }}
                                    </span>
                                    <div>
                                        <div style="font-weight:600;color:#e2e8f0;">{{ $residente->nombre_completo }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#94a3b8;font-size:.85rem;">{{ $residente->ci }}</td>
                            <td style="color:#94a3b8;font-size:.82rem;">{{ $residente->email }}</td>
                            <td>
                                <span class="badge" style="background:rgba(167,139,250,.12);color:#a78bfa;font-size:.72rem;">
                                    {{ ucfirst($residente->tipo_residente) }}
                                </span>
                            </td>
                            <td>
                                @if($residente->tieneMorosidad())
                                    <span class="badge badge-vencido"><i class="fas fa-exclamation-triangle me-1"></i>Moroso</span>
                                @else
                                    <span class="badge badge-pagado"><i class="fas fa-check me-1"></i>Al día</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    @can('editar residentes')
                                    <a href="{{ route('residentes.edit', $residente->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @endcan
                                    @can('eliminar residentes')
                                    <form action="{{ route('residentes.destroy', $residente->id) }}" method="POST" class="d-inline delete-form">
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
                                    <i class="fas fa-building-user d-block"></i>
                                    <p>No se encontraron residentes.</p>
                                    @can('crear residentes')
                                    <a href="{{ route('residentes.create') }}" class="btn btn-success btn-sm">Agregar primer residente</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($residentes->hasPages())
        <div class="card-body border-top py-2">
            {{ $residentes->withQueryString()->links() }}
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
            title: '¿Eliminar residente?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#334155',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#111827',
            color: '#e2e8f0',
        }).then(result => {
            if (result.isConfirmed) this.closest('form').submit();
        });
    });
});
</script>
@endpush
