@extends('plantilla')
@section('title', 'Informe Administrativo')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <h2><i class="fas fa-file-alt me-2" style="color:#a78bfa;"></i> Informe Administrativo</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-secondary btn-sm" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Imprimir
            </button>
        </div>
    </div>

    {{-- Formulario de filtros --}}
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-filter me-2"></i> Parámetros del informe</div>
        <div class="card-body">
            <form method="GET" action="{{ route('informes.administrativo') }}" id="informeForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Tipo de informe</label>
                        <select name="tipo" class="form-select" onchange="document.getElementById('informeForm').submit()">
                            <option value="residentes"     {{ request('tipo','residentes') == 'residentes'     ? 'selected' : '' }}>Residentes</option>
                            <option value="unidades"       {{ request('tipo') == 'unidades'       ? 'selected' : '' }}>Unidades habitacionales</option>
                            <option value="mantenimientos" {{ request('tipo') == 'mantenimientos' ? 'selected' : '' }}>Mantenimientos</option>
                            <option value="incidencias"    {{ request('tipo') == 'incidencias'    ? 'selected' : '' }}>Incidencias</option>
                        </select>
                    </div>
                    @if(in_array(request('tipo'), ['mantenimientos','incidencias']))
                    <div class="col-md-2">
                        <label class="form-label">Desde</label>
                        <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Hasta</label>
                        <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
                    </div>
                    @endif
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fas fa-chart-bar me-1"></i> Generar informe
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Resultado --}}
    <div class="card" id="informe-resultado">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-table me-2"></i> {{ $titulo }}</span>
            @if(isset($datos) && !$datos->isEmpty())
            <span class="badge" style="background:rgba(52,211,153,.12);color:#34d399;">
                {{ $datos->count() }} registros
            </span>
            @endif
        </div>
        <div class="card-body p-0">
            @if(!isset($datos) || $datos->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-file-alt d-block"></i>
                    <p>No se encontraron registros para los filtros seleccionados.</p>
                </div>
            @else
                <div class="table-responsive">
                    @if(request('tipo','residentes') === 'residentes')
                    <table class="table mb-0">
                        <thead>
                            <tr><th>#</th><th>Nombre</th><th>Apellido</th><th>CI</th><th>Email</th><th>Tipo</th></tr>
                        </thead>
                        <tbody>
                            @foreach($datos as $r)
                            <tr>
                                <td style="color:#64748b;font-size:.8rem;">{{ $loop->iteration }}</td>
                                <td style="font-weight:600;color:#e2e8f0;">{{ $r->nombre }}</td>
                                <td style="color:#cbd5e1;">{{ $r->apellido }}</td>
                                <td style="color:#94a3b8;font-size:.85rem;">{{ $r->ci }}</td>
                                <td style="color:#94a3b8;font-size:.82rem;">{{ $r->email }}</td>
                                <td><span class="badge" style="background:rgba(167,139,250,.12);color:#a78bfa;font-size:.7rem;">{{ ucfirst($r->tipo_residente) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @elseif(request('tipo') === 'unidades')
                    <table class="table mb-0">
                        <thead>
                            <tr><th>#</th><th>Código</th><th>Residente</th><th>Tipo ocupación</th><th>Estado</th><th>Personas</th><th>Vehículos</th></tr>
                        </thead>
                        <tbody>
                            @foreach($datos as $u)
                            <tr>
                                <td style="color:#64748b;font-size:.8rem;">{{ $loop->iteration }}</td>
                                <td><code style="color:#38bdf8;background:rgba(56,189,248,.1);padding:2px 7px;border-radius:4px;">{{ $u->codigo }}</code></td>
                                <td style="color:#cbd5e1;">{{ $u->residente ? $u->residente->nombre.' '.$u->residente->apellido : '—' }}</td>
                                <td style="color:#94a3b8;font-size:.85rem;">{{ $u->tipo_ocupacion }}</td>
                                <td><span class="badge badge-{{ $u->estado === 'ocupada' ? 'pagado' : 'pendiente' }}">{{ ucfirst($u->estado) }}</span></td>
                                <td style="text-align:center;color:#94a3b8;">{{ $u->personas_por_unidad }}</td>
                                <td style="text-align:center;color:#94a3b8;">{{ $u->vehiculos }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @elseif(request('tipo') === 'mantenimientos')
                    <table class="table mb-0">
                        <thead>
                            <tr><th>#</th><th>Descripción</th><th>Empresa</th><th>Monto (Bs)</th><th>Fecha</th><th>Estado</th></tr>
                        </thead>
                        <tbody>
                            @foreach($datos as $m)
                            <tr>
                                <td style="color:#64748b;font-size:.8rem;">{{ $loop->iteration }}</td>
                                <td style="font-weight:600;color:#e2e8f0;">{{ Str::limit($m->descripcion, 50) }}</td>
                                <td style="color:#94a3b8;font-size:.85rem;">{{ $m->empresa?->nombre ?? '—' }}</td>
                                <td><strong style="color:#38bdf8;">Bs {{ number_format($m->monto, 2) }}</strong></td>
                                <td style="color:#94a3b8;font-size:.82rem;">{{ \Carbon\Carbon::parse($m->fecha_hora)->format('d/m/Y') }}</td>
                                <td><span class="badge {{ $m->estado == 1 ? 'badge-activo' : 'badge-inactivo' }}">{{ $m->estado == 1 ? 'Activo' : 'Inactivo' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:rgba(255,255,255,.04);">
                                <td colspan="3" style="font-weight:700;color:#e2e8f0;padding:.7rem 1rem;">Total:</td>
                                <td style="font-weight:700;color:#34d399;padding:.7rem 1rem;">Bs {{ number_format($datos->sum('monto'), 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>

                    @elseif(request('tipo') === 'incidencias')
                    <table class="table mb-0">
                        <thead>
                            <tr><th>#</th><th>N° Seguimiento</th><th>Título</th><th>Residente</th><th>Prioridad</th><th>Estado</th><th>Fecha</th></tr>
                        </thead>
                        <tbody>
                            @foreach($datos as $inc)
                            <tr>
                                <td style="color:#64748b;font-size:.8rem;">{{ $loop->iteration }}</td>
                                <td><code style="color:#38bdf8;background:rgba(56,189,248,.1);padding:2px 7px;border-radius:4px;font-size:.8rem;">{{ $inc->numero_seguimiento }}</code></td>
                                <td style="font-weight:600;color:#e2e8f0;">{{ Str::limit($inc->titulo, 40) }}</td>
                                <td style="color:#94a3b8;font-size:.82rem;">{{ $inc->residente->nombre }} {{ $inc->residente->apellido }}</td>
                                <td>
                                    @php $pc = ['baja'=>'#38bdf8','media'=>'#fbbf24','alta'=>'#f87171']; $c = $pc[$inc->prioridad] ?? '#94a3b8'; @endphp
                                    <span class="badge" style="background:{{ $c }}22;color:{{ $c }};border:1px solid {{ $c }}44;font-size:.7rem;">{{ ucfirst($inc->prioridad) }}</span>
                                </td>
                                <td><span class="badge badge-{{ ['pendiente'=>'pendiente','en_revision'=>'en_curso','resuelto'=>'pagado','cerrado'=>'finalizada'][$inc->estado] ?? 'pendiente' }}">{{ ucfirst(str_replace('_',' ',$inc->estado)) }}</span></td>
                                <td style="color:#94a3b8;font-size:.8rem;">{{ $inc->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="card-body border-top" style="font-size:.8rem;color:#64748b;">
                    <i class="fas fa-info-circle me-1"></i> Total de registros: <strong style="color:#94a3b8;">{{ $datos->count() }}</strong>
                    · Generado el {{ now()->format('d/m/Y H:i') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
