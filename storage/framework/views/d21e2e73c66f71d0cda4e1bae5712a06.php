<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'JobOne Admin'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col">
            <!-- Logo -->
            <div class="p-4 border-b border-slate-700">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-crown text-white text-sm"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-white">JobOne Admin</h1>
                        <p class="text-xs text-slate-400">Management</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-3">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800'); ?>">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                
                <div class="mt-6 mb-2 px-3 text-xs font-bold text-slate-500 uppercase">Content</div>
                
                <a href="<?php echo e(route('admin.posts.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 <?php echo e(request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800'); ?>">
                    <i class="fas fa-newspaper w-5"></i>
                    <span class="text-sm font-medium">Posts</span>
                    <span class="ml-auto bg-slate-700 text-slate-300 text-xs px-2 py-0.5 rounded-full"><?php echo e(\App\Models\Post::count()); ?></span>
                </a>
                
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800'); ?>">
                    <i class="fas fa-tags w-5"></i>
                    <span class="text-sm font-medium">Categories</span>
                    <span class="ml-auto bg-slate-700 text-slate-300 text-xs px-2 py-0.5 rounded-full"><?php echo e(\App\Models\Category::count()); ?></span>
                </a>
                
                <a href="<?php echo e(route('admin.states.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 <?php echo e(request()->routeIs('admin.states.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800'); ?>">
                    <i class="fas fa-map-marker-alt w-5"></i>
                    <span class="text-sm font-medium">States</span>
                    <span class="ml-auto bg-slate-700 text-slate-300 text-xs px-2 py-0.5 rounded-full"><?php echo e(\App\Models\State::count()); ?></span>
                </a>
                
                <a href="<?php echo e(route('admin.authors.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 <?php echo e(request()->routeIs('admin.authors.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800'); ?>">
                    <i class="fas fa-users w-5"></i>
                    <span class="text-sm font-medium">Authors</span>
                    <span class="ml-auto bg-slate-700 text-slate-300 text-xs px-2 py-0.5 rounded-full"><?php echo e(\App\Models\Author::count()); ?></span>
                </a>
                
                <div class="mt-6 mb-2 px-3 text-xs font-bold text-slate-500 uppercase">Monetization</div>
                
                <a href="<?php echo e(route('admin.ads.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 <?php echo e(request()->routeIs('admin.ads.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800'); ?>">
                    <i class="fas fa-ad w-5"></i>
                    <span class="text-sm font-medium">Ads</span>
                    <span class="ml-auto bg-slate-700 text-slate-300 text-xs px-2 py-0.5 rounded-full"><?php echo e(\App\Models\Ad::count()); ?></span>
                </a>
                
                <div class="mt-6 mb-2 px-3 text-xs font-bold text-slate-500 uppercase">Settings</div>
                
                <a href="<?php echo e(route('admin.settings.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800'); ?>">
                    <i class="fas fa-cog w-5"></i>
                    <span class="text-sm font-medium">Site Settings</span>
                </a>
            </nav>
            
            <!-- User Profile -->
            <div class="p-3 border-t border-slate-700 bg-slate-800">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate"><?php echo e(auth('admin')->user()->name); ?></p>
                        <p class="text-xs text-blue-400 font-medium">Administrator</p>
                    </div>
                    <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-slate-400 hover:text-red-400 transition-colors" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-slate-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center gap-4">
                        <h2 class="text-xl font-bold text-slate-800"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h2>
                        <div class="hidden md:flex items-center gap-2 text-sm text-slate-500">
                            <i class="fas fa-clock"></i>
                            <span id="current-time"></span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <a href="<?php echo e(route('admin.posts.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                            <i class="fas fa-plus mr-1"></i>New Post
                        </a>
                        <a href="<?php echo e(route('home')); ?>" target="_blank" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition text-sm font-medium">
                            <i class="fas fa-external-link-alt mr-1"></i>View Site
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto p-6">
                <?php if($errors->any()): ?>
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <h4 class="font-semibold text-red-800">Please fix the following errors:</h4>
                        </div>
                        <ul class="list-disc list-inside text-red-700 space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="text-sm"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-emerald-500 mr-2"></i>
                            <p class="font-semibold text-emerald-800"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Real-time Clock -->
    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: true, 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            const dateString = now.toLocaleDateString('en-US', { 
                weekday: 'short', 
                month: 'short', 
                day: 'numeric' 
            });
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = `${dateString}, ${timeString}`;
            }
        }
        
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/layouts/admin.blade.php ENDPATH**/ ?>