

<?php $__env->startSection('title', $state->name . ' - Government Jobs'); ?>
<?php $__env->startSection('description', 'Latest government jobs in ' . $state->name); ?>

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
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .modern-card-item-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 2px 6px;
            background: #f0f0f0;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            color: #666;
        }
        .modern-card-item-badge.category {
            background: #e3f2fd;
            color: #1976d2;
        }
        .modern-card-item-badge.state {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        .modern-card-item-badge.views {
            background: #fff3e0;
            color: #e65100;
        }
        .modern-card-item-badge.new {
            background: #e8f5e9;
            color: #2e7d32;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
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
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .modern-card {
                min-height: 180px;
            }
            .modern-card-header {
                padding: 8px 12px;
                font-size: 12px;
            }
            .modern-card-item {
                padding: 8px 12px;
                font-size: 12px;
            }
            .modern-card-item:hover {
                padding-left: 16px;
            }
            .modern-card-item a {
                font-size: 12px;
                line-height: 1.3;
                word-wrap: break-word;
                overflow-wrap: break-word;
            }
            .modern-card-footer {
                padding: 8px 12px;
                font-size: 11px;
            }
        }
        
        /* Ensure proper grid behavior */
        .grid {
            display: grid;
            width: 100%;
        }
        
        @media (max-width: 767px) {
            .grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>

    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">
            <i class="fas fa-map-marker-alt"></i> <?php echo e($state->name); ?> - Government Jobs
        </h1>
        <p class="text-gray-600 text-sm"><i class="fas fa-briefcase"></i> Showing <?php echo e($posts->count()); ?> of <?php echo e($posts->total()); ?> posts in <?php echo e($state->name); ?></p>
    </div>

    <!-- Six Column Layout - Different Post Types for This State -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-4">
        <!-- Left Column: Jobs -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fas fa-briefcase"></i> Jobs in <?php echo e($state->name); ?>

            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $posts->where('type', 'job'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></span>
                        <?php if($post->category): ?>
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> <?php echo e($post->category->name); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->view_count > 0): ?>
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> <?php echo e(number_format($post->view_count)); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->created_at->diffInDays(now()) <= 3): ?>
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="modern-card-item text-gray-500">
                    No jobs found
                </div>
                <?php endif; ?>
            </div>
            <div class="modern-card-footer text-blue-600">
                <span><?php echo e($posts->where('type', 'job')->count()); ?> jobs</span>
            </div>
        </div>

        <!-- Middle Column: Results -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);">
                <i class="fas fa-chart-bar"></i> Results in <?php echo e($state->name); ?>

            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $posts->where('type', 'result'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></span>
                        <?php if($post->category): ?>
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> <?php echo e($post->category->name); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->view_count > 0): ?>
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> <?php echo e(number_format($post->view_count)); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->created_at->diffInDays(now()) <= 3): ?>
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="modern-card-item text-gray-500">
                    No results found
                </div>
                <?php endif; ?>
            </div>
            <div class="modern-card-footer text-green-600">
                <span><?php echo e($posts->where('type', 'result')->count()); ?> results</span>
            </div>
        </div>

        <!-- Right Column: Admit Cards -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                <i class="fas fa-id-card"></i> Admit Cards in <?php echo e($state->name); ?>

            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $posts->where('type', 'admit_card'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></span>
                        <?php if($post->category): ?>
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> <?php echo e($post->category->name); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->view_count > 0): ?>
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> <?php echo e(number_format($post->view_count)); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->created_at->diffInDays(now()) <= 3): ?>
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="modern-card-item text-gray-500">
                    No admit cards found
                </div>
                <?php endif; ?>
            </div>
            <div class="modern-card-footer text-purple-600">
                <span><?php echo e($posts->where('type', 'admit_card')->count()); ?> admit cards</span>
            </div>
        </div>

        <!-- Answer Keys -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                <i class="fas fa-key"></i> Answer Keys in <?php echo e($state->name); ?>

            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $posts->where('type', 'answer_key'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></span>
                        <?php if($post->category): ?>
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> <?php echo e($post->category->name); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->view_count > 0): ?>
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> <?php echo e(number_format($post->view_count)); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->created_at->diffInDays(now()) <= 3): ?>
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="modern-card-item text-gray-500">
                    No answer keys found
                </div>
                <?php endif; ?>
            </div>
            <div class="modern-card-footer text-yellow-600">
                <span><?php echo e($posts->where('type', 'answer_key')->count()); ?> answer keys</span>
            </div>
        </div>

        <!-- Syllabus -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <i class="fas fa-book"></i> Syllabus in <?php echo e($state->name); ?>

            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $posts->where('type', 'syllabus'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></span>
                        <?php if($post->category): ?>
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> <?php echo e($post->category->name); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->view_count > 0): ?>
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> <?php echo e(number_format($post->view_count)); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->created_at->diffInDays(now()) <= 3): ?>
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="modern-card-item text-gray-500">
                    No syllabus found
                </div>
                <?php endif; ?>
            </div>
            <div class="modern-card-footer text-indigo-600">
                <span><?php echo e($posts->where('type', 'syllabus')->count()); ?> syllabus</span>
            </div>
        </div>

        <!-- Blogs -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);">
                <i class="fas fa-pen-fancy"></i> Blogs in <?php echo e($state->name); ?>

            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $posts->where('type', 'blog'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="modern-card-item">
                    <a href="<?php echo e(route('posts.show', ['type' => $post->type, 'post' => $post->slug])); ?>">
                        <?php echo e($post->title); ?>

                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> <?php echo e($post->created_at->format('M d, Y')); ?></span>
                        <?php if($post->category): ?>
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> <?php echo e($post->category->name); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->view_count > 0): ?>
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> <?php echo e(number_format($post->view_count)); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($post->created_at->diffInDays(now()) <= 3): ?>
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="modern-card-item text-gray-500">
                    No blogs found
                </div>
                <?php endif; ?>
            </div>
            <div class="modern-card-footer text-pink-600">
                <span><?php echo e($posts->where('type', 'blog')->count()); ?> blogs</span>
            </div>
        </div>
    </div>

    <!-- Pagination Links -->
    <?php if($posts->hasPages()): ?>
    <div class="mt-8">
        <?php echo e($posts->links()); ?>

    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/states/show.blade.php ENDPATH**/ ?>