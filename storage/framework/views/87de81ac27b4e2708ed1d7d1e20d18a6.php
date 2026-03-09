

<?php
    $typeLabel = ucfirst(str_replace('_', ' ', $type ?? 'Post'));
    if (isset($category)) {
        $title = $category->name . ' - ' . $typeLabel;
    } elseif (isset($state)) {
        $title = $state->name . ' - ' . $typeLabel;
    } else {
        $title = $typeLabel;
    }
?>

<?php $__env->startSection('title', $title . ' - Government Job Portal'); ?>
<?php $__env->startSection('description', 'Browse all ' . strtolower($title) . ' on Government Job Portal'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .modern-list-item {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #e9ecef;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-bottom: 8px;
        }
        .modern-list-item:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        .modern-list-item a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            line-height: 1.5;
            display: block;
            margin-bottom: 4px;
        }
        .modern-list-item a:hover {
            color: #0052a3;
            text-decoration: underline;
        }
        .modern-list-item-date {
            font-size: 11px;
            color: #999;
        }
    </style>

    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2"><?php echo e($title); ?></h1>
        <p class="text-gray-600 text-sm"><i class="fas fa-list"></i> Showing <?php echo e($posts->count()); ?> posts</p>
    </div>

    <!-- Share Buttons -->
    <?php if (isset($component)) { $__componentOriginale74326542b72aa0b690ae5e4be9fcbaf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale74326542b72aa0b690ae5e4be9fcbaf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.share-buttons','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('share-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale74326542b72aa0b690ae5e4be9fcbaf)): ?>
<?php $attributes = $__attributesOriginale74326542b72aa0b690ae5e4be9fcbaf; ?>
<?php unset($__attributesOriginale74326542b72aa0b690ae5e4be9fcbaf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale74326542b72aa0b690ae5e4be9fcbaf)): ?>
<?php $component = $__componentOriginale74326542b72aa0b690ae5e4be9fcbaf; ?>
<?php unset($__componentOriginale74326542b72aa0b690ae5e4be9fcbaf); ?>
<?php endif; ?>

    <?php if($posts->count() > 0): ?>
        <div class="space-y-0 mb-8">
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="modern-list-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-list-item-date"><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-8 text-sm">
            <?php if($posts->onFirstPage()): ?>
                <span class="text-gray-400"><i class="fas fa-chevron-left"></i> Previous</span>
            <?php else: ?>
                <a href="<?php echo e($posts->previousPageUrl()); ?>" class="text-blue-600 hover:text-blue-800 transition"><i class="fas fa-chevron-left"></i> Previous</a>
            <?php endif; ?>

            <div class="text-gray-600">
                Page <?php echo e($posts->currentPage()); ?>

            </div>

            <?php if($posts->hasMorePages()): ?>
                <a href="<?php echo e($posts->nextPageUrl()); ?>" class="text-blue-600 hover:text-blue-800 transition">Next <i class="fas fa-chevron-right"></i></a>
            <?php else: ?>
                <span class="text-gray-400">Next <i class="fas fa-chevron-right"></i></span>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border border-gray-200 p-12 text-center">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-base font-medium">No posts found</p>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/posts/index.blade.php ENDPATH**/ ?>