<div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 hover:border-blue-400 relative group p-5">
    @php
        // Assign colors based on post type
        $typeColors = [
            'job' => ['badge' => 'from-blue-500 to-blue-600', 'icon_bg' => 'from-blue-50 to-blue-100', 'icon_border' => 'border-blue-300', 'icon_color' => 'text-blue-600'],
            'admit_card' => ['badge' => 'from-purple-500 to-purple-600', 'icon_bg' => 'from-purple-50 to-purple-100', 'icon_border' => 'border-purple-300', 'icon_color' => 'text-purple-600'],
            'result' => ['badge' => 'from-green-500 to-green-600', 'icon_bg' => 'from-green-50 to-green-100', 'icon_border' => 'border-green-300', 'icon_color' => 'text-green-600'],
            'answer_key' => ['badge' => 'from-amber-500 to-amber-600', 'icon_bg' => 'from-amber-50 to-amber-100', 'icon_border' => 'border-amber-300', 'icon_color' => 'text-amber-600'],
            'syllabus' => ['badge' => 'from-orange-500 to-orange-600', 'icon_bg' => 'from-orange-50 to-orange-100', 'icon_border' => 'border-orange-300', 'icon_color' => 'text-orange-600'],
            'blog' => ['badge' => 'from-indigo-500 to-indigo-600', 'icon_bg' => 'from-indigo-50 to-indigo-100', 'icon_border' => 'border-indigo-300', 'icon_color' => 'text-indigo-600'],
        ];
        $colors = $typeColors[$post->type] ?? ['badge' => 'from-gray-500 to-gray-600', 'icon_bg' => 'from-gray-50 to-gray-100', 'icon_border' => 'border-gray-300', 'icon_color' => 'text-gray-600'];
        
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
            <div class="w-16 h-16 bg-gradient-to-br {{ $colors['icon_bg'] }} rounded-2xl flex items-center justify-center border-2 {{ $colors['icon_border'] }} shadow-md group-hover:scale-110 transition-transform duration-300">
                @if($post->type === 'job')
                    <svg class="w-9 h-9 {{ $colors['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                @elseif($post->type === 'result')
                    <svg class="w-9 h-9 {{ $colors['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @elseif($post->type === 'admit_card')
                    <svg class="w-9 h-9 {{ $colors['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                    </svg>
                @else
                    <svg class="w-9 h-9 {{ $colors['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                @endif
            </div>
        </div>
        
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <!-- Title and Badges -->
            <div class="flex items-start justify-between gap-3 mb-2">
                <h3 class="text-base font-bold text-gray-800 leading-snug flex-1 hover:text-blue-600 transition-colors">
                    <a href="{{ route('posts.show', [$post->type, $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                </h3>
                <div class="flex gap-2 flex-shrink-0">
                    @if ($post->isNew())
                        <span class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-md">
                            ✨ NEW
                        </span>
                    @endif
                    @if ($isUrgent)
                        <span class="bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-md animate-pulse">
                            🔥 URGENT
                        </span>
                    @endif
                    <span class="bg-gradient-to-r {{ $colors['badge'] }} text-white px-3 py-1 rounded-lg text-xs font-bold shadow-md uppercase">
                        {{ str_replace('_', ' ', $post->type) }}
                    </span>
                </div>
            </div>
            
            <!-- Organization -->
            @if ($post->organization)
                <p class="text-sm text-gray-600 mb-3 font-medium">{{ $post->organization }}</p>
            @endif
            
            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-3">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $post->created_at->format('M d, Y') }}
                </span>
                @if ($post->state)
                    <span class="flex items-center gap-1.5 bg-blue-50 px-2 py-1 rounded-md">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-blue-700 font-medium">{{ $post->state->name }}</span>
                    </span>
                @endif
                @if ($post->category)
                    <span class="flex items-center gap-1.5 bg-purple-50 px-2 py-1 rounded-md">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span class="text-purple-700 font-medium">{{ $post->category->name }}</span>
                    </span>
                @endif
            </div>
            
            <!-- Bottom Row: Salary/Vacancies and Buttons -->
            <div class="flex items-center justify-between gap-3 pt-3 border-t border-gray-200">
                <div class="flex items-center gap-5 text-sm">
                    @if ($post->total_posts)
                        <span class="font-bold text-gray-700 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="text-gray-500">Posts:</span> {{ number_format($post->total_posts) }}
                        </span>
                    @endif
                    @if ($post->last_date)
                        <span class="font-bold {{ $isUrgent ? 'text-red-600' : 'text-gray-700' }} flex items-center gap-1.5">
                            <svg class="w-4 h-4 {{ $isUrgent ? 'text-red-500' : 'text-orange-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-500">Last:</span> {{ $post->last_date->format('M d, Y') }}
                        </span>
                    @endif
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-2 flex-shrink-0">
                    <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
                       class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Apply Now
                    </a>
                    <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
                       class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center gap-2">
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
