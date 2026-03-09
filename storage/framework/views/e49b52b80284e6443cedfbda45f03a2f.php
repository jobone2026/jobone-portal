

<?php $__env->startSection('title', $post->meta_title); ?>
<?php $__env->startSection('description', $post->meta_description); ?>
<?php $__env->startSection('keywords', $post->meta_keywords); ?>
<?php $__env->startSection('canonical', route('posts.show', [$post->type, $post->slug])); ?>
<?php $__env->startSection('og_title', $post->meta_title); ?>
<?php $__env->startSection('og_description', $post->meta_description); ?>
<?php $__env->startSection('og_url', route('posts.show', [$post->type, $post->slug])); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .modern-content {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #e9ecef;
        }
        .modern-content h1, .modern-content h2, .modern-content h3 {
            color: #1a202c;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .modern-content p {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 1rem;
            font-size: 14px;
        }
        .modern-content a {
            color: #0066cc;
            text-decoration: none;
        }
        .modern-content a:hover {
            text-decoration: underline;
        }
    </style>

    <!-- Breadcrumb -->
    <?php
        $typeRouteMap = [
            'job' => 'posts.jobs',
            'admit_card' => 'posts.admit-cards',
            'result' => 'posts.results',
            'answer_key' => 'posts.answer-keys',
            'syllabus' => 'posts.syllabus',
            'blog' => 'posts.blogs'
        ];
        $typeRoute = $typeRouteMap[$post->type] ?? 'home';
    ?>
    <?php if (isset($component)) { $__componentOriginal269900abaed345884ce342681cdc99f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal269900abaed345884ce342681cdc99f6 = $attributes; } ?>
<?php $component = App\View\Components\Breadcrumb::resolve(['items' => [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => ucfirst(str_replace('_', ' ', $post->type)), 'url' => route($typeRoute)],
        ['label' => $post->title, 'url' => '#']
    ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Breadcrumb::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal269900abaed345884ce342681cdc99f6)): ?>
