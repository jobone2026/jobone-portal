@props(['currentCategory' => null, 'currentState' => null, 'currentType' => null, 'showTypeFilter' => true])

@php
    $categories = \App\Models\Category::withCount('posts')
        ->orderBy('posts_count', 'desc')
        ->take(20)
        ->get();
    
    $states = \App\Models\State::withCount('posts')
        ->orderBy('posts_count', 'desc')
        ->get();
    
    $postTypes = [
        'all' => ['label' => 'All Posts', 'icon' => 'fa-list'],
        'job' => ['label' => 'Jobs', 'icon' => 'fa-briefcase'],
        'admit_card' => ['label' => 'Admit Cards', 'icon' => 'fa-id-card'],
        'result' => ['label' => 'Results', 'icon' => 'fa-chart-bar'],
        'answer_key' => ['label' => 'Answer Keys', 'icon' => 'fa-key'],
        'syllabus' => ['label' => 'Syllabus', 'icon' => 'fa-book'],
        'blog' => ['label' => 'Blogs', 'icon' => 'fa-pen-fancy'],
    ];
@endphp

<div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-b-2 border-indigo-200 shadow-lg sticky top-[72px] md:top-[88px] z-40 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 py-5">
        <!-- Modern Filter Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform">
                    <i class="fas fa-sliders-h text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-gray-800 tracking-tight">Smart Filters</h3>
                    <p class="text-xs text-gray-500">Find exactly what you need</p>
                </div>
            </div>
            @if($currentCategory || $currentState || ($currentType && $currentType !== 'all'))
                <button onclick="clearFilters()" class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition-all flex items-center gap-2">
                    <i class="fas fa-redo-alt"></i>
                    Reset All
                </button>
            @endif
        </div>

        <!-- Active Filters Display - Modern Pills -->
        @if($currentCategory || $currentState || ($currentType && $currentType !== 'all'))
        <div class="mb-5 flex flex-wrap gap-2 items-center">
            <span class="text-xs font-bold text-gray-600 bg-white px-3 py-1.5 rounded-lg shadow-sm">Active:</span>
            
            @if($currentCategory)
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transform hover:scale-105 transition-all">
                <i class="fas fa-folder"></i>
                {{ $currentCategory->name }}
                <a href="{{ buildFilterUrl(null, $currentState, $currentType) }}" class="ml-1 hover:bg-white hover:bg-opacity-20 rounded-full p-1 transition-all">
                    <i class="fas fa-times text-xs"></i>
                </a>
            </span>
            @endif
            
            @if($currentState)
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transform hover:scale-105 transition-all">
                <i class="fas fa-map-marker-alt"></i>
                {{ $currentState->name }}
                <a href="{{ buildFilterUrl($currentCategory, null, $currentType) }}" class="ml-1 hover:bg-white hover:bg-opacity-20 rounded-full p-1 transition-all">
                    <i class="fas fa-times text-xs"></i>
                </a>
            </span>
            @endif
            
            @if($currentType && $currentType !== 'all')
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transform hover:scale-105 transition-all">
                <i class="fas {{ $postTypes[$currentType]['icon'] ?? 'fa-file' }}"></i>
                {{ $postTypes[$currentType]['label'] ?? ucfirst($currentType) }}
                <a href="{{ buildFilterUrl($currentCategory, $currentState, 'all') }}" class="ml-1 hover:bg-white hover:bg-opacity-20 rounded-full p-1 transition-all">
                    <i class="fas fa-times text-xs"></i>
                </a>
            </span>
            @endif
        </div>
        @endif

        <!-- Modern Filter Options -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Category Filter - Modern Design -->
            <div class="relative group">
                <label class="block text-xs font-bold text-gray-700 mb-2 flex items-center gap-2">
                    <div class="w-6 h-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-folder text-white text-xs"></i>
                    </div>
                    Category
                </label>
                <div class="relative">
                    <select onchange="applyFilter('category', this.value)" 
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl text-sm font-semibold text-gray-700 focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all appearance-none cursor-pointer hover:border-blue-400 shadow-sm hover:shadow-md">
                        <option value="">🔍 All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ $currentCategory && $currentCategory->id === $category->id ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->posts_count }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fas fa-chevron-down text-blue-500"></i>
                    </div>
                </div>
            </div>

            <!-- State Filter - Modern Design -->
            <div class="relative group">
                <label class="block text-xs font-bold text-gray-700 mb-2 flex items-center gap-2">
                    <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-emerald-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-white text-xs"></i>
                    </div>
                    State
                </label>
                <div class="relative">
                    <select onchange="applyFilter('state', this.value)" 
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl text-sm font-semibold text-gray-700 focus:ring-4 focus:ring-green-200 focus:border-green-500 transition-all appearance-none cursor-pointer hover:border-green-400 shadow-sm hover:shadow-md">
                        <option value="">📍 All States</option>
                        @foreach($states as $state)
                            <option value="{{ $state->slug }}" {{ $currentState && $currentState->id === $state->id ? 'selected' : '' }}>
                                {{ $state->name }} ({{ $state->posts_count }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fas fa-chevron-down text-green-500"></i>
                    </div>
                </div>
            </div>

            <!-- Post Type Filter - Modern Design -->
            @if($showTypeFilter)
            <div class="relative group">
                <label class="block text-xs font-bold text-gray-700 mb-2 flex items-center gap-2">
                    <div class="w-6 h-6 bg-gradient-to-br from-purple-400 to-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-list text-white text-xs"></i>
                    </div>
                    Post Type
                </label>
                <div class="relative">
                    <select onchange="applyFilter('type', this.value)" 
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl text-sm font-semibold text-gray-700 focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition-all appearance-none cursor-pointer hover:border-purple-400 shadow-sm hover:shadow-md">
                        @foreach($postTypes as $typeKey => $typeData)
                            <option value="{{ $typeKey }}" {{ $currentType === $typeKey ? 'selected' : '' }}>
                                {{ $typeData['label'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fas fa-chevron-down text-purple-500"></i>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function applyFilter(filterType, value) {
    const currentUrl = new URL(window.location.href);
    const params = new URLSearchParams(currentUrl.search);
    
    // Get current filter values
    let category = '{{ $currentCategory ? $currentCategory->slug : '' }}';
    let state = '{{ $currentState ? $currentState->slug : '' }}';
    let type = '{{ $currentType ?? 'all' }}';
    
    // Update the changed filter
    if (filterType === 'category') category = value;
    if (filterType === 'state') state = value;
    if (filterType === 'type') type = value;
    
    // Build the new URL
    let url = buildFilterUrlJs(category, state, type);
    window.location.href = url;
}

function buildFilterUrlJs(category, state, type) {
    // Priority: Category + State + Type combination
    if (category && state && type && type !== 'all') {
        return `/filter/${type}/${category}/${state}`;
    }
    if (category && state) {
        return `/filter/category/${category}/state/${state}`;
    }
    if (category && type && type !== 'all') {
        return `/filter/${type}/category/${category}`;
    }
    if (state && type && type !== 'all') {
        return `/filter/${type}/state/${state}`;
    }
    if (category) {
        return `/category/${category}`;
    }
    if (state) {
        return `/state/${state}`;
    }
    if (type && type !== 'all') {
        return `/${type === 'job' ? 'jobs' : type === 'admit_card' ? 'admit-cards' : type === 'answer_key' ? 'answer-keys' : type}`;
    }
    return '/all-posts';
}

function clearFilters() {
    window.location.href = '/all-posts';
}
</script>

@php
function buildFilterUrl($category, $state, $type) {
    // Priority: Category + State + Type combination
    if ($category && $state && $type && $type !== 'all') {
        return "/filter/{$type}/{$category->slug}/{$state->slug}";
    }
    if ($category && $state) {
        return "/filter/category/{$category->slug}/state/{$state->slug}";
    }
    if ($category && $type && $type !== 'all') {
        return "/filter/{$type}/category/{$category->slug}";
    }
    if ($state && $type && $type !== 'all') {
        return "/filter/{$type}/state/{$state->slug}";
    }
    if ($category) {
        return route('categories.show', $category);
    }
    if ($state) {
        return route('states.show', $state);
    }
    if ($type && $type !== 'all') {
        $typeRoutes = [
            'job' => 'posts.jobs',
            'admit_card' => 'posts.admit-cards',
            'result' => 'posts.results',
            'answer_key' => 'posts.answer-keys',
            'syllabus' => 'posts.syllabus',
            'blog' => 'posts.blogs',
        ];
        return route($typeRoutes[$type] ?? 'posts.all');
    }
    return route('posts.all');
}
@endphp
