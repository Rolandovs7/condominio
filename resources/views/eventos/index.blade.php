@extends('plantilla')
@section('title', 'Eventos Comunitarios')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-calendar-star me-2" style="color:#a78bfa;"></i> Eventos Comunitarios</h2>
        <a href="{{ route('eventos.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo evento
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('eventos.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Nombre, lugar..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            @foreach(['programado','en_curso','finalizado','cancelado'] as $est)
                            <option value="{{ $est }}" {{ request('estado') == $est ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$est)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="{{ route('eventos.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-4 text-end">
                        <span style="font-size:.78rem;color:#64748b;">{{ $eventos->total() }} eventos</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Calendario de eventos</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Lugar</th>
                            <th>Fecha y hora</th>
                            <th>Cupo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eventos as $ev)
                        <tr>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ Str::limit($ev->nombre, 45) }}</div>
                                @if($ev->descripcion)
                                <div style="font-size:.72rem;color:#64748b;">{{ Str::limit($ev->descripcion, 60) }}</div>
                                @endif
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">
                                <i class="fas fa-map-marker-alt me-1" style="color:#64748b;"></i>{{ $ev->lugar }}
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;white-space:nowrap;">
                                {{ \Carbon\Carbon::parse($ev->fecha_hora)->format('d/m/Y H:i') }}
                            </td>
                            <td style="font-size:.85rem;color:#94a3b8;text-align:center;">
                                {{ $ev->cupo_maximo ?? '∞' }}
                            </td>
                            <td>
                                @php $map = ['programado'=>'en_curso','en_curso'=>'en_curso','finalizado'=>'pagado','cancelado'=>'rechazado']; @endphp
                                <span class="badge badge-{{ $map[$ev->estado] ?? 'pendiente' }}">
                                    {{ ucfirst(str_replace('_',' ',$ev->estado)) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('eventos.show', $ev->id) }}" class="btn btn-secondary btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('eventos.edit', $ev->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('eventos.destroy', $ev->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-star d-block"></i>
                                    <p>No hay eventos registrados.</p>
                                    <a href="{{ route('eventos.create') }}" class="btn btn-primary btn-sm">Crear evento</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($eventos->hasPages())
        <div class="card-body border-top py-2">{{ $eventos->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        Swal.fire({ title:'¿Eliminar evento?', text:'Esta acción no se puede deshacer.', icon:'warning',
            showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#334155',
            confirmButtonText:'Eliminar', cancelButtonText:'Cancelar', background:'#111827', color:'#e2e8f0'
        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); });
    });
});
</script>
@endpush
