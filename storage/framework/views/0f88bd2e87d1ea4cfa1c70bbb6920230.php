<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar contraseña — Condominio San Diego</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        * { box-sizing: border-box; }
        body { margin:0; min-height:100vh; background:linear-gradient(135deg,#060d1c 0%,#0b1120 60%,#0d1a2e 100%); display:flex; align-items:center; justify-content:center; padding:2rem; font-family:'Segoe UI',system-ui,sans-serif; }
        .card { background:rgba(17,24,39,.95); border:1px solid rgba(255,255,255,.1); border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,.5); width:100%; max-width:420px; padding:2.5rem 2rem; }
        .form-control { background:#1e293b; border:1px solid #334155; border-radius:10px; color:#e2e8f0; padding:.65rem 1rem; }
        .form-control:focus { background:#1e293b; border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.2); color:#e2e8f0; }
        .btn-primary { background:linear-gradient(135deg,#1d4ed8,#2563eb); border:none; border-radius:10px; font-weight:700; padding:.75rem; width:100%; }
        .form-label { font-size:.78rem; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em; }
        h2 { color:#f1f5f9; font-size:1.2rem; font-weight:700; }
        p.desc { color:#64748b; font-size:.85rem; }
        a { color:#38bdf8; text-decoration:none; font-size:.82rem; }
        a:hover { color:#7dd3fc; }
        .alert { border-radius:10px; font-size:.85rem; }
        .alert-success { background:rgba(5,150,105,.15); border-left:3px solid #059669; color:#34d399; }
        .alert-danger  { background:rgba(220,38,38,.15);  border-left:3px solid #dc2626; color:#f87171; }
    </style>
</head>
<body>
<div class="card">
    <div class="text-center mb-4">
        <div style="font-size:2rem;margin-bottom:.5rem;">🔑</div>
        <h2>Recuperar contraseña</h2>
        <p class="desc">Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>
    </div>

    <?php if(session('status')): ?>
    <div class="alert alert-success mb-3"><i class="fas fa-check-circle me-2"></i><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger mb-3">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><i class="fas fa-exclamation-triangle me-1"></i><?php echo e($error); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control"
                   value="<?php echo e(old('email')); ?>" placeholder="tu@correo.com" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane me-2"></i> Enviar enlace de recuperación
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="<?php echo e(route('login')); ?>"><i class="fas fa-arrow-left me-1"></i>Volver al inicio de sesión</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /home/rolando/Escritorio/condominio/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>