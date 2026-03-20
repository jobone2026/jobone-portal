<div class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100 hover:border-blue-300 relative group">
    @php
        // Assign colors based on post type
        $typeColors = [
            'job' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'badge' => 'bg-blue-500', 'border' => 'border-blue-200', 'gradient' => 'from-blue-500 to-blue-600'],
            'admit_card' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'badge' => 'bg-purple-500', 'border' => 'border-purple-200', 'gradient' => 'from-purple-500 to-purple-600'],
            'result' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'badge' => 'bg-green-500', 'border' => 'border-green-200', 'gradient' => 'from-green-500 to-green-600'],
            'answer_key' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'badge' => 'bg-yellow-500', 'border' => 'border-yellow-200', 'gradient' => 'from-yellow-500 to-yellow-600'],
            'syllabus' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'badge' => 'bg-orange-500', 'border' => 'border-orange-200', 'gradient' => 'from-orange-500 to-orange-600'],
            'blog' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'badge' => 'bg-indigo-500', 'border' => 'border-indigo-200', 'gradient' => 'from-indigo-500 to-indigo-600'],
        ];
        $colors = $typeColors[$post->type] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'badge' => 'bg-gray-500', 'border' => 'border-gray-200', 'gradient' => 'from-gray-500 to-gray-600'];
        
        // Calculate days remaining
        $daysRemaining = null;
        $isUrgent = false;
        if ($post->last_date) {
            $daysRemaining = now()->diffInDays($post->last_date, false);
            $isUrgent = $daysRemaining <= 7 && $daysRemaining >= 0;
        }
    @endphp
    
    <!-- Urgent Badge (Top Right Corner) -->
    @if ($isUrgent)
        <div class="absolute top-2 right-2 z-10">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                {{ $daysRemaining }} {{ $daysRemaining == 1 ? 'Day' : 'Days' }} Left
            </div>
        </div>
    @endif
    
    <!-- Header with colored background -->
    <div class="{{ $colors['bg'] }} {{ $colors['border'] }} border-b px-4 py-3">
        <div class="flex items-start justify-between gap-2">
            <h3 class="text-sm font-bold {{ $colors['text'] }} flex-1 leading-tight line-clamp-2">
                <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="hover:underline transition-colors">
                    {{ $post->title }}
                </a>
            </h3>
            @if ($post->isNew() && !$isUrgent)
                <span class="bg-gradient-to-r from-green-500 to-green-600 text-white px-2 py-0.5 rounded-full text-xs font-bold flex-shrink-0 animate-pulse shadow-md">
                    ✨ NEW
                </span>
            @endif
        </div>
        
        <!-- Badges -->
        <div class="flex flex-wrap gap-1.5 mt-2.5">
            <span class="{{ $colors['badge'] }} text-white px-2.5 py-1 rounded-full text-xs font-semibold shadow-sm">
                {{ ucfirst(str_replace('_', ' ', $post->type)) }}
            </span>
            @if ($post->category)
                <span class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-2.5 py-1 rounded-full text-xs font-medium shadow-sm">
                    {{ $post->category->name }}
                </span>
            @endif
            @if ($post->state)
                <span class="bg-gradient-to-r from-green-600 to-green-700 text-white px-2.5 py-1 rounded-full text-xs font-medium shadow-sm">
                    📍 {{ $post->state->name }}
                </span>
            @endif
        </div>
    </div>
    
    <!-- Content with key details -->
    <div class="px-4 py-3 space-y-3">
        @if ($post->organization)
            <div class="flex items-center gap-3 text-sm bg-gray-50 rounded-lg p-2.5 border border-gray-100">
                <div class="w-10 h-10 {{ $colors['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                    <svg class="w-5 h-5 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Organization</div>
                    <div class="text-sm font-bold text-gray-800 truncate">{{ $post->organization }}</div>
                </div>
            </div>
        @endif
        
        <!-- Vacancies and Last Date in a grid -->
        @if ($post->total_posts || $post->last_date)
            <div class="grid grid-cols-2 gap-2.5">
                @if ($post->total_posts)
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-3 border-2 border-blue-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs text-blue-600 font-semibold uppercase tracking-wide">Vacancies</div>
                                <div class="text-base font-bold text-blue-900">{{ number_format($post->total_posts) }}</div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if ($post->last_date)
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-3 border-2 {{ $isUrgent ? 'border-red-400 animate-pulse' : 'border-red-200' }} shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs text-red-600 font-semibold uppercase tracking-wide">Last Date</div>
                                <div class="text-xs font-bold text-red-900">{{ $post->last_date->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        
        <!-- View Details Button -->
        <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
           class="block w-full text-center bg-gradient-to-r {{ $colors['gradient'] }} text-white py-2.5 rounded-lg text-sm font-bold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 shadow-md">
            <span class="flex items-center justify-center gap-2">
                View Full Details
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </span>
        </a>
    </div>
</div>
