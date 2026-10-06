@extends('plantilla')
@section('title', 'Comunicados')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-envelope me-2" style="color:#a78bfa;"></i> Comunicados</h2>
        @if(auth()->check() && !auth()->user()->residente_id && !auth()->user()->empleado_id)
        <a href="{{ route('comunicados.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nuevo comunicado
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-table me-2"></i> Lista de comunicados</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Contenido</th>
                            <th>Autor</th>
                            <th>Fecha publicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comunicados as $comunicado)
                        <tr>
                            <td>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.875rem;">{{ $comunicado->titulo }}</div>
                            </td>
                            <td>
                                @php $tipoColors = ['Aviso'=>'#38bdf8','Reglamento'=>'#a78bfa','Evento'=>'#34d399','Urgente'=>'#f87171']; $tc = $tipoColors[$comunicado->tipo] ?? '#94a3b8'; @endphp
                                <span class="badge" style="background:{{ $tc }}22;color:{{ $tc }};border:1px solid {{ $tc }}44;font-size:.7rem;">
                                    {{ $comunicado->tipo }}
                                </span>
                            </td>
                            <td style="font-size:.82rem;color:#94a3b8;">{{ Str::limit($comunicado->contenido, 60) }}</td>
                            <td style="font-size:.82rem;color:#94a3b8;">{{ $comunicado->usuario->name ?? '—' }}</td>
                            <td style="font-size:.78rem;color:#94a3b8;">
                                {{ $comunicado->fecha_publicacion ? $comunicado->fecha_publicacion->format('d/m/Y H:i') : 'Inmediato' }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('comunicados.show', $comunicado->id) }}" class="btn btn-secondary btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->check() && !auth()->user()->residente_id && !auth()->user()->empleado_id)
                                    <a href="{{ route('comunicados.edit', $comunicado->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('comunicados.destroy', $comunicado->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Eliminar">
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
                                    <i class="fas fa-envelope d-block"></i>
                                    <p>No hay comunicados publicados.</p>
                                    @if(auth()->check() && !auth()->user()->residente_id)
                                    <a href="{{ route('comunicados.create') }}" class="btn btn-primary btn-sm">Crear comunicado</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($comunicados->hasPages())
        <div class="card-body border-top py-2">
            {{ $comunicados->links() }}
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
            title: '¿Eliminar comunicado?',
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
