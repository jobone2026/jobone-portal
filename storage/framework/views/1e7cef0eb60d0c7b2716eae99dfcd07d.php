<div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-blue-400 overflow-hidden">
    <?php
        $daysRemaining = null;
        $isUrgent = false;
        if ($post->last_date) {
            $daysRemaining = now()->diffInDays($post->last_date, false);
            $isUrgent = $daysRemaining <= 5 && $daysRemaining >= 0;
        }
    ?>
    
    <!-- Header with Badges -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-3 py-1.5 border-b border-blue-100">
        <div class="flex items-center gap-1.5 flex-wrap">
            <?php if($isUrgent): ?>
                <span class="bg-red-500 text-white px-2 py-0.5 rounded text-xs font-bold flex items-center gap-1">
                    <i class="fa-solid fa-exclamation-circle text-xs"></i> URGENT
                </span>
            <?php endif; ?>
            <span class="text-white px-2 py-0.5 rounded text-xs font-bold flex items-center gap-1" style="background: #7FE3A5 !important;">
                <i class="fa-solid fa-star text-xs"></i> NEW
            </span>
            <?php if($post->state): ?>
                <span class="text-white px-2 py-0.5 rounded text-xs font-bold flex items-center gap-1" style="background: #97BBC4 !important;">
                    <i class="fa-solid fa-map-marker-alt text-xs"></i> <?php echo e($post->state->name); ?>

                </span>
            <?php else: ?>
                <span class="text-white px-2 py-0.5 rounded text-xs font-bold flex items-center gap-1" style="background: #B8A4E8 !important;">
                    <i class="fa-solid fa-globe text-xs"></i> All India
                </span>
            <?php endif; ?>
            <?php if($post->tags && count($post->tags) > 0): ?>
                <?php $__currentLoopData = $post->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="text-white px-2 py-0.5 rounded text-xs font-bold flex items-center gap-1" style="background: #F59E0B !important;">
                        <i class="fa-solid fa-bookmark text-xs"></i> <?php echo e(ucfirst(str_replace('_', ' ', $tag))); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($post->education && count($post->education) > 0): ?>
                <?php $__currentLoopData = $post->education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $eduLabels = [
                            '10th_pass' => '10th',
                            '12th_pass' => '12th',
                            'graduate' => 'Graduate',
                            'post_graduate' => 'PG',
                            'diploma' => 'Diploma',
                            'iti' => 'ITI',
                            'btech' => 'B.Tech',
                            'mtech' => 'M.Tech',
                            'bsc' => 'B.Sc',
                            'msc' => 'M.Sc',
                            'bcom' => 'B.Com',
                            'mcom' => 'M.Com',
                            'ba' => 'B.A',
                            'ma' => 'M.A',
                            'bba' => 'BBA',
                            'mba' => 'MBA',
                            'ca' => 'CA',
                            'cs' => 'CS',
                            'cma' => 'CMA',
                            'llb' => 'LLB',
                            'llm' => 'LLM',
                            'mbbs' => 'MBBS',
                            'bds' => 'BDS',
                            'bpharm' => 'B.Pharm',
                            'mpharm' => 'M.Pharm',
                            'nursing' => 'Nursing',
                            'bed' => 'B.Ed',
                            'med' => 'M.Ed',
                            'phd' => 'PhD',
                            'any_qualification' => 'Any'
                        ];
                    ?>
                    <span class="text-white px-2 py-0.5 rounded text-xs font-bold flex items-center gap-1" style="background: #10B981 !important;">
                        <i class="fa-solid fa-graduation-cap text-xs"></i> <?php echo e($eduLabels[$edu] ?? ucfirst(str_replace('_', ' ', $edu))); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="p-3">
        <!-- Title -->
        <h3 class="font-bold mb-2.5 transition-colors" style="font-size: 13px; line-height: 1.4; color: #1f2937;">
            <a href="<?php echo e(route('posts.show', [$post->type, $post->slug])); ?>" class="block hover:text-blue-600" style="color: inherit; text-decoration: none;">
                <?php echo e($post->title); ?>

            </a>
        </h3>
        
        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-2 mb-2.5">
            <!-- Posted Date -->
            <div class="flex items-center gap-1.5 text-xs text-gray-600">
                <i class="fa-solid fa-calendar text-blue-500 text-xs"></i>
                <div>
                    <div class="text-xs text-gray-500">Posted</div>
                    <div class="font-semibold text-xs"><?php echo e($post->created_at->format('d M Y')); ?></div>
                </div>
            </div>
            
            <!-- Last Date -->
            <?php if($post->last_date): ?>
                <div class="flex items-center gap-1.5 text-xs <?php echo e($isUrgent ? 'text-red-600' : 'text-orange-600'); ?>">
                    <i class="fa-solid fa-clock text-xs <?php echo e($isUrgent ? 'animate-pulse' : ''); ?>"></i>
                    <div>
                        <div class="text-xs">Last Date</div>
                        <div class="font-bold text-xs"><?php echo e($post->last_date->format('d M Y')); ?></div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Vacancies -->
            <?php if($post->total_posts): ?>
                <div class="flex items-center gap-1.5 text-xs text-green-700">
                    <i class="fa-solid fa-briefcase text-green-600 text-xs"></i>
                    <div>
                        <div class="text-xs text-gray-500">Vacancies</div>
                        <div class="font-bold text-xs"><?php echo e(number_format($post->total_posts)); ?></div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Category -->
            <?php if($post->category): ?>
                <div class="flex items-center gap-1.5 text-xs text-purple-700">
                    <i class="fa-solid fa-tag text-purple-600 text-xs"></i>
                    <div>
                        <div class="text-xs text-gray-500">Category</div>
                        <div class="font-semibold text-xs"><?php echo e($post->category->name); ?></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-2 pt-2.5 border-t border-gray-100">
            <a href="<?php echo e(route('posts.show', [$post->type, $post->slug])); ?>" 
               class="flex-1 px-3 py-2 text-white text-xs font-bold rounded shadow-sm hover:shadow-md transition-all text-center flex items-center justify-center gap-1"
               style="background: #97BBC4 !important; color: #ffffff !important; text-decoration: none !important;"
               onmouseover="this.style.background='#7FA9B5'" 
               onmouseout="this.style.background='#97BBC4'">
                <i class="fa-solid fa-info-circle text-xs"></i>
                View Details
            </a>
            <a href="<?php echo e(route('posts.show', [$post->type, $post->slug])); ?>#apply" 
               class="flex-1 px-3 py-2 text-white text-xs font-bold rounded shadow-sm hover:shadow-md transition-all text-center flex items-center justify-center gap-1"
               style="background: #7FE3A5 !important; color: #ffffff !important; text-decoration: none !important;"
               onmouseover="this.style.background='#5FD18A'" 
               onmouseout="this.style.background='#7FE3A5'">
                <i class="fa-solid fa-paper-plane text-xs"></i>
                Apply Now
            </a>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/components/post-card.blade.php ENDPATH**/ ?>