

<?php $__env->startSection('title', 'Create Post'); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('admin.posts.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('admin.posts.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/admin/posts/create.blade.php ENDPATH**/ ?>