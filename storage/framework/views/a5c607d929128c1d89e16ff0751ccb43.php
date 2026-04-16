<?php $__env->startSection('title', 'Government Job Portal - Latest Jobs & Opportunities'); ?>
<?php $__env->startSection('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more'); ?>

<?php $__env->startSection('content'); ?>
    <!-- India Map with State Job Counts -->

    <!-- Column Sections for Each Type -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Jobs Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-briefcase"></i> Latest Jobs</span>
                <a href="<?php echo e(route('posts.jobs')); ?>" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                <?php $__currentLoopData = ($sections['jobs'] ?? [])->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if(($sections['jobs'] ?? [])->count() > 25): ?>
            <div class="mt-4">
                <a href="<?php echo e(route('posts.jobs')); ?>" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Jobs <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Results Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-chart-bar"></i> Exam Results</span>
                <a href="<?php echo e(route('posts.results')); ?>" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                <?php $__currentLoopData = ($sections['results'] ?? [])->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if(($sections['results'] ?? [])->count() > 25): ?>
            <div class="mt-4">
                <a href="<?php echo e(route('posts.results')); ?>" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Results <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Admit Cards Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-id-card"></i> Admit Cards</span>
                <a href="<?php echo e(route('posts.admit-cards')); ?>" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                <?php $__currentLoopData = ($sections['admit_cards'] ?? [])->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if(($sections['admit_cards'] ?? [])->count() > 25): ?>
            <div class="mt-4">
                <a href="<?php echo e(route('posts.admit-cards')); ?>" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Admit Cards <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Answer Keys Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-key"></i> Answer Keys</span>
                <a href="<?php echo e(route('posts.answer-keys')); ?>" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                <?php $__currentLoopData = ($sections['answer_keys'] ?? [])->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if(($sections['answer_keys'] ?? [])->count() > 25): ?>
            <div class="mt-4">
                <a href="<?php echo e(route('posts.answer-keys')); ?>" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Answer Keys <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Syllabus Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-book"></i> Syllabus</span>
                <a href="<?php echo e(route('posts.syllabus')); ?>" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                <?php $__currentLoopData = ($sections['syllabus'] ?? [])->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if(($sections['syllabus'] ?? [])->count() > 25): ?>
            <div class="mt-4">
                <a href="<?php echo e(route('posts.syllabus')); ?>" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Syllabus <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Blogs Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-pen-fancy"></i> Blogs</span>
                <a href="<?php echo e(route('posts.blogs')); ?>" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                <?php $__currentLoopData = ($sections['blogs'] ?? [])->take(25); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if(($sections['blogs'] ?? [])->count() > 25): ?>
            <div class="mt-4">
                <a href="<?php echo e(route('posts.blogs')); ?>" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Blogs <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php endif; ?>
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
                    <i class="fab fa-facebook" style="font-size: 20px;"></i>
                </div>
                <span>Facebook</span>
            </a>
            
            <!-- Twitter -->
            <a href="https://twitter.com/intent/tweet?url=<?php echo e($encodedUrl); ?>&text=<?php echo e($encodedTitle); ?>" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #1DA1F2;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-twitter" style="font-size: 20px;"></i>
                </div>
                <span>Twitter</span>
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/home.blade.php ENDPATH**/ ?>