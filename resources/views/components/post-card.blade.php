<div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-blue-400 overflow-hidden">
    @php
        $daysRemaining = null;
        $isUrgent = false;
        if ($post->last_date) {
            $daysRemaining = now()->diffInDays($post->last_date, false);
            $isUrgent = $daysRemaining <= 5 && $daysRemaining >= 0;
        }
    @endphp
    
    <!-- Header with Badges -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-2 border-b border-blue-100">
        <div class="flex items-center gap-2 flex-wrap">
            @if($isUrgent)
                <span class="bg-red-500 text-white px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                    <i class="fa-solid fa-exclamation-circle"></i> URGENT
                </span>
            @endif
            <span class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                <i class="fa-solid fa-star"></i> NEW
            </span>
            @if ($post->state)
                <span class="bg-blue-500 text-white px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                    <i class="fa-solid fa-map-marker-alt"></i> {{ $post->state->name }}
                </span>
            @else
                <span class="bg-purple-500 text-white px-2 py-0.5 rounded-full text-xs font-bold flex items-center gap-1">
                    <i class="fa-solid fa-globe"></i> All India
                </span>
            @endif
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="p-4">
        <!-- Title -->
        <h3 class="font-bold mb-3 transition-colors" style="font-size: 16px; line-height: 1.4; color: #1f2937;">
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="block hover:text-blue-600" style="color: inherit; text-decoration: none;">
                {{ $post->title }}
            </a>
        </h3>
        
        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <!-- Posted Date -->
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <i class="fa-solid fa-calendar text-blue-500"></i>
                <div>
                    <div class="text-xs text-gray-500">Posted</div>
                    <div class="font-semibold">{{ $post->created_at->format('d M Y') }}</div>
                </div>
            </div>
            
            <!-- Last Date -->
            @if ($post->last_date)
                <div class="flex items-center gap-2 text-sm {{ $isUrgent ? 'text-red-600' : 'text-orange-600' }}">
                    <i class="fa-solid fa-clock {{ $isUrgent ? 'animate-pulse' : '' }}"></i>
                    <div>
                        <div class="text-xs">Last Date</div>
                        <div class="font-bold">{{ $post->last_date->format('d M Y') }}</div>
                    </div>
                </div>
            @endif
            
            <!-- Vacancies -->
            @if ($post->total_posts)
                <div class="flex items-center gap-2 text-sm text-green-700">
                    <i class="fa-solid fa-briefcase text-green-600"></i>
                    <div>
                        <div class="text-xs text-gray-500">Vacancies</div>
                        <div class="font-bold">{{ number_format($post->total_posts) }}</div>
                    </div>
                </div>
            @endif
            
            <!-- Category -->
            @if ($post->category)
                <div class="flex items-center gap-2 text-sm text-purple-700">
                    <i class="fa-solid fa-tag text-purple-600"></i>
                    <div>
                        <div class="text-xs text-gray-500">Category</div>
                        <div class="font-semibold">{{ $post->category->name }}</div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-2 pt-3 border-t border-gray-100">
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
               class="flex-1 px-4 py-2.5 text-white text-sm font-bold rounded-lg shadow-md hover:shadow-lg transition-all text-center flex items-center justify-center gap-2"
               style="background: #3b82f6 !important; color: #ffffff !important; text-decoration: none !important;"
               onmouseover="this.style.background='#2563eb'" 
               onmouseout="this.style.background='#3b82f6'">
                <i class="fa-solid fa-info-circle"></i>
                View Details
            </a>
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}#apply" 
               class="flex-1 px-4 py-2.5 text-white text-sm font-bold rounded-lg shadow-md hover:shadow-lg transition-all text-center flex items-center justify-center gap-2"
               style="background: #10b981 !important; color: #ffffff !important; text-decoration: none !important;"
               onmouseover="this.style.background='#059669'" 
               onmouseout="this.style.background='#10b981'">
                <i class="fa-solid fa-paper-plane"></i>
                Apply Now
            </a>
        </div>
    </div>
</div>
