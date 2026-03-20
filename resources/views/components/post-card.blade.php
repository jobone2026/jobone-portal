<div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
    @php
        // Assign colors based on post type
        $typeColors = [
            'job' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'badge' => 'bg-blue-500', 'border' => 'border-blue-200'],
            'admit_card' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'badge' => 'bg-purple-500', 'border' => 'border-purple-200'],
            'result' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'badge' => 'bg-green-500', 'border' => 'border-green-200'],
            'answer_key' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'badge' => 'bg-yellow-500', 'border' => 'border-yellow-200'],
            'syllabus' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'badge' => 'bg-orange-500', 'border' => 'border-orange-200'],
            'blog' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'badge' => 'bg-indigo-500', 'border' => 'border-indigo-200'],
        ];
        $colors = $typeColors[$post->type] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'badge' => 'bg-gray-500', 'border' => 'border-gray-200'];
    @endphp
    
    <!-- Header with colored background -->
    <div class="{{ $colors['bg'] }} {{ $colors['border'] }} border-b px-3 py-2">
        <div class="flex items-start justify-between gap-2">
            <h3 class="text-sm font-bold {{ $colors['text'] }} flex-1 leading-tight">
                <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="hover:underline">
                    {{ $post->title }}
                </a>
            </h3>
            @if ($post->isNew())
                <span class="bg-red-500 text-white px-2 py-0.5 rounded-full text-xs font-bold flex-shrink-0 animate-pulse">NEW</span>
            @endif
        </div>
        
        <!-- Badges -->
        <div class="flex flex-wrap gap-1.5 mt-2">
            <span class="{{ $colors['badge'] }} text-white px-2 py-0.5 rounded-full text-xs font-semibold">
                {{ ucfirst(str_replace('_', ' ', $post->type)) }}
            </span>
            @if ($post->category)
                <span class="bg-gray-600 text-white px-2 py-0.5 rounded-full text-xs font-medium">
                    {{ $post->category->name }}
                </span>
            @endif
            @if ($post->state)
                <span class="bg-green-600 text-white px-2 py-0.5 rounded-full text-xs font-medium">
                    📍 {{ $post->state->name }}
                </span>
            @endif
        </div>
    </div>
    
    <!-- Content with key details -->
    <div class="px-3 py-2.5 space-y-2">
        @if ($post->organization)
            <div class="flex items-center gap-2 text-sm">
                <div class="w-8 h-8 {{ $colors['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-xs text-gray-500 font-medium">Organization</div>
                    <div class="text-sm font-bold text-gray-800">{{ $post->organization }}</div>
                </div>
            </div>
        @endif
        
        <!-- Vacancies and Last Date in a grid -->
        @if ($post->total_posts || $post->last_date)
            <div class="grid grid-cols-2 gap-2">
                @if ($post->total_posts)
                    <div class="bg-blue-50 rounded-lg p-2 border border-blue-100">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <div>
                                <div class="text-xs text-blue-600 font-medium">Vacancies</div>
                                <div class="text-sm font-bold text-blue-800">{{ number_format($post->total_posts) }}</div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if ($post->last_date)
                    <div class="bg-red-50 rounded-lg p-2 border border-red-100">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <div class="text-xs text-red-600 font-medium">Last Date</div>
                                <div class="text-xs font-bold text-red-800">{{ $post->last_date->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        
        <!-- View Details Button -->
        <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
           class="block w-full text-center {{ $colors['badge'] }} text-white py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
            View Details →
        </a>
    </div>
</div>
