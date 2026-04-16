

<?php
    if ($type === 'all') {
        $typeLabel = 'All Posts';
    } else {
        $typeLabel = ucfirst(str_replace('_', ' ', $type ?? 'Post'));
    }
    
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
    <!-- Filter Bar -->
    <?php if (isset($component)) { $__componentOriginale9f22847d79d6273acb27aff60f1f678 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale9f22847d79d6273acb27aff60f1f678 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.filter-bar','data' => ['currentCategory' => $category ?? null,'currentState' => $state ?? null,'currentType' => $type ?? 'all','showTypeFilter' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filter-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['currentCategory' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($category ?? null),'currentState' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($state ?? null),'currentType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($type ?? 'all'),'showTypeFilter' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale9f22847d79d6273acb27aff60f1f678)): ?>
<?php $attributes = $__attributesOriginale9f22847d79d6273acb27aff60f1f678; ?>
<?php unset($__attributesOriginale9f22847d79d6273acb27aff60f1f678); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale9f22847d79d6273acb27aff60f1f678)): ?>
<?php $component = $__componentOriginale9f22847d79d6273acb27aff60f1f678; ?>
<?php unset($__componentOriginale9f22847d79d6273acb27aff60f1f678); ?>
<?php endif; ?>

    <!-- Premium Header Section -->
    <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex mb-3" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2"><?php echo e($title); ?></span>
                            </div>
                        </li>
                    </ol>
                </nav>
                
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
                    <?php echo e($title); ?>

                </h1>
                <p class="text-gray-500 text-sm md:text-base flex items-center gap-2">
                    <span class="inline-flex items-center justify-center bg-blue-100 text-blue-700 rounded-full w-6 h-6 text-xs font-bold">
                        <?php echo e($posts->total()); ?>

                    </span>
                    Posts available right now
                </p>
            </div>
            
            <div class="flex items-center gap-3 bg-gray-50 p-2 rounded-xl border border-gray-100 w-full md:w-auto">
                <form action="<?php echo e(url()->current()); ?>" method="GET" class="relative w-full">
                    <input type="text" name="search" placeholder="Search in these posts..." value="<?php echo e(request('search')); ?>" 
                           class="w-full md:w-64 pl-10 pr-4 py-2 border-none bg-white rounded-lg focus:ring-2 focus:ring-blue-500 text-sm shadow-sm ring-1 ring-gray-200">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <!-- Carry over any existing query params except search and page -->
                    <?php $__currentLoopData = request()->except(['search', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </form>
            </div>
        </div>
    </div>

    <?php if($posts->count() > 0): ?>
        <!-- Grid of Post Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="transform hover:-translate-y-1 transition-all duration-300 h-full">
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
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination Links -->
        <?php if($posts->hasPages()): ?>
        <div class="mt-12 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex justify-center">
            <?php echo e($posts->links()); ?>

        </div>
        <?php endif; ?>
    <?php else: ?>
        <!-- Premium Empty State -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-white opacity-50 z-0"></div>
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-24 h-24 mb-6 bg-gray-50 rounded-full flex items-center justify-center shadow-inner">
                    <i class="fas fa-search text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">No posts found</h3>
                <p class="text-gray-500 max-w-sm mx-auto mb-6">We couldn't find any posts matching your criteria. Try adjusting your search or check back later.</p>
                <?php if(request('search')): ?>
                    <a href="<?php echo e(url()->current()); ?>" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Clear Search
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Home
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/posts/index.blade.php ENDPATH**/ ?>