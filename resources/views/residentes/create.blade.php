@extends('plantilla')
@section('title', 'Nuevo Residente')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-building-user me-2" style="color:#34d399;"></i> Registrar Residente</h2>
        <a href="{{ route('residentes.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header"><i class="fas fa-user-plus me-2"></i> Datos del residente</div>
                <div class="card-body p-4">
                    <form action="{{ route('residentes.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre') }}" placeholder="Juan" required>
                                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido</label>
                                <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                                       value="{{ old('apellido') }}" placeholder="Pérez" required>
                                @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cédula de identidad (CI)</label>
                                <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror"
                                       value="{{ old('ci') }}" placeholder="12345678" required>
                                @error('ci')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Correo electrónico</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="juan@ejemplo.com" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control"
                                       value="{{ old('telefono') }}" placeholder="+591 7xxxxxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo de residente</label>
                                <select name="tipo_residente" class="form-select @error('tipo_residente') is-invalid @enderror" required>
                                    <option value="">— Seleccionar —</option>
                                    <option value="propietario" {{ old('tipo_residente') == 'propietario' ? 'selected' : '' }}>Propietario</option>
                                    <option value="inquilino"   {{ old('tipo_residente') == 'inquilino'   ? 'selected' : '' }}>Inquilino</option>
                                </select>
                                @error('tipo_residente')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Guardar residente
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
