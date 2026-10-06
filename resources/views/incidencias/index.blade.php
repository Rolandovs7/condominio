@extends('plantilla')
@section('title', 'Incidencias')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-flag me-2" style="color:#f87171;"></i> Denuncias e Incidencias</h2>
        <a href="{{ route('incidencias.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nueva incidencia
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('incidencias.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group search-bar">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="N° seguimiento, título, residente..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            @foreach(['pendiente','en_revision','resuelto','cerrado'] as $est)
                            <option value="{{ $est }}" {{ request('estado') == $est ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $est)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="prioridad" class="form-select">
                            <option value="">Toda prioridad</option>
                            @foreach(['baja','media','alta'] as $p)
                            <option value="{{ $p }}" {{ request('prioridad') == $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrar</button>
                        <a href="{{ route('incidencias.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="col-md-2 text-end">
                        <span style="font-size:.78rem;color:#64748b;">{{ $incidencias->total() }} registros</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Lista de incidencias</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>N° Seguimiento</th>
                            <th>Título</th>
                            <th>Residente</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incidencias as $inc)
                        <tr>
                            <td>
                                <code style="background:rgba(255,255,255,.05);color:#38bdf8;padding:2px 6px;border-radius:4px;font-size:.8rem;">
                                    {{ $inc->numero_seguimiento }}
                                </code>
                            </td>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ Str::limit($inc->titulo, 45) }}</div>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">
                                {{ $inc->residente ? $inc->residente->nombre_completo : '—' }}
                            </td>
                            <td>
                                @php $prioridades = ['baja' => ['color'=>'#38bdf8','bg'=>'rgba(56,189,248,.12)'], 'media' => ['color'=>'#fbbf24','bg'=>'rgba(251,191,36,.12)'], 'alta' => ['color'=>'#f87171','bg'=>'rgba(248,113,113,.12)']]; $pr = $prioridades[$inc->prioridad] ?? ['color'=>'#94a3b8','bg'=>'rgba(148,163,184,.12)']; @endphp
                                <span class="badge" style="background:{{ $pr['bg'] }};color:{{ $pr['color'] }};border:1px solid {{ $pr['color'] }}44;font-size:.7rem;">
                                    {{ ucfirst($inc->prioridad) }}
                                </span>
                            </td>
                            <td>
                                @php $estados = ['pendiente'=>'pendiente','en_revision'=>'en_curso','resuelto'=>'pagado','cerrado'=>'finalizada']; @endphp
                                <span class="badge badge-{{ $estados[$inc->estado] ?? 'pendiente' }}">
                                    {{ ucfirst(str_replace('_',' ',$inc->estado)) }}
                                </span>
                            </td>
                            <td style="font-size:.78rem;color:#94a3b8;">{{ $inc->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('incidencias.show', $inc->id) }}" class="btn btn-secondary btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('incidencias.edit', $inc->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('incidencias.destroy', $inc->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-flag d-block"></i>
                                    <p>No hay incidencias registradas.</p>
                                    <a href="{{ route('incidencias.create') }}" class="btn btn-primary btn-sm">Registrar incidencia</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($incidencias->hasPages())
        <div class="card-body border-top py-2">
            {{ $incidencias->withQueryString()->links() }}
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
            title: '¿Eliminar incidencia?',
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
