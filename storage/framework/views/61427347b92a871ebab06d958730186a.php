

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-2xl w-full text-center">
        <!-- 404 Icon -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full">
                <i class="fas fa-search text-6xl text-blue-600"></i>
            </div>
        </div>

        <!-- Error Message -->
        <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
        <p class="text-gray-600 mb-8">
            Sorry, we couldn't find the page you're looking for. It might have been moved or deleted.
        </p>

        <!-- Search Box -->
        <div class="mb-8">
            <form action="<?php echo e(route('search')); ?>" method="GET" class="max-w-md mx-auto">
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        name="q" 
                        value="<?php echo e(implode(' ', array_filter(explode('/', request()->path()), fn($word) => strlen($word) > 2 && !is_numeric($word)))); ?>"
                        placeholder="Search for jobs, admit cards, results..." 
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                        autofocus>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <a href="<?php echo e(route('posts.jobs')); ?>" class="p-6 bg-white border border-gray-200 rounded-lg hover:border-blue-600 hover:shadow-md transition">
                <i class="fas fa-briefcase text-3xl text-blue-600 mb-3"></i>
                <h3 class="font-semibold text-gray-800">Latest Jobs</h3>
                <p class="text-sm text-gray-600 mt-2">Browse government job notifications</p>
            </a>
            
            <a href="<?php echo e(route('posts.admit-cards')); ?>" class="p-6 bg-white border border-gray-200 rounded-lg hover:border-purple-600 hover:shadow-md transition">
                <i class="fas fa-id-card text-3xl text-purple-600 mb-3"></i>
                <h3 class="font-semibold text-gray-800">Admit Cards</h3>
                <p class="text-sm text-gray-600 mt-2">Download hall tickets</p>
            </a>
            
            <a href="<?php echo e(route('posts.results')); ?>" class="p-6 bg-white border border-gray-200 rounded-lg hover:border-green-600 hover:shadow-md transition">
                <i class="fas fa-chart-bar text-3xl text-green-600 mb-3"></i>
                <h3 class="font-semibold text-gray-800">Results</h3>
                <p class="text-sm text-gray-600 mt-2">Check exam results</p>
            </a>
        </div>

        <!-- Home Link -->
        <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
            <i class="fas fa-home"></i>
            Back to Homepage
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/errors/404.blade.php ENDPATH**/ ?>