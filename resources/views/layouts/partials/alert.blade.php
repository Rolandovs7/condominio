{{-- ── Alertas de sesión con SweetAlert2 ── --}}
@if (session('success'))
<script>
Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:3000, timerProgressBar:true })
    .fire({ icon:'success', title: @json(session('success')) });
</script>
@endif

@if (session('error'))
<script>
Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:4000, timerProgressBar:true })
    .fire({ icon:'error', title: @json(session('error')) });
</script>
@endif

@if (session('warning'))
<script>
Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:4000, timerProgressBar:true })
    .fire({ icon:'warning', title: @json(session('warning')) });
</script>
@endif

@if (session('info'))
<script>
Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:3000, timerProgressBar:true })
    .fire({ icon:'info', title: @json(session('info')) });
</script>
@endif

@if ($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Errores de validación',
    html: `<ul class="text-start">{!! implode('', array_map(fn($e) => "<li>$e</li>", $errors->all())) !!}</ul>`,
    confirmButtonColor: '#2563eb',
});
</script>
@endif
