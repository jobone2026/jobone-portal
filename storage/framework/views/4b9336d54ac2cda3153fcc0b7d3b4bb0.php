<nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($index < count($items) - 1): ?>
                <li>
                    <a href="<?php echo e($item['url']); ?>" class="text-blue-600 hover:text-blue-800">
                        <?php echo e($item['label']); ?>

                    </a>
                </li>
                <li class="text-gray-400">/</li>
            <?php else: ?>
                <li class="text-gray-600"><?php echo e($item['label']); ?></li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>
<?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>