

<?php $__env->startSection('title', 'Government Job Portal - Latest Jobs & Opportunities'); ?>
<?php $__env->startSection('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .modern-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            min-height: 200px;
        }
        .modern-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        .modern-card-header {
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            border-radius: 8px 8px 0 0;
        }
        .modern-card-item {
            padding: 10px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
            line-height: 1.4;
        }
        .modern-card-item:last-child {
            border-bottom: none;
        }
        .modern-card-item a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
            display: block;
            margin-bottom: 4px;
        }
        .modern-card-item a:hover {
            color: #0052a3;
            text-decoration: underline;
        }
        .modern-card-item-date {
            font-size: 11px;
            color: #999;
            margin-top: 2px;
        }
        .modern-card-footer {
            padding: 10px 16px;
            background: #f8f9fa;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 12px;
        }
        .modern-card-footer a {
            color: inherit;
            font-weight: 600;
            text-decoration: none;
        }
        .modern-card-footer a:hover {
            text-decoration: underline;
        }
    </style>

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

    <!-- Three Column Table Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left Column: Jobs -->
        <?php if($sections['jobs']->count() > 0): ?>
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-blue-600">
                <i class="fas fa-briefcase"></i> Latest Jobs
            </div>
            <div>
                <?php $__currentLoopData = $sections['jobs']->take(50); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="modern-card-footer text-blue-600">
                <a href="<?php echo e(route('posts.jobs')); ?>">View All Jobs →</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Middle Column: Results -->
        <?php if($sections['results']->count() > 0): ?>
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-green-600">
                <i class="fas fa-chart-bar"></i> Exam Results
            </div>
            <div>
                <?php $__currentLoopData = $sections['results']->take(50); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="modern-card-footer text-green-600">
                <a href="<?php echo e(route('posts.results')); ?>">View All Results →</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Right Column: Admit Cards -->
        <?php if($sections['admit_cards']->count() > 0): ?>
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-purple-600">
                <i class="fas fa-id-card"></i> Admit Cards
            </div>
            <div>
                <?php $__currentLoopData = $sections['admit_cards']->take(50); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="modern-card-footer text-purple-600">
                <a href="<?php echo e(route('posts.admit-cards')); ?>">View All Admit Cards →</a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Additional Sections (Optional) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <!-- Answer Keys -->
        <?php if($sections['answer_keys']->count() > 0): ?>
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-yellow-600">
                <i class="fas fa-key"></i> Answer Keys
            </div>
            <div>
                <?php $__currentLoopData = $sections['answer_keys']->take(50); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="modern-card-footer text-yellow-600">
                <a href="<?php echo e(route('posts.answer-keys')); ?>">View All Answer Keys →</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Syllabus -->
        <?php if($sections['syllabus']->count() > 0): ?>
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-indigo-600">
                <i class="fas fa-book"></i> Syllabus
            </div>
            <div>
                <?php $__currentLoopData = $sections['syllabus']->take(50); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="modern-card-footer text-indigo-600">
                <a href="<?php echo e(route('posts.syllabus')); ?>">View All Syllabus →</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Blogs -->
        <?php if($sections['blogs']->count() > 0): ?>
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-pink-600">
                <i class="fas fa-pen-fancy"></i> Blogs
            </div>
            <div>
                <?php $__currentLoopData = $sections['blogs']->take(50); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="modern-card-footer text-pink-600">
                <a href="<?php echo e(route('posts.blogs')); ?>">View All Blogs →</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/home.blade.php ENDPATH**/ ?>