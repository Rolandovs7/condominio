@extends('plantilla')
@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-user-circle me-2" style="color:#60a5fa;"></i> Mi Perfil</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header"><i class="fas fa-id-card me-2"></i> Información de cuenta</div>
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-4 mb-4 pb-3" style="border-bottom:1px solid rgba(255,255,255,.07);">
                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                             style="width:72px;height:72px;font-size:1.8rem;background:linear-gradient(135deg,#1d4ed8,#2563eb);flex-shrink:0;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 style="color:#f1f5f9;font-weight:700;margin-bottom:.3rem;">{{ $user->name }}</h4>
                            <div style="color:#64748b;font-size:.85rem;">{{ $user->email }}</div>
                            <div class="d-flex gap-1 flex-wrap mt-2">
                                @foreach($user->roles as $role)
                                <span class="badge" style="background:rgba(37,99,235,.15);color:#60a5fa;border:1px solid rgba(37,99,235,.3);font-size:.7rem;">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">ID de usuario</div>
                            <div style="color:#e2e8f0;font-weight:600;margin-top:.3rem;">#{{ $user->id }}</div>
                        </div>
                        <div class="col-6">
                            <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Miembro desde</div>
                            <div style="color:#e2e8f0;font-weight:600;margin-top:.3rem;">{{ $user->created_at->format('d/m/Y') }}</div>
                        </div>
                        @if($user->residente)
                        <div class="col-6">
                            <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Perfil residente</div>
                            <div style="color:#34d399;font-weight:600;margin-top:.3rem;">{{ $user->residente->nombre_completo }}</div>
                        </div>
                        @endif
                        @if($user->empleado)
                        <div class="col-6">
                            <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Perfil empleado</div>
                            <div style="color:#fbbf24;font-weight:600;margin-top:.3rem;">{{ $user->empleado->nombre }} {{ $user->empleado->apellido }}</div>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
