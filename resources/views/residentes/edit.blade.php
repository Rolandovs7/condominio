@extends('plantilla')
@section('title', 'Editar Residente')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-building-user me-2" style="color:#fbbf24;"></i> Editar Residente</h2>
        <a href="{{ route('residentes.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header"><i class="fas fa-pen me-2"></i> Datos del residente</div>
                <div class="card-body p-4">
                    <form action="{{ route('residentes.update', $residente->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $residente->nombre) }}" required>
                                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido</label>
                                <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                                       value="{{ old('apellido', $residente->apellido) }}" required>
                                @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CI</label>
                                <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror"
                                       value="{{ old('ci', $residente->ci) }}" required>
                                @error('ci')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $residente->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control"
                                       value="{{ old('telefono', $residente->telefono) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo de residente</label>
                                <select name="tipo_residente" class="form-select" required>
                                    <option value="propietario" {{ old('tipo_residente', $residente->tipo_residente) == 'propietario' ? 'selected' : '' }}>Propietario</option>
                                    <option value="inquilino"   {{ old('tipo_residente', $residente->tipo_residente) == 'inquilino'   ? 'selected' : '' }}>Inquilino</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i> Actualizar
                            </button>
                            <a href="{{ route('residentes.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
