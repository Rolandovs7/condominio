@extends('plantilla')
@section('title', 'Enviar Notificación')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-paper-plane me-2" style="color:#fbbf24;"></i> Enviar Notificación</h2>
        <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card">
                <div class="card-header"><i class="fas fa-bell me-2"></i> Redactar notificación</div>
                <div class="card-body p-4">
                    <form action="{{ route('notificaciones.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Título <span style="color:#f87171;">*</span></label>
                                <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                                       value="{{ old('titulo') }}" placeholder="Asunto de la notificación" required>
                                @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tipo <span style="color:#f87171;">*</span></label>
                                <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                    <option value="Informativa"  {{ old('tipo','Informativa') == 'Informativa'  ? 'selected' : '' }}>Informativa</option>
                                    <option value="Urgente"      {{ old('tipo') == 'Urgente'      ? 'selected' : '' }}>🚨 Urgente</option>
                                    <option value="Recordatorio" {{ old('tipo') == 'Recordatorio' ? 'selected' : '' }}>⏰ Recordatorio</option>
                                </select>
                                @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Contenido <span style="color:#f87171;">*</span></label>
                                <textarea name="contenido" rows="5"
                                          class="form-control @error('contenido') is-invalid @enderror"
                                          placeholder="Escribe el mensaje de la notificación..." required>{{ old('contenido') }}</textarea>
                                @error('contenido')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Destinatario <span style="color:#f87171;">*</span></label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label style="cursor:pointer;display:block;">
                                            <input type="radio" name="destinatario" value="todos"
                                                   id="dest_todos" onchange="toggleResidente()"
                                                   {{ old('destinatario', 'todos') === 'todos' ? 'checked' : '' }}
                                                   style="display:none;" class="dest-radio">
                                            <div class="dest-card p-3 text-center rounded-3"
                                                 style="border:2px solid rgba(255,255,255,.1);background:rgba(52,211,153,.06);transition:all .2s;">
                                                <i class="fas fa-users mb-2" style="font-size:1.5rem;color:#34d399;display:block;"></i>
                                                <div style="font-size:.85rem;font-weight:600;color:#cbd5e1;">Todos los residentes</div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label style="cursor:pointer;display:block;">
                                            <input type="radio" name="destinatario" value="individual"
                                                   id="dest_individual" onchange="toggleResidente()"
                                                   {{ old('destinatario') === 'individual' ? 'checked' : '' }}
                                                   style="display:none;" class="dest-radio">
                                            <div class="dest-card p-3 text-center rounded-3"
                                                 style="border:2px solid rgba(255,255,255,.1);background:rgba(56,189,248,.06);transition:all .2s;">
                                                <i class="fas fa-user mb-2" style="font-size:1.5rem;color:#38bdf8;display:block;"></i>
                                                <div style="font-size:.85rem;font-weight:600;color:#cbd5e1;">Residente específico</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12" id="residenteContainer" style="display:none;">
                                <label class="form-label">Seleccionar residente</label>
                                <select name="residente_id" class="form-select @error('residente_id') is-invalid @enderror">
                                    <option value="">— Seleccionar —</option>
                                    @foreach($residentes as $r)
                                    <option value="{{ $r->id }}" {{ old('residente_id') == $r->id ? 'selected' : '' }}>
                                        {{ $r->nombre_completo }} ({{ $r->ci }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('residente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Enviar notificación
                            </button>
                            <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.dest-card:hover { border-color:rgba(255,255,255,.25)!important; }
.dest-card.selected { border-color:#2563eb!important; box-shadow:0 0 0 3px rgba(37,99,235,.2); }
</style>
@endpush

@push('js')
<script>
function toggleResidente() {
    const individual = document.getElementById('dest_individual').checked;
    document.getElementById('residenteContainer').style.display = individual ? 'block' : 'none';
}

// Estilo visual en tarjetas de destinatario
document.querySelectorAll('.dest-radio').forEach(radio => {
    radio.closest('label').addEventListener('click', function() {
        document.querySelectorAll('.dest-card').forEach(c => c.classList.remove('selected'));
        this.querySelector('.dest-card').classList.add('selected');
    });
});

// Marcar la seleccionada al cargar
document.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('.dest-radio:checked');
    if (checked) {
        checked.closest('label').querySelector('.dest-card').classList.add('selected');
    }
    toggleResidente();
});
</script>
@endpush
