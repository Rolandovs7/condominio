<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Iniciar Sesión — Condominio San Diego</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/plantilla.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #060d1c 0%, #0b1120 50%, #0d1a2e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 1.5rem;
        }
        .login-card {
            background: rgba(17,24,39,.95);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.5);
            padding: 2.5rem 2rem;
            backdrop-filter: blur(20px);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 1.8rem;
        }
        .login-logo .icon-wrap {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: .75rem;
            box-shadow: 0 8px 24px rgba(37,99,235,.4);
        }
        .login-logo h1 { font-size: 1.25rem; font-weight: 700; color: #f1f5f9; margin: 0; }
        .login-logo p  { font-size: .82rem; color: #64748b; margin: .25rem 0 0; }

        .form-label { font-size: .78rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .4rem; }
        .form-control {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 10px;
            color: #e2e8f0;
            padding: .65rem 1rem;
            font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            background: #1e293b;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.2);
            color: #e2e8f0;
        }
        .form-control::placeholder { color: #475569; }
        .input-group-text {
            background: #1e293b;
            border: 1px solid #334155;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #64748b;
        }
        .input-group .form-control { border-left: none; border-radius: 0 10px 10px 0; }
        .input-group:focus-within .input-group-text { border-color: #2563eb; }

        .btn-login {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: .95rem;
            font-weight: 700;
            padding: .75rem;
            width: 100%;
            transition: all .2s;
            box-shadow: 0 4px 16px rgba(37,99,235,.35);
            cursor: pointer;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37,99,235,.45);
        }
        .btn-login:active { transform: translateY(0); }

        .forgot-link { font-size: .82rem; color: #64748b; text-decoration: none; transition: color .2s; }
        .forgot-link:hover { color: #38bdf8; }

        .alert-danger {
            background: rgba(220,38,38,.12);
            border: 1px solid rgba(220,38,38,.3);
            border-radius: 10px;
            color: #f87171;
            font-size: .85rem;
            padding: .65rem 1rem;
        }

        .pw-toggle {
            background: #1e293b;
            border: 1px solid #334155;
            border-left: none;
            border-radius: 0 10px 10px 0;
            color: #64748b;
            cursor: pointer;
            padding: 0 .75rem;
            transition: color .2s;
        }
        .pw-toggle:hover { color: #94a3b8; }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">

        <div class="login-logo">
            <div class="icon-wrap">🏢</div>
            <h1>Condominio San Diego</h1>
            <p>Sistema de Gestión — Acceso al panel</p>
        </div>

        @if ($errors->any())
            <div class="alert-danger mb-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        @if (session('status'))
            <div class="alert-danger mb-3" style="background:rgba(5,150,105,.12);border-color:rgba(5,150,105,.3);color:#34d399;">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            </div>
        @endif

        <form action="/login" method="POST" id="loginForm" autocomplete="on">
            @csrf

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-envelope me-1"></i> Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope fa-sm"></i></span>
                    <input type="email" name="email" class="form-control"
                           placeholder="correo@ejemplo.com"
                           value="{{ old('email') }}"
                           autocomplete="email" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label"><i class="fas fa-lock me-1"></i> Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock fa-sm"></i></span>
                    <input type="password" name="password" id="passwordField" class="form-control"
                           placeholder="••••••••" autocomplete="current-password" required>
                    <button type="button" class="pw-toggle" onclick="togglePw()" title="Ver/ocultar">
                        <i class="fas fa-eye fa-sm" id="pwIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                <i class="fas fa-sign-in-alt me-2"></i> Iniciar sesión
            </button>

            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="forgot-link">
                    <i class="fas fa-key me-1"></i> ¿Olvidaste tu contraseña?
                </a>
            </div>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePw() {
    const f = document.getElementById('passwordField');
    const i = document.getElementById('pwIcon');
    if (f.type === 'password') { f.type = 'text'; i.className = 'fas fa-eye-slash fa-sm'; }
    else { f.type = 'password'; i.className = 'fas fa-eye fa-sm'; }
}
document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnLogin');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Verificando...';
});
</script>
</body>
</html>
