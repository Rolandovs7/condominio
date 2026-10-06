
<?php if(session('success')): ?>
<script>
Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:3000, timerProgressBar:true })
    .fire({ icon:'success', title: <?php echo json_encode(session('success'), 15, 512) ?> });
</script>
<?php endif; ?>

<?php if(session('error')): ?>
<script>
Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:4000, timerProgressBar:true })
    .fire({ icon:'error', title: <?php echo json_encode(session('error'), 15, 512) ?> });
</script>
<?php endif; ?>

<?php if(session('warning')): ?>
<script>
Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:4000, timerProgressBar:true })
    .fire({ icon:'warning', title: <?php echo json_encode(session('warning'), 15, 512) ?> });
</script>
<?php endif; ?>

<?php if(session('info')): ?>
<script>
Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:3000, timerProgressBar:true })
    .fire({ icon:'info', title: <?php echo json_encode(session('info'), 15, 512) ?> });
</script>
<?php endif; ?>

<?php if($errors->any()): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Errores de validación',
    html: `<ul class="text-start"><?php echo implode('', array_map(fn($e) => "<li>$e</li>", $errors->all())); ?></ul>`,
    confirmButtonColor: '#2563eb',
});
</script>
<?php endif; ?>
<?php /**PATH /home/rolando/Escritorio/condominio/resources/views/layouts/partials/alert.blade.php ENDPATH**/ ?>