@extends('plantilla')
@section('title', 'Notificaciones')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-bell me-2" style="color:#fbbf24;"></i> Notificaciones a Residentes</h2>
        <a href="{{ route('notificaciones.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-paper-plane me-1"></i> Enviar notificación
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('notificaciones.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Título o contenido..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="tipo" class="form-select">
                            <option value="">Todos los tipos</option>
                            @foreach(['Urgente','Informativa','Recordatorio'] as $t)
                            <option value="{{ $t }}" {{ request('tipo') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="leida" class="form-select">
                            <option value="">Todas</option>
                            <option value="0" {{ request('leida') === '0' ? 'selected' : '' }}>No leídas</option>
                            <option value="1" {{ request('leida') === '1' ? 'selected' : '' }}>Leídas</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-1 text-end">
                        <span style="font-size:.78rem;color:#64748b;">{{ $notificaciones->total() }}</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Historial de notificaciones</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Destinatario</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notificaciones as $n)
                        <tr>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ Str::limit($n->titulo, 50) }}</div>
                                <div style="font-size:.72rem;color:#64748b;">{{ Str::limit($n->contenido, 60) }}</div>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">
                                @if($n->residente)
                                    <i class="fas fa-user me-1" style="color:#64748b;"></i>
                                    {{ $n->residente->nombre_completo }}
                                @else
                                    <span class="badge" style="background:rgba(56,189,248,.12);color:#38bdf8;font-size:.7rem;">
                                        <i class="fas fa-users me-1"></i>Todos
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php $colors = ['Urgente' => '#f87171', 'Informativa' => '#38bdf8', 'Recordatorio' => '#fbbf24']; @endphp
                                <span class="badge" style="background:rgba(0,0,0,.2);color:{{ $colors[$n->tipo] ?? '#94a3b8' }};border:1px solid {{ $colors[$n->tipo] ?? '#94a3b8' }}44;font-size:.7rem;">
                                    {{ $n->tipo }}
                                </span>
                            </td>
                            <td>
                                @if($n->leida)
                                    <span class="badge badge-pagado">Leída</span>
                                @else
                                    <span class="badge badge-pendiente">Pendiente</span>
                                @endif
                            </td>
                            <td style="font-size:.78rem;color:#94a3b8;white-space:nowrap;">
                                {{ $n->fecha_hora ? \Carbon\Carbon::parse($n->fecha_hora)->format('d/m/Y H:i') : '—' }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('notificaciones.show', $n->id) }}" class="btn btn-secondary btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$n->leida)
                                    <form action="{{ route('notificaciones.marcar-leida', $n->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Marcar leída">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('notificaciones.destroy', $n->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-bell d-block"></i>
                                    <p>No hay notificaciones registradas.</p>
                                    <a href="{{ route('notificaciones.create') }}" class="btn btn-primary btn-sm">Enviar primera notificación</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($notificaciones->hasPages())
        <div class="card-body border-top py-2">
            {{ $notificaciones->withQueryString()->links() }}
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
            title: '¿Eliminar notificación?',
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
