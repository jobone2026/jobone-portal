<div class="bg-white rounded-lg shadow-md p-1.5 hover:shadow-lg transition-shadow">
    @php
        // Assign colors based on post type
        $typeColors = [
            'jobs' => ['title' => 'text-blue-600', 'badge' => 'bg-blue-100 text-blue-700', 'link' => 'text-blue-600 hover:text-blue-800'],
            'admit_cards' => ['title' => 'text-purple-600', 'badge' => 'bg-purple-100 text-purple-700', 'link' => 'text-purple-600 hover:text-purple-800'],
            'results' => ['title' => 'text-green-600', 'badge' => 'bg-green-100 text-green-700', 'link' => 'text-green-600 hover:text-green-800'],
            'syllabus' => ['title' => 'text-orange-600', 'badge' => 'bg-orange-100 text-orange-700', 'link' => 'text-orange-600 hover:text-orange-800'],
            'blogs' => ['title' => 'text-indigo-600', 'badge' => 'bg-indigo-100 text-indigo-700', 'link' => 'text-indigo-600 hover:text-indigo-800'],
        ];
        $colors = $typeColors[$post->type] ?? ['title' => 'text-gray-600', 'badge' => 'bg-gray-100 text-gray-700', 'link' => 'text-gray-600 hover:text-gray-800'];
    @endphp
    
    <div class="flex justify-between items-start mb-0.5">
        <h3 class="text-xs font-semibold {{ $colors['title'] }} flex-1">
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="hover:opacity-80">
                {{ $post->title }}
            </a>
        </h3>
        @if ($post->isNew())
            <span class="bg-red-500 text-white px-1 py-0.5 rounded text-xs font-bold ml-1">NEW</span>
        @endif
    </div>
    
    <div class="flex flex-wrap gap-0.5 mb-0.5">
        <span class="text-xs {{ $colors['badge'] }} px-1 py-0.5 rounded">{{ ucfirst(str_replace('_', ' ', $post->type)) }}</span>
        @if ($post->category)
            <span class="text-xs bg-gray-100 text-gray-700 px-1 py-0.5 rounded">{{ $post->category->name }}</span>
        @endif
        @if ($post->state)
            <span class="text-xs bg-green-100 text-green-700 px-1 py-0.5 rounded">{{ $post->state->name }}</span>
        @endif
    </div>
    
    @if ($post->organization || $post->total_posts || $post->last_date)
        <div class="text-xs text-gray-600 space-y-0.5 mt-1">
            @if ($post->organization)
                <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="font-medium">{{ $post->organization }}</span>
                </div>
            @endif
            @if ($post->total_posts)
                <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>{{ $post->total_posts }} Vacancies</span>
                </div>
            @endif
            @if ($post->last_date)
                <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Last Date: {{ $post->last_date->format('d M Y') }}</span>
                </div>
            @endif
        </div>
    @endif
