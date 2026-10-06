@extends('plantilla')
@section('title', 'Ver Notificación')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-bell me-2" style="color:#fbbf24;"></i> Notificación</h2>
        <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span><i class="fas fa-envelope-open me-2"></i> Detalle</span>
                    @php $colors = ['Urgente' => '#f87171', 'Informativa' => '#38bdf8', 'Recordatorio' => '#fbbf24']; $tc = $colors[$notificacion->tipo] ?? '#94a3b8'; @endphp
                    <span class="badge" style="background:{{ $tc }}22;color:{{ $tc }};border:1px solid {{ $tc }}44;">
                        {{ $notificacion->tipo }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <h3 style="color:#f1f5f9;font-weight:700;font-size:1.3rem;margin-bottom:1rem;">
                        {{ $notificacion->titulo }}
                    </h3>

                    <div style="background:rgba(255,255,255,.04);border-radius:10px;padding:1.25rem;margin-bottom:1.5rem;border:1px solid rgba(255,255,255,.07);">
                        <p style="color:#cbd5e1;line-height:1.7;margin:0;">{{ $notificacion->contenido }}</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Destinatario</div>
                            <div style="color:#e2e8f0;font-weight:600;margin-top:.3rem;">
                                @if($notificacion->residente)
                                    <i class="fas fa-user me-1" style="color:#38bdf8;"></i>
                                    {{ $notificacion->residente->nombre_completo }}
                                @else
                                    <i class="fas fa-users me-1" style="color:#34d399;"></i> Todos los residentes
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Fecha</div>
                            <div style="color:#e2e8f0;font-weight:600;margin-top:.3rem;">
                                <i class="fas fa-clock me-1" style="color:#64748b;"></i>
                                {{ $notificacion->fecha_hora ? \Carbon\Carbon::parse($notificacion->fecha_hora)->format('d/m/Y H:i') : '—' }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Estado</div>
                            <div style="margin-top:.3rem;">
                                @if($notificacion->leida)
                                    <span class="badge badge-pagado"><i class="fas fa-check me-1"></i>Leída</span>
                                @else
                                    <span class="badge badge-pendiente"><i class="fas fa-clock me-1"></i>Pendiente</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(!$notificacion->leida)
                    <div class="mt-4 pt-3" style="border-top:1px solid rgba(255,255,255,.07);">
                        <form action="{{ route('notificaciones.marcar-leida', $notificacion->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check me-1"></i> Marcar como leída
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
