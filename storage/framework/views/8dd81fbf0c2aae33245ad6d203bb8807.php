

<?php $__env->startSection('title', $category->name . ' - Government Jobs'); ?>
<?php $__env->startSection('description', 'Latest government jobs in ' . $category->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">
            <i class="fas fa-folder"></i> <?php echo e($category->name); ?>

        </h1>
        <p class="text-gray-600 text-sm"><i class="fas fa-briefcase"></i> All posts in <?php echo e($category->name); ?> category (<?php echo e($posts->total()); ?> total)</p>
    </div>

    <?php
        // Separate posts by type
        $jobPosts = $posts->where('type', 'job');
        $resultPosts = $posts->where('type', 'result');
        $admitCardPosts = $posts->where('type', 'admit_card');
        $answerKeyPosts = $posts->where('type', 'answer_key');
        $syllabusPosts = $posts->where('type', 'syllabus');
        $blogPosts = $posts->where('type', 'blog');
    ?>

    <!-- Column Sections for Each Type -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Jobs Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-briefcase"></i> Jobs in <?php echo e($category->name); ?></span>
            </div>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $jobPosts->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginald203e834c3725bfcc8d3dae774849790 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald203e834c3725bfcc8d3dae774849790 = $attributes; } ?>
<?php $component = App\View\Components\PostCard::resolve(['post' => $post] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PostCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $attributes = $__attributesOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__attributesOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $component = $__componentOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__componentOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No jobs found</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Results Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-chart-bar"></i> Results in <?php echo e($category->name); ?></span>
            </div>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $resultPosts->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginald203e834c3725bfcc8d3dae774849790 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald203e834c3725bfcc8d3dae774849790 = $attributes; } ?>
<?php $component = App\View\Components\PostCard::resolve(['post' => $post] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PostCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $attributes = $__attributesOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__attributesOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $component = $__componentOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__componentOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No results found</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Admit Cards Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-id-card"></i> Admit Cards in <?php echo e($category->name); ?></span>
            </div>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $admitCardPosts->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginald203e834c3725bfcc8d3dae774849790 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald203e834c3725bfcc8d3dae774849790 = $attributes; } ?>
<?php $component = App\View\Components\PostCard::resolve(['post' => $post] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PostCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $attributes = $__attributesOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__attributesOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $component = $__componentOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__componentOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No admit cards found</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Answer Keys Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-key"></i> Answer Keys in <?php echo e($category->name); ?></span>
            </div>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $answerKeyPosts->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginald203e834c3725bfcc8d3dae774849790 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald203e834c3725bfcc8d3dae774849790 = $attributes; } ?>
<?php $component = App\View\Components\PostCard::resolve(['post' => $post] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PostCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $attributes = $__attributesOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__attributesOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $component = $__componentOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__componentOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No answer keys found</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Syllabus Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-book"></i> Syllabus in <?php echo e($category->name); ?></span>
            </div>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $syllabusPosts->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginald203e834c3725bfcc8d3dae774849790 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald203e834c3725bfcc8d3dae774849790 = $attributes; } ?>
<?php $component = App\View\Components\PostCard::resolve(['post' => $post] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PostCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $attributes = $__attributesOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__attributesOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $component = $__componentOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__componentOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No syllabus found</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Blogs Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-pen-fancy"></i> Blogs in <?php echo e($category->name); ?></span>
            </div>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $blogPosts->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if (isset($component)) { $__componentOriginald203e834c3725bfcc8d3dae774849790 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald203e834c3725bfcc8d3dae774849790 = $attributes; } ?>
<?php $component = App\View\Components\PostCard::resolve(['post' => $post] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PostCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $attributes = $__attributesOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__attributesOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald203e834c3725bfcc8d3dae774849790)): ?>
<?php $component = $__componentOriginald203e834c3725bfcc8d3dae774849790; ?>
<?php unset($__componentOriginald203e834c3725bfcc8d3dae774849790); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No blogs found</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if($posts->hasPages()): ?>
    <div class="mt-8">
        <?php echo e($posts->links()); ?>

    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/categories/show.blade.php ENDPATH**/ ?>