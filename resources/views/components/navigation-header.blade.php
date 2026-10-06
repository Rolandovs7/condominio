<nav class="sb-topnav navbar navbar-expand navbar-dark shadow-sm">

    <!-- Botón sidebar -->
    <button class="btn btn-link btn-sm ms-3 me-2 text-white" id="sidebarToggle" title="Menú">
        <i class="fas fa-bars fs-5"></i>
    </button>

    <!-- Logo -->
    <a class="navbar-brand fw-bold text-uppercase" href="{{ route('panel') }}" style="font-size:.92rem;letter-spacing:.04em;">
        🏢 Condominio San Diego
    </a>

    <!-- Notificaciones -->
    <ul class="navbar-nav ms-auto me-2 d-flex flex-row align-items-center gap-2">

        @auth
        {{-- Campana de notificaciones no leídas --}}
        @php
            $noLeidas = \App\Models\Notificacion::where('leida', false)
                ->when(auth()->user()->residente_id, fn($q) => $q->where('residente_id', auth()->user()->residente_id))
                ->count();
        @endphp
        <li class="nav-item dropdown me-1">
            <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown" title="Notificaciones">
                <i class="fas fa-bell fs-5" style="color:#fbbf24;"></i>
                @if($noLeidas > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                          style="font-size:.6rem;">{{ $noLeidas > 9 ? '9+' : $noLeidas }}</span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="min-width:280px;">
                <li><h6 class="dropdown-header" style="color:#94a3b8;">Notificaciones</h6></li>
                @php
                    $recientes = \App\Models\Notificacion::where('leida', false)
                        ->when(auth()->user()->residente_id, fn($q) => $q->where('residente_id', auth()->user()->residente_id))
                        ->latest('fecha_hora')->limit(5)->get();
                @endphp
                @forelse($recientes as $n)
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('notificaciones.show', $n) }}">
                            <div class="d-flex align-items-start gap-2">
                                <span class="mt-1" style="color:
                                    {{ $n->tipo === 'Urgente' ? '#f87171' : ($n->tipo === 'Recordatorio' ? '#fbbf24' : '#38bdf8') }};">
                                    <i class="fas fa-{{ $n->tipo === 'Urgente' ? 'exclamation-circle' : ($n->tipo === 'Recordatorio' ? 'clock' : 'info-circle') }} fa-sm"></i>
                                </span>
                                <div>
                                    <div style="font-size:.82rem;font-weight:600;color:#e2e8f0;">{{ Str::limit($n->titulo, 35) }}</div>
                                    <div style="font-size:.72rem;color:#64748b;">{{ $n->fecha_hora ? \Carbon\Carbon::parse($n->fecha_hora)->diffForHumans() : '' }}</div>
                                </div>
                            </div>
                        </a>
                    </li>
                @empty
                    <li><span class="dropdown-item text-muted" style="font-size:.82rem;">Sin notificaciones nuevas</span></li>
                @endforelse
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center" href="{{ route('notificaciones.index') }}" style="font-size:.82rem;color:#38bdf8;">Ver todas</a></li>
            </ul>
        </li>

        <!-- Usuario -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" id="navbarDropdown"
               href="#" role="button" data-bs-toggle="dropdown">
                <span class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold"
                      style="width:32px;height:32px;font-size:.8rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
                <span class="d-none d-md-inline fw-semibold" style="font-size:.875rem;">
                    {{ auth()->user()->name }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                <li class="px-3 py-2">
                    <div style="font-size:.82rem;font-weight:700;color:#e2e8f0;">{{ auth()->user()->name }}</div>
                    <div style="font-size:.73rem;color:#64748b;">{{ auth()->user()->email }}</div>
                    @if(auth()->user()->roles->isNotEmpty())
                        <span class="badge mt-1" style="background:rgba(56,189,248,.15);color:#38bdf8;font-size:.65rem;">
                            {{ auth()->user()->roles->pluck('name')->join(', ') }}
                        </span>
                    @endif
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('bitacora.index') }}">
                        <i class="fas fa-book me-2" style="color:#94a3b8;width:16px;"></i> Mi actividad
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" style="color:#f87171;">
                        <i class="fas fa-sign-out-alt me-2" style="width:16px;"></i> Cerrar sesión
                    </a>
                </li>
            </ul>
        </li>
        @endauth

    </ul>
</nav>
