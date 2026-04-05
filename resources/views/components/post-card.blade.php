<div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-blue-300 p-5">
    @php
        // Calculate days remaining
        $daysRemaining = null;
        $isUrgent = false;
        if ($post->last_date) {
            $daysRemaining = now()->diffInDays($post->last_date, false);
            $isUrgent = $daysRemaining <= 7 && $daysRemaining >= 0;
        }
    @endphp
    
    <!-- Top Section: Logo, Title, and Urgent Badge -->
    <div class="flex gap-4 mb-4">
        <!-- Logo -->
        <div class="flex-shrink-0">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-50 to-blue-100 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                @if($post->type === 'job')
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                @elseif($post->type === 'result')
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @elseif($post->type === 'admit_card')
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                    </svg>
                @else
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                @endif
            </div>
        </div>
        
        <!-- Title and Urgent Badge -->
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800 leading-tight mb-2 hover:text-blue-600 transition-colors">
                        <a href="{{ route('posts.show', [$post->type, $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    @if ($post->organization)
                        <p class="text-base text-gray-600">{{ $post->organization }}</p>
                    @endif
                </div>
                
                @if ($isUrgent)
                    <span class="flex-shrink-0 bg-gradient-to-r from-red-400 to-red-500 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        URGENT
                    </span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Meta Info Row -->
    <div class="flex flex-wrap items-center gap-3 mb-4">
        <span class="flex items-center gap-2 text-gray-600 bg-gray-50 px-3 py-2 rounded-lg">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ $post->created_at->format('M d, Y') }}
        </span>
        
        @if ($post->state)
            <span class="flex items-center gap-2 text-blue-700 bg-blue-50 px-3 py-2 rounded-lg font-medium">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ $post->state->name }}
            </span>
        @endif
        
        @if ($post->last_date)
            <span class="flex items-center gap-2 {{ $isUrgent ? 'text-red-700 bg-red-50' : 'text-teal-700 bg-teal-50' }} px-3 py-2 rounded-lg font-medium">
                <svg class="w-5 h-5 {{ $isUrgent ? 'text-red-600' : 'text-teal-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $post->last_date->format('M d') }} ▼
            </span>
        @endif
    </div>
    
    <!-- Bottom Row: Salary/Vacancies and Action Buttons -->
    <div class="flex items-center justify-between gap-4 pt-4 border-t border-gray-100">
        <div class="flex items-center gap-6">
            @if ($post->total_posts)
                <div class="text-lg font-bold text-gray-800">
                    ₹ {{ number_format($post->total_posts) }} <span class="text-sm text-gray-500 font-normal">/posts</span>
                </div>
            @endif
            
            @if ($post->last_date)
                <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm">Last Date: <span class="font-semibold text-gray-800">{{ $post->last_date->format('M d, Y') }}</span></span>
                </div>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-3 flex-shrink-0">
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
               class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-xl text-base font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Apply Now
            </a>
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
               class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl text-base font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                View Details
            </a>
        </div>
    </div>
</div>