<?php $attributes = $__attributesOriginal269900abaed345884ce342681cdc99f6; ?>
<?php unset($__attributesOriginal269900abaed345884ce342681cdc99f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal269900abaed345884ce342681cdc99f6)): ?>
<?php $component = $__componentOriginal269900abaed345884ce342681cdc99f6; ?>
<?php unset($__componentOriginal269900abaed345884ce342681cdc99f6); ?>
<?php endif; ?>

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

    <article class="modern-content rounded-lg shadow-md p-6 md:p-8 mb-8">
        <div class="mb-6">
            <div class="flex justify-between items-start mb-4 flex-wrap gap-2">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex-1"><?php echo e($post->title); ?></h1>
                <?php if($post->isNew()): ?>
                    <span class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold">NEW</span>
                <?php endif; ?>
            </div>

            <div class="flex flex-wrap gap-2 mb-4">
                <span class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium"><i class="fas fa-tag"></i> <?php echo e(ucfirst(str_replace('_', ' ', $post->type))); ?></span>
                <?php if($post->category): ?>
                    <a href="<?php echo e(route('categories.show', $post->category)); ?>" class="text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded-full hover:bg-gray-200 transition font-medium">
                        <i class="fas fa-folder"></i> <?php echo e($post->category->name); ?>

                    </a>
                <?php endif; ?>
                <?php if($post->state): ?>
                    <a href="<?php echo e(route('states.show', $post->state)); ?>" class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full hover:bg-green-200 transition font-medium">
                        <i class="fas fa-map-marker-alt"></i> <?php echo e($post->state->name); ?>

                    </a>
                <?php endif; ?>
            </div>

            <div class="flex justify-between items-center text-2xs text-gray-600 border-t border-b border-gray-200 py-3">
                <span><i class="fas fa-calendar"></i> Published: <?php echo e($post->created_at->format('M d, Y')); ?></span>
                <span><i class="fas fa-eye"></i> <?php echo e($post->view_count); ?> views</span>
            </div>
        </div>

        <!-- Important Dates -->
        <?php if($post->last_date || $post->notification_date || $post->total_posts): ?>
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-600 p-4 mb-6 rounded-r-lg">
                <h3 class="font-bold text-blue-900 mb-2 text-sm"><i class="fas fa-info-circle"></i> Important Information</h3>
                <ul class="text-xs text-blue-800 space-y-1">
                    <?php if($post->notification_date): ?>
                        <li><strong>Notification Date:</strong> <?php echo e($post->notification_date->format('M d, Y')); ?></li>
                    <?php endif; ?>
                    <?php if($post->last_date): ?>
                        <li><strong>Last Date:</strong> <?php echo e($post->last_date->format('M d, Y')); ?></li>
                    <?php endif; ?>
                    <?php if($post->total_posts): ?>
                        <li><strong>Total Posts:</strong> <?php echo e($post->total_posts); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Short Description -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-lg mb-6 border border-gray-200">
            <p class="text-gray-700 text-sm leading-relaxed"><?php echo e($post->short_description); ?></p>
        </div>

        <!-- Main Content -->
        <div class="prose prose-sm max-w-none mb-6 text-sm">
            <?php echo $post->content; ?>

        </div>

        <!-- Important Links -->
        <?php
            $importantLinks = $post->important_links;
            // Handle case where important_links might be a JSON string instead of array
            if (is_string($importantLinks)) {
                $importantLinks = json_decode($importantLinks, true) ?? [];
            }
            // Ensure it's an array
            if (!is_array($importantLinks)) {
                $importantLinks = [];
            }
        ?>
        <?php if(count($importantLinks) > 0): ?>
            <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 p-4 mb-6 rounded-r-lg">
                <h3 class="font-bold text-green-900 mb-3 text-sm"><i class="fas fa-link"></i> Important Links</h3>
                <ul class="space-y-2">
                    <?php $__currentLoopData = $importantLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_array($value) && isset($value['url'])): ?>
                            
                            <li>
                                <a href="<?php echo e($value['url']); ?>" target="_blank" rel="noopener noreferrer" class="text-green-600 hover:text-green-800 font-semibold text-xs transition">
                                    <i class="fas fa-external-link-alt"></i> <?php echo e($value['label'] ?? ucwords(str_replace('_', ' ', $key))); ?>

                                </a>
                            </li>
                        <?php else: ?>
                            
                            <li>
                                <a href="<?php echo e($value); ?>" target="_blank" rel="noopener noreferrer" class="text-green-600 hover:text-green-800 font-semibold text-xs transition">
                                    <i class="fas fa-external-link-alt"></i> <?php echo e(ucwords(str_replace('_', ' ', $key))); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </article>

    <!-- Ad Slot - After Post -->
    <?php if (isset($component)) { $__componentOriginal6224023613e8aab946c7515047a47263 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6224023613e8aab946c7515047a47263 = $attributes; } ?>
<?php $component = App\View\Components\AdSlot::resolve(['position' => 'after_post'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ad-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdSlot::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6224023613e8aab946c7515047a47263)): ?>
<?php $attributes = $__attributesOriginal6224023613e8aab946c7515047a47263; ?>
<?php unset($__attributesOriginal6224023613e8aab946c7515047a47263); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6224023613e8aab946c7515047a47263)): ?>
<?php $component = $__componentOriginal6224023613e8aab946c7515047a47263; ?>
<?php unset($__componentOriginal6224023613e8aab946c7515047a47263); ?>
<?php endif; ?>

    <!-- Related Posts -->
    <?php if($related->count() > 0): ?>
        <div class="mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4"><i class="fas fa-link"></i> Related Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="modern-content rounded-lg p-4">
                        <a href="<?php echo e(route('posts.show', ['type' => $relatedPost->type, 'post' => $relatedPost->slug])); ?>" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            <?php echo e($relatedPost->title); ?>

                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/posts/show.blade.php ENDPATH**/ ?>