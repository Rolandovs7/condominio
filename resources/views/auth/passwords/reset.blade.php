<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva contraseña — Condominio San Diego</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        * { box-sizing: border-box; }
        body { margin:0; min-height:100vh; background:linear-gradient(135deg,#060d1c 0%,#0b1120 60%,#0d1a2e 100%); display:flex; align-items:center; justify-content:center; padding:2rem; font-family:'Segoe UI',system-ui,sans-serif; }
        .card { background:rgba(17,24,39,.95); border:1px solid rgba(255,255,255,.1); border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,.5); width:100%; max-width:440px; padding:2.5rem 2rem; }
        .form-control { background:#1e293b; border:1px solid #334155; border-radius:10px; color:#e2e8f0; padding:.65rem 1rem; }
        .form-control:focus { background:#1e293b; border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.2); color:#e2e8f0; }
        .btn-primary { background:linear-gradient(135deg,#1d4ed8,#2563eb); border:none; border-radius:10px; font-weight:700; padding:.75rem; width:100%; }
        .form-label { font-size:.78rem; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em; }
        .invalid-feedback { font-size:.78rem; color:#f87171; }
        h2 { color:#f1f5f9; font-size:1.2rem; font-weight:700; }
        a { color:#38bdf8; text-decoration:none; font-size:.82rem; }
    </style>
</head>
<body>
<div class="card">
    <div class="text-center mb-4">
        <div style="font-size:2rem;margin-bottom:.5rem;">🔒</div>
        <h2>Nueva contraseña</h2>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ $email ?? old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="new-password">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-lock me-2"></i> Restablecer contraseña
        </button>
    </form>
    <div class="text-center mt-3">
        <a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i>Volver al inicio de sesión</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
