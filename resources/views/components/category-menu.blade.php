@php
    $categories = \App\Models\Category::withCount('posts')
        ->orderBy('posts_count', 'desc')
        ->take(12)
        ->get();
    
    // Icon mapping based on category name keywords
    function getCategoryIcon($categoryName) {
        $name = strtolower($categoryName);
        
        if (str_contains($name, 'ssc')) return ['icon' => 'fa-file-alt', 'color' => 'blue'];
        if (str_contains($name, 'railway') || str_contains($name, 'rrb')) return ['icon' => 'fa-train', 'color' => 'teal'];
        if (str_contains($name, 'bank')) return ['icon' => 'fa-university', 'color' => 'green'];
        if (str_contains($name, 'upsc')) return ['icon' => 'fa-landmark', 'color' => 'indigo'];
        if (str_contains($name, 'police') || str_contains($name, 'constable')) return ['icon' => 'fa-shield-alt', 'color' => 'red'];
        if (str_contains($name, 'defence') || str_contains($name, 'army') || str_contains($name, 'navy') || str_contains($name, 'air force')) return ['icon' => 'fa-fighter-jet', 'color' => 'slate'];
        if (str_contains($name, 'teaching') || str_contains($name, 'teacher') || str_contains($name, 'education')) return ['icon' => 'fa-chalkboard-teacher', 'color' => 'purple'];
        if (str_contains($name, 'psc') || str_contains($name, 'state')) return ['icon' => 'fa-map-marked-alt', 'color' => 'orange'];
        if (str_contains($name, 'admit')) return ['icon' => 'fa-id-card', 'color' => 'cyan'];
        if (str_contains($name, 'result')) return ['icon' => 'fa-chart-line', 'color' => 'pink'];
        if (str_contains($name, 'answer') || str_contains($name, 'key')) return ['icon' => 'fa-key', 'color' => 'amber'];
        if (str_contains($name, 'syllabus')) return ['icon' => 'fa-book', 'color' => 'lime'];
        if (str_contains($name, 'clerk') || str_contains($name, 'assistant')) return ['icon' => 'fa-user-tie', 'color' => 'violet'];
        if (str_contains($name, 'engineer')) return ['icon' => 'fa-cogs', 'color' => 'emerald'];
        if (str_contains($name, 'medical') || str_contains($name, 'nurse') || str_contains($name, 'doctor')) return ['icon' => 'fa-stethoscope', 'color' => 'rose'];
        
        // Default
        return ['icon' => 'fa-briefcase', 'color' => 'gray'];
    }
@endphp

@if ($categories->count() > 0)
<div class="bg-white border-b border-gray-200 shadow-sm sticky top-[72px] md:top-[88px] z-40">
    <div class="max-w-7xl mx-auto">
        <div class="overflow-x-auto scrollbar-hide">
            <div class="flex gap-2 px-4 py-3 min-w-max">
                @foreach ($categories as $category)
                    @php
                        $iconData = getCategoryIcon($category->name);
                        $icon = $iconData['icon'];
                        $color = $iconData['color'];
                        
                        // Check if this category is currently active
                        $isActive = false;
                        if (request()->route() && request()->route()->getName() === 'categories.show') {
                            $routeCategory = request()->route('category');
                            $isActive = $routeCategory && is_object($routeCategory) && $routeCategory->id === $category->id;
                        }
                    @endphp
                    <a href="{{ route('categories.show', $category) }}" 
                       class="flex flex-col items-center justify-center min-w-[80px] p-3 rounded-xl border-2 transition-all group flex-shrink-0 {{ $isActive ? 'bg-'.$color.'-600 border-'.$color.'-700 shadow-lg scale-105' : 'bg-'.$color.'-50 hover:bg-'.$color.'-100 border-'.$color.'-200 hover:border-'.$color.'-400' }}">
                        <i class="fas {{ $icon }} text-2xl mb-1 group-hover:scale-110 transition-transform {{ $isActive ? 'text-white' : 'text-'.$color.'-600' }}"></i>
                        <span class="text-xs font-semibold text-center line-clamp-2 leading-tight {{ $isActive ? 'text-white' : 'text-gray-800' }}">{{ Str::limit($category->name, 15) }}</span>
                        <span class="text-xs font-bold mt-0.5 {{ $isActive ? 'text-white' : 'text-'.$color.'-600' }}">{{ $category->posts_count }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endif
