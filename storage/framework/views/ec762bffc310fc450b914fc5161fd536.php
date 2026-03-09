

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Welcome Section -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-teal-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-1">Welcome back, <?php echo e(auth('admin')->user()->name); ?>! 👋</h1>
                    <p class="text-blue-100">Here's what's happening with JobOne.in today</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                        <div class="text-center">
                            <div class="text-xl font-bold"><?php echo e(date('d')); ?></div>
                            <div class="text-xs opacity-90"><?php echo e(date('M Y')); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-md p-4 border border-slate-100 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-newspaper text-white"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">TOTAL</span>
            </div>
            <h3 class="text-slate-600 text-xs font-semibold mb-1">Total Posts</h3>
            <p class="text-2xl font-bold text-slate-800 mb-1"><?php echo e($stats['total_posts']); ?></p>
            <div class="flex items-center text-xs">
                <i class="fas fa-arrow-up text-emerald-500 mr-1"></i>
                <span class="text-emerald-600 font-semibold">+12%</span>
                <span class="text-slate-500 ml-1 text-xs">vs last month</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-4 border border-slate-100 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">LIVE</span>
            </div>
            <h3 class="text-slate-600 text-xs font-semibold mb-1">Published Posts</h3>
            <p class="text-2xl font-bold text-slate-800 mb-1"><?php echo e($stats['published_posts']); ?></p>
            <div class="flex items-center text-xs">
                <i class="fas fa-arrow-up text-emerald-500 mr-1"></i>
                <span class="text-emerald-600 font-semibold">+8%</span>
                <span class="text-slate-500 ml-1 text-xs">vs last month</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-4 border border-slate-100 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-white"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">VIEWS</span>
            </div>
            <h3 class="text-slate-600 text-xs font-semibold mb-1">Total Views</h3>
            <p class="text-2xl font-bold text-slate-800 mb-1"><?php echo e(number_format($stats['total_views'])); ?></p>
            <div class="flex items-center text-xs">
                <i class="fas fa-arrow-up text-emerald-500 mr-1"></i>
                <span class="text-emerald-600 font-semibold">+24%</span>
                <span class="text-slate-500 ml-1 text-xs">vs last month</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-4 border border-slate-100 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-white"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">ACTIVE</span>
            </div>
            <h3 class="text-slate-600 text-xs font-semibold mb-1">Categories</h3>
            <p class="text-2xl font-bold text-slate-800 mb-1"><?php echo e($stats['total_categories']); ?></p>
            <div class="flex items-center text-xs">
                <i class="fas fa-minus text-slate-400 mr-1"></i>
                <span class="text-slate-500 font-semibold">No change</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 border border-slate-100 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">AUTHORS</span>
            </div>
            <h3 class="text-slate-600 text-xs font-semibold mb-1">Active Authors</h3>
            <p class="text-2xl font-bold text-slate-800 mb-1"><?php echo e($stats['active_authors']); ?><span class="text-base text-slate-500">/<?php echo e($stats['total_authors']); ?></span></p>
            <div class="flex items-center text-xs">
                <i class="fas fa-arrow-up text-emerald-500 mr-1"></i>
                <span class="text-emerald-600 font-semibold">+2</span>
                <span class="text-slate-500 ml-1 text-xs">new this month</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Posts -->
        <div class="bg-white rounded-xl shadow-lg p-5 border border-slate-100">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-clock text-blue-500"></i>
                    Recent Posts
                </h2>
                <a href="<?php echo e(route('admin.posts.create')); ?>" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-200 text-xs font-medium">
                    <i class="fas fa-plus mr-1"></i>New Post
                </a>
            </div>
            
            <?php if($recent_posts->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $recent_posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-all duration-200">
                            <div class="w-10 h-10 bg-gradient-to-br from-slate-200 to-slate-300 rounded-lg flex items-center justify-center flex-shrink-0">
                                <?php switch($post->type):
                                    case ('job'): ?>
                                        <i class="fas fa-briefcase text-slate-600 text-sm"></i>
                                        <?php break; ?>
                                    <?php case ('result'): ?>
                                        <i class="fas fa-chart-bar text-slate-600 text-sm"></i>
                                        <?php break; ?>
                                    <?php case ('admit_card'): ?>
                                        <i class="fas fa-id-card text-slate-600 text-sm"></i>
                                        <?php break; ?>
                                    <?php case ('answer_key'): ?>
                                        <i class="fas fa-key text-slate-600 text-sm"></i>
                                        <?php break; ?>
                                    <?php case ('syllabus'): ?>
                                        <i class="fas fa-book text-slate-600 text-sm"></i>
                                        <?php break; ?>
                                    <?php case ('blog'): ?>
                                        <i class="fas fa-pen-fancy text-slate-600 text-sm"></i>
                                        <?php break; ?>
                                    <?php default: ?>
                                        <i class="fas fa-file text-slate-600 text-sm"></i>
                                <?php endswitch; ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-slate-800 mb-1 text-sm truncate"><?php echo e(Str::limit($post->title, 40)); ?></p>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="bg-slate-200 px-2 py-0.5 rounded-full"><?php echo e(ucfirst(str_replace('_', ' ', $post->type))); ?></span>
                                    <span><i class="fas fa-eye mr-1"></i><?php echo e($post->view_count); ?></span>
                                </div>
                            </div>
                            <div>
                                <?php if($post->is_published): ?>
                                    <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full text-xs font-semibold">Published</span>
                                <?php else: ?>
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Draft</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-newspaper text-slate-300 text-3xl mb-3"></i>
                    <p class="text-slate-500">No posts yet</p>
                    <p class="text-slate-400 text-xs">Create your first post to get started</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Authors & Quick Stats -->
        <div class="space-y-6">
            <!-- Recent Authors -->
            <div class="bg-white rounded-xl shadow-lg p-5 border border-slate-100">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-users text-purple-500"></i>
                        Recent Authors
                    </h2>
                    <a href="<?php echo e(route('admin.authors.index')); ?>" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-200 text-xs font-medium">
                        <i class="fas fa-plus mr-1"></i>New Author
                    </a>
                </div>
                
                <?php if($recent_authors->count() > 0): ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $recent_authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-all duration-200">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-semibold text-sm"><?php echo e(substr($author->name, 0, 1)); ?></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-slate-800 text-sm truncate"><?php echo e($author->name); ?></p>
                                    <p class="text-xs text-slate-500 truncate"><?php echo e($author->email); ?></p>
                                </div>
                                <div>
                                    <?php if($author->is_active): ?>
                                        <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full text-xs font-semibold">Active</span>
                                    <?php else: ?>
                                        <span class="bg-slate-100 text-slate-800 px-2 py-1 rounded-full text-xs font-semibold">Inactive</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-users text-slate-300 text-3xl mb-3"></i>
                        <p class="text-slate-500">No authors yet</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-xl p-5 border border-slate-200">
                <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-bolt text-yellow-500"></i>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="<?php echo e(route('admin.posts.create')); ?>" class="bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-center">
                        <i class="fas fa-plus text-blue-500 text-lg mb-2"></i>
                        <p class="text-xs font-semibold text-slate-700">New Post</p>
                    </a>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-center">
                        <i class="fas fa-tags text-orange-500 text-lg mb-2"></i>
                        <p class="text-xs font-semibold text-slate-700">Categories</p>
                    </a>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-center">
                        <i class="fas fa-cog text-slate-500 text-lg mb-2"></i>
                        <p class="text-xs font-semibold text-slate-700">Settings</p>
                    </a>
                    <a href="<?php echo e(route('home')); ?>" target="_blank" class="bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-center">
                        <i class="fas fa-external-link-alt text-emerald-500 text-lg mb-2"></i>
                        <p class="text-xs font-semibold text-slate-700">View Site</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>