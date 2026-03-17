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
            transition: all 0.2s ease;
        }
        .modern-card-item:last-child {
            border-bottom: none;
        }
        .modern-card-item:hover {
            background: #f8f9fa;
            padding-left: 20px;
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
        
        /* Consistent color for all job cards */
        .modern-card-item a { color: #0066cc !important; } /* Single blue color for all */
    </style>

    <!-- Six Column Layout - Different Post Types -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left Column: Jobs -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-blue-600">
                <i class="fas fa-briefcase"></i> Latest Jobs
            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $sections['jobs'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <?php if($post->state): ?>
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($post->state->name); ?>

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
                <a href="<?php echo e(route('posts.jobs')); ?>">View All Jobs →</a>
            </div>
        </div>

        <!-- Middle Column: Results -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-green-600">
                <i class="fas fa-chart-bar"></i> Exam Results
            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $sections['results'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <?php if($post->state): ?>
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($post->state->name); ?>

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
                <a href="<?php echo e(route('posts.results')); ?>">View All Results →</a>
            </div>
        </div>

        <!-- Right Column: Admit Cards -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-purple-600">
                <i class="fas fa-id-card"></i> Admit Cards
            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $sections['admit_cards'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <?php if($post->state): ?>
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($post->state->name); ?>

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
                <a href="<?php echo e(route('posts.admit-cards')); ?>">View All Admit Cards →</a>
            </div>
        </div>
    </div>

    <!-- Second Row: Answer Keys, Syllabus, Blogs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <!-- Answer Keys -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-yellow-600">
                <i class="fas fa-key"></i> Answer Keys
            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $sections['answer_keys'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <?php if($post->state): ?>
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($post->state->name); ?>

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
                <a href="<?php echo e(route('posts.answer-keys')); ?>">View All Answer Keys →</a>
            </div>
        </div>

        <!-- Syllabus -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-indigo-600">
                <i class="fas fa-book"></i> Syllabus
            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $sections['syllabus'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <?php if($post->state): ?>
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($post->state->name); ?>

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
                <a href="<?php echo e(route('posts.syllabus')); ?>">View All Syllabus →</a>
            </div>
        </div>

        <!-- Blogs -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-pink-600">
                <i class="fas fa-pen-fancy"></i> Blogs
            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $sections['blogs'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <?php if($post->state): ?>
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($post->state->name); ?>

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
                <a href="<?php echo e(route('posts.blogs')); ?>">View All Blogs →</a>
            </div>
        </div>
    </div>

    <!-- Share Section -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-0 shadow-sm">
        <h3 class="font-bold text-gray-900 mb-4 text-base flex items-center gap-2">
            <i class="fas fa-share-alt"></i> Follow & Share
        </h3>
        
        <?php
            $shareUrl = route('home');
            $shareTitle = 'JobOne - Latest Government Jobs, Results, Admit Cards';
            $simpleMessage = "{$shareTitle} - Visit: {$shareUrl}";
            $encodedSimpleMessage = urlencode($simpleMessage);
            $encodedUrl = urlencode($shareUrl);
            $encodedTitle = urlencode($shareTitle);
        ?>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- WhatsApp -->
            <a href="https://wa.me/?text=<?php echo e($encodedSimpleMessage); ?>" 
               target="_blank" 
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #25D366;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-whatsapp" style="font-size: 20px;"></i>
                </div>
                <span>WhatsApp</span>
            </a>
            
            <!-- Telegram -->
            <a href="https://t.me/share/url?url=<?php echo e($encodedUrl); ?>&text=<?php echo e($encodedTitle); ?>" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #0088cc;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-telegram" style="font-size: 20px;"></i>
                </div>
                <span>Telegram</span>
            </a>
            
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($encodedUrl); ?>" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #1877F2;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-facebook-f" style="font-size: 20px;"></i>
                </div>
                <span>Facebook</span>
            </a>
            
            <!-- Twitter/X -->
            <a href="https://twitter.com/intent/tweet?url=<?php echo e($encodedUrl); ?>&text=<?php echo e($encodedTitle); ?>" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #000000;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-twitter" style="font-size: 20px;"></i>
                </div>
                <span>Twitter</span>
            </a>
        </div>
        
        <p class="text-xs text-gray-700 mt-4 text-center">
            <i class="fas fa-info-circle"></i> Share with your friends and help them stay updated!
        </p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/home.blade.php ENDPATH**/ ?>