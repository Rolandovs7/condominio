@extends('plantilla')
@section('title', 'Detalle de Visita')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-door-open me-2" style="color:#fb923c;"></i> Detalle de Visita</h2>
        <div class="d-flex gap-2">
            @can('operar porteria')
            <a href="{{ route('visitas.panel-guardia') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-shield-alt me-1"></i> Panel guardia
            </a>
            @endcan
            <a href="{{ route('visitas.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="row g-3">

        {{-- Tarjeta principal --}}
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-id-card me-1"></i>
                        <code style="color:#38bdf8;background:rgba(56,189,248,.1);padding:2px 10px;border-radius:6px;font-size:.9rem;letter-spacing:.06em;">
                            {{ $visita->codigo }}
                        </code>
                    </div>
                    @php $badges = ['pendiente'=>'pendiente','en_curso'=>'en_curso','finalizada'=>'finalizada','rechazada'=>'vencido']; @endphp
                    <span class="badge badge-{{ $badges[$visita->estado] ?? 'pendiente' }} fs-small">
                        {{ ucfirst(str_replace('_',' ',$visita->estado)) }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- Visitante --}}
                        <div class="col-md-6 p-4" style="border-right:1px solid rgba(255,255,255,.06);">
                            <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:1rem;">
                                <i class="fas fa-user me-1"></i> Datos del visitante
                            </div>
                            @php
                                $rows = [
                                    ['Nombre',   $visita->nombre_visitante, 'fa-user'],
                                    ['CI',        $visita->ci_visitante, 'fa-id-badge'],
                                    ['Motivo',    $visita->motivo, 'fa-comment'],
                                    ['Vehículo',  $visita->placa_vehiculo ?? 'Sin vehículo', 'fa-car'],
                                ];
                            @endphp
                            @foreach($rows as [$label, $value, $icon])
                            <div class="mb-3">
                                <div style="font-size:.72rem;color:#475569;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">{{ $label }}</div>
                                <div style="color:#e2e8f0;font-weight:600;margin-top:.2rem;">
                                    <i class="fas {{ $icon }} me-1" style="color:#64748b;font-size:.75rem;"></i>{{ $value }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Visita --}}
                        <div class="col-md-6 p-4">
                            <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:1rem;">
                                <i class="fas fa-calendar-alt me-1"></i> Datos de la visita
                            </div>
                            <div class="mb-3">
                                <div style="font-size:.72rem;color:#475569;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">Residente</div>
                                <div style="color:#e2e8f0;font-weight:600;margin-top:.2rem;">
                                    <i class="fas fa-home me-1" style="color:#64748b;font-size:.75rem;"></i>
                                    {{ $visita->residente ? $visita->residente->nombre_completo : 'Sin asignar' }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <div style="font-size:.72rem;color:#475569;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">Inicio programado</div>
                                <div style="color:#e2e8f0;font-weight:600;margin-top:.2rem;">
                                    <i class="fas fa-clock me-1" style="color:#64748b;font-size:.75rem;"></i>
                                    {{ \Carbon\Carbon::parse($visita->fecha_inicio)->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <div style="font-size:.72rem;color:#475569;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">Fin programado</div>
                                <div style="color:#e2e8f0;font-weight:600;margin-top:.2rem;">
                                    <i class="fas fa-clock me-1" style="color:#64748b;font-size:.75rem;"></i>
                                    {{ \Carbon\Carbon::parse($visita->fecha_fin)->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div>
                                <div style="font-size:.72rem;color:#475569;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">Creado</div>
                                <div style="color:#94a3b8;font-size:.82rem;margin-top:.2rem;">
                                    {{ $visita->created_at->format('d/m/Y H:i:s') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Historial entrada/salida --}}
                    @if($visita->hora_entrada || $visita->hora_salida)
                    <div style="border-top:1px solid rgba(255,255,255,.06);padding:1.25rem;">
                        <div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:.75rem;">
                            <i class="fas fa-history me-1"></i> Historial de acceso
                        </div>
                        <div class="row g-3">
                            @if($visita->hora_entrada)
                            <div class="col-md-6">
                                <div style="background:rgba(52,211,153,.08);border:1px solid rgba(52,211,153,.2);border-radius:10px;padding:1rem;">
                                    <div style="font-size:.78rem;font-weight:700;color:#34d399;margin-bottom:.5rem;">
                                        <i class="fas fa-sign-in-alt me-1"></i> Entrada
                                    </div>
                                    <div style="color:#e2e8f0;font-size:.85rem;">{{ \Carbon\Carbon::parse($visita->hora_entrada)->format('d/m/Y H:i:s') }}</div>
                                    @if($visita->userEntrada)
                                    <div style="font-size:.75rem;color:#64748b;margin-top:.3rem;">Por: {{ $visita->userEntrada->name }}</div>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @if($visita->hora_salida)
                            <div class="col-md-6">
                                <div style="background:rgba(56,189,248,.08);border:1px solid rgba(56,189,248,.2);border-radius:10px;padding:1rem;">
                                    <div style="font-size:.78rem;font-weight:700;color:#38bdf8;margin-bottom:.5rem;">
                                        <i class="fas fa-sign-out-alt me-1"></i> Salida
                                    </div>
                                    <div style="color:#e2e8f0;font-size:.85rem;">{{ \Carbon\Carbon::parse($visita->hora_salida)->format('d/m/Y H:i:s') }}</div>
                                    @if($visita->userSalida)
                                    <div style="font-size:.75rem;color:#64748b;margin-top:.3rem;">Por: {{ $visita->userSalida->name }}</div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        @if($visita->observaciones)
                        <div style="margin-top:.75rem;padding:.75rem;background:rgba(251,191,36,.06);border:1px solid rgba(251,191,36,.2);border-radius:8px;">
                            <div style="font-size:.75rem;font-weight:700;color:#fbbf24;margin-bottom:.3rem;"><i class="fas fa-sticky-note me-1"></i> Observaciones</div>
                            <div style="color:#cbd5e1;font-size:.85rem;">{{ $visita->observaciones }}</div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Panel de acciones --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><i class="fas fa-cogs me-2"></i> Acciones disponibles</div>
                <div class="card-body d-flex flex-column gap-2">

                    {{-- Registrar entrada --}}
                    @if($visita->estado === 'pendiente')
                        @can('operar porteria')
                        <form action="{{ route('visitas.entrada', $visita) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-sign-in-alt me-2"></i> Registrar entrada
                            </button>
                        </form>
                        @endcan
                        @canany(['gestionar visitas','administrar visitas'])
                        <a href="{{ route('visitas.edit', $visita) }}" class="btn btn-warning w-100">
                            <i class="fas fa-pen me-2"></i> Editar visita
                        </a>
                        @endcanany
                    @endif

                    {{-- Registrar salida --}}
                    @if($visita->estado === 'en_curso')
                        @can('operar porteria')
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#salidaModal">
                            <i class="fas fa-sign-out-alt me-2"></i> Registrar salida
                        </button>
                        @endcan
                    @endif

                    {{-- Imprimir --}}
                    <button class="btn btn-secondary w-100" onclick="window.print()">
                        <i class="fas fa-print me-2"></i> Imprimir
                    </button>

                    {{-- Info contextual --}}
                    @can('gestionar visitas')
                        @if($visita->estado === 'pendiente' && $visita->residente_id == auth()->user()->residente_id)
                        <div class="mt-2" style="background:rgba(56,189,248,.08);border:1px solid rgba(56,189,248,.2);border-radius:10px;padding:1rem;">
                            <div style="font-size:.78rem;font-weight:700;color:#38bdf8;margin-bottom:.4rem;">
                                <i class="fas fa-info-circle me-1"></i> Tu visita
                            </div>
                            <div style="font-size:.8rem;color:#94a3b8;">
                                Comparte el código <strong style="color:#38bdf8;">{{ $visita->codigo }}</strong> con tu visitante.
                            </div>
                        </div>
                        @endif
                    @endcan

                    @can('operar porteria')
                        @if($visita->estado === 'pendiente')
                        <div class="mt-2" style="background:rgba(251,191,36,.06);border:1px solid rgba(251,191,36,.2);border-radius:10px;padding:.85rem;">
                            <div style="font-size:.78rem;color:#fbbf24;font-weight:600;">
                                <i class="fas fa-clock me-1"></i> El visitante puede llegar 30 min antes del horario.
                            </div>
                        </div>
                        @elseif($visita->estado === 'en_curso')
                        <div class="mt-2" style="background:rgba(52,211,153,.06);border:1px solid rgba(52,211,153,.2);border-radius:10px;padding:.85rem;">
                            <div style="font-size:.78rem;color:#34d399;font-weight:600;">
                                <i class="fas fa-user-clock me-1"></i> Visitante dentro del condominio.
                            </div>
                        </div>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Salida --}}
@if($visita->estado === 'en_curso')
@can('operar porteria')
<div class="modal fade" id="salidaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-sign-out-alt me-2"></i> Registrar Salida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
            </div>
            <form action="{{ route('visitas.salida', $visita) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div style="background:rgba(56,189,248,.08);border:1px solid rgba(56,189,248,.2);border-radius:10px;padding:1rem;margin-bottom:1rem;">
                        <div style="font-size:.82rem;color:#38bdf8;font-weight:600;">{{ $visita->nombre_visitante }}</div>
                        <div style="font-size:.78rem;color:#64748b;">CI: {{ $visita->ci_visitante }}</div>
                    </div>
                    <label class="form-label">Observaciones <span style="color:#475569;">(opcional)</span></label>
                    <textarea name="observaciones" class="form-control" rows="3"
                              placeholder="Ej: Salida normal, sin inconvenientes..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-out-alt me-1"></i> Confirmar salida
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endif
@endsection
