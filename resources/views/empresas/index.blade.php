@extends('plantilla')
@section('title', 'Empresas Externas')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-handshake me-2" style="color:#fb923c;"></i> Empresas Externas</h2>
        @can('crear empresas')
        <a href="{{ route('empresas.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Registrar empresa
        </a>
        @endcan
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('empresas.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nombre, servicio..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="{{ route('empresas.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-5 text-end">
                        <span style="font-size:.78rem;color:#64748b;">{{ $empresas->total() }} empresas</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Empresas proveedoras</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr><th>#</th><th>Nombre</th><th>Servicio</th><th>Teléfono</th><th>Correo</th><th>Acciones</th></tr>
                    </thead>
                    <tbody>
                        @forelse($empresas as $empresa)
                        <tr>
                            <td style="color:#64748b;font-size:.8rem;">{{ $empresa->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center justify-content-center rounded"
                                         style="width:32px;height:32px;background:rgba(251,146,60,.2);flex-shrink:0;">
                                        <i class="fas fa-building fa-sm" style="color:#fb923c;"></i>
                                    </div>
                                    <span style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ $empresa->nombre }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background:rgba(251,146,60,.1);color:#fb923c;font-size:.72rem;">{{ $empresa->servicio }}</span>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;"><i class="fas fa-phone me-1" style="color:#64748b;font-size:.7rem;"></i>{{ $empresa->telefono }}</td>
                            <td style="font-size:.82rem;color:#94a3b8;">{{ $empresa->correo }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('ver empresas')
                                    <a href="{{ route('empresas.show', $empresa->id) }}" class="btn btn-secondary btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('editar empresas')
                                    <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    @endcan
                                    @can('eliminar empresas')
                                    <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-name="{{ $empresa->nombre }}" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-handshake d-block"></i>
                                    <p>No hay empresas externas registradas.</p>
                                    @can('crear empresas')
                                    <a href="{{ route('empresas.create') }}" class="btn btn-primary btn-sm">Registrar empresa</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($empresas->hasPages())
        <div class="card-body border-top py-2">{{ $empresas->appends(request()->query())->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    const nombre = btn.dataset.name;
    btn.addEventListener('click', function() {
        Swal.fire({ title:`¿Eliminar empresa "${nombre}"?`, icon:'warning',
            showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#334155',
            confirmButtonText:'Eliminar', cancelButtonText:'Cancelar', background:'#111827', color:'#e2e8f0'
        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); });
    });
});
</script>
@endpush
