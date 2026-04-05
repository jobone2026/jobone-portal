<div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 hover:border-blue-300 relative group p-4">
    @php
        // Assign colors based on post type
        $typeColors = [
            'job' => ['badge' => 'bg-blue-500', 'text' => 'text-blue-700'],
            'admit_card' => ['badge' => 'bg-purple-500', 'text' => 'text-purple-700'],
            'result' => ['badge' => 'bg-green-500', 'text' => 'text-green-700'],
            'answer_key' => ['badge' => 'bg-yellow-500', 'text' => 'text-yellow-700'],
            'syllabus' => ['badge' => 'bg-orange-500', 'text' => 'text-orange-700'],
            'blog' => ['badge' => 'bg-indigo-500', 'text' => 'text-indigo-700'],
        ];
        $colors = $typeColors[$post->type] ?? ['badge' => 'bg-gray-500', 'text' => 'text-gray-700'];
        
        // Calculate days remaining
        $daysRemaining = null;
        $isUrgent = false;
        if ($post->last_date) {
            $daysRemaining = now()->diffInDays($post->last_date, false);
            $isUrgent = $daysRemaining <= 7 && $daysRemaining >= 0;
        }
    @endphp
    
    <div class="flex gap-4">
        <!-- Logo/Icon -->
        <div class="flex-shrink-0">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center border-2 border-blue-200 shadow-sm">
                @if($post->type === 'job')
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                @elseif($post->type === 'result')
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @elseif($post->type === 'admit_card')
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                    </svg>
                @else
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                @endif
            </div>
        </div>
        
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <!-- Title and Badges -->
            <div class="flex items-start justify-between gap-2 mb-2">
                <h3 class="text-base font-bold text-gray-900 leading-tight flex-1">
                    <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="hover:text-blue-600 transition-colors">
                        {{ $post->title }}
                    </a>
                </h3>
                <div class="flex gap-1.5 flex-shrink-0">
                    @if ($post->isNew())
                        <span class="bg-green-500 text-white px-2.5 py-1 rounded-md text-xs font-bold shadow-sm">
                            ✨ NEW
                        </span>
                    @endif
                    @if ($isUrgent)
                        <span class="bg-red-500 text-white px-2.5 py-1 rounded-md text-xs font-bold shadow-sm animate-pulse">
                            🔥 URGENT
                        </span>
                    @endif
                    <span class="{{ $colors['badge'] }} text-white px-2.5 py-1 rounded-md text-xs font-bold shadow-sm uppercase">
                        {{ str_replace('_', ' ', $post->type) }}
                    </span>
                </div>
            </div>
            
            <!-- Organization -->
            @if ($post->organization)
                <p class="text-sm text-gray-600 mb-3">{{ $post->organization }}</p>
            @endif
            
            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 mb-3">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $post->created_at->format('M d, Y') }}
                </span>
                @if ($post->state)
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $post->state->name }}
                    </span>
                @endif
                @if ($post->category)
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        {{ $post->category->name }}
                    </span>
                @endif
            </div>
            
            <!-- Bottom Row: Salary/Vacancies and Buttons -->
            <div class="flex items-center justify-between gap-3 pt-3 border-t border-gray-100">
                <div class="flex items-center gap-4 text-sm">
                    @if ($post->total_posts)
                        <span class="font-bold text-gray-900">
                            <span class="text-gray-600">Vacancies:</span> {{ number_format($post->total_posts) }}
                        </span>
                    @endif
                    @if ($post->last_date)
                        <span class="font-bold {{ $isUrgent ? 'text-red-600' : 'text-gray-900' }}">
                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Last Date: {{ $post->last_date->format('M d, Y') }}
                        </span>
                    @endif
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-2 flex-shrink-0">
                    <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
                       class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-bold transition-all shadow-sm hover:shadow-md">
                        Apply Now
                    </a>
                    <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
                       class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-bold transition-all shadow-sm hover:shadow-md flex items-center gap-1">
                        View Details
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
