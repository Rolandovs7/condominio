<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema de Gestión de Condominio San Diego" />
        <meta name="author" content="Grupo 3" />
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
        <title>Condominio San Diego — <?php echo $__env->yieldContent('title', 'Panel'); ?></title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo e(asset('css/plantilla.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php echo $__env->yieldPushContent('css'); ?>
    </head>
    <body class="sb-nav-fixed">
        <?php if (isset($component)) { $__componentOriginalef9c1f2dc7912674f7826089c0a953dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalef9c1f2dc7912674f7826089c0a953dc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation-header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalef9c1f2dc7912674f7826089c0a953dc)): ?>
<?php $attributes = $__attributesOriginalef9c1f2dc7912674f7826089c0a953dc; ?>
<?php unset($__attributesOriginalef9c1f2dc7912674f7826089c0a953dc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalef9c1f2dc7912674f7826089c0a953dc)): ?>
<?php $component = $__componentOriginalef9c1f2dc7912674f7826089c0a953dc; ?>
<?php unset($__componentOriginalef9c1f2dc7912674f7826089c0a953dc); ?>
<?php endif; ?>
        <div id="layoutSidenav">
            <?php if (isset($component)) { $__componentOriginal8f4b0c7aa39bbb03a7f48d2d78460146 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f4b0c7aa39bbb03a7f48d2d78460146 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f4b0c7aa39bbb03a7f48d2d78460146)): ?>
<?php $attributes = $__attributesOriginal8f4b0c7aa39bbb03a7f48d2d78460146; ?>
<?php unset($__attributesOriginal8f4b0c7aa39bbb03a7f48d2d78460146); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f4b0c7aa39bbb03a7f48d2d78460146)): ?>
<?php $component = $__componentOriginal8f4b0c7aa39bbb03a7f48d2d78460146; ?>
<?php unset($__componentOriginal8f4b0c7aa39bbb03a7f48d2d78460146); ?>
<?php endif; ?>
            <div id="layoutSidenav_content">
                <main>
                    
                    <?php echo $__env->make('layouts.partials.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </main>
                <?php if (isset($component)) { $__componentOriginal8a8716efb3c62a45938aca52e78e0322 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a8716efb3c62a45938aca52e78e0322 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $attributes = $__attributesOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $component = $__componentOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__componentOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo e(asset('js/scripts.js')); ?>"></script>
        <?php echo $__env->yieldPushContent('js'); ?>

        
        <script>
        window.addEventListener('beforeunload', () => {
            navigator.sendBeacon('<?php echo e(route("bitacora.page-close")); ?>',
                new URLSearchParams({ _token: '<?php echo e(csrf_token()); ?>' }));
        });
        </script>
    </body>
</html>
<?php /**PATH /home/rolando/Escritorio/condominio/resources/views/plantilla.blade.php ENDPATH**/ ?>