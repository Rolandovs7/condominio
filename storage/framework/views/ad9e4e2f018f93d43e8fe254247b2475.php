<?php if($paginator->hasPages()): ?>
<nav class="d-flex align-items-center justify-content-between" aria-label="Paginación">
    <div style="font-size:.78rem;color:#64748b;">
        Mostrando <strong style="color:#94a3b8;"><?php echo e($paginator->firstItem()); ?></strong>
        — <strong style="color:#94a3b8;"><?php echo e($paginator->lastItem()); ?></strong>
        de <strong style="color:#94a3b8;"><?php echo e($paginator->total()); ?></strong> resultados
    </div>
    <ul class="pagination mb-0">
        
        <?php if($paginator->onFirstPage()): ?>
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true">&#8249;</span>
            </li>
        <?php else: ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" aria-label="Anterior">&#8249;</a>
            </li>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link"><?php echo e($element); ?></span>
                </li>
            <?php endif; ?>
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <li class="page-item active" aria-current="page">
                            <span class="page-link"><?php echo e($page); ?></span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" aria-label="Siguiente">&#8250;</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true">&#8250;</span>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>
<?php /**PATH /home/rolando/Escritorio/condominio/resources/views/vendor/pagination/bootstrap-5.blade.php ENDPATH**/ ?>