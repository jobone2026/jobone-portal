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

    <!-- Single Column Layout - All Posts -->
    <div class="grid grid-cols-1 gap-4">
        <!-- All Posts Combined -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-gradient-to-r from-blue-600 to-indigo-600">
                <i class="fas fa-list"></i> All Latest Updates
            </div>
            <div>
                <?php
                    // Combine all posts and sort by created_at
                    $allPosts = collect();
                    foreach($sections as $sectionName => $posts) {
                        $allPosts = $allPosts->merge($posts);
                    }
                    $allPosts = $allPosts->sortByDesc('created_at')->take(100);
                ?>
                
                <?php $__currentLoopData = $allPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                        <span class="modern-card-item-badge type" style="background: 
                            <?php if($post->type == 'job'): ?> #e3f2fd; color: #1976d2;
                            <?php elseif($post->type == 'result'): ?> #e8f5e9; color: #2e7d32;
                            <?php elseif($post->type == 'admit_card'): ?> #f3e5f5; color: #7b1fa2;
                            <?php elseif($post->type == 'answer_key'): ?> #fff3e0; color: #e65100;
                            <?php elseif($post->type == 'syllabus'): ?> #e8eaf6; color: #3f51b5;
                            <?php elseif($post->type == 'blog'): ?> #fce4ec; color: #c2185b;
                            <?php else: ?> #f0f0f0; color: #666;
                            <?php endif; ?>">
                            <i class="fas fa-
                                <?php if($post->type == 'job'): ?> briefcase
                                <?php elseif($post->type == 'result'): ?> chart-bar
                                <?php elseif($post->type == 'admit_card'): ?> id-card
                                <?php elseif($post->type == 'answer_key'): ?> key
                                <?php elseif($post->type == 'syllabus'): ?> book
                                <?php elseif($post->type == 'blog'): ?> pen-fancy
                                <?php else: ?> file
                                <?php endif; ?>"></i> 
                            <?php echo e(ucfirst(str_replace('_', ' ', $post->type))); ?>

                        </span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="modern-card-footer text-blue-600">
                <a href="<?php echo e(route('posts.jobs')); ?>">View All Posts →</a>
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