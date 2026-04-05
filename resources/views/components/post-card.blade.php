<div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-blue-300 p-5">
    @php
        $daysRemaining = null;
        $isUrgent = false;
        if ($post->last_date) {
            $daysRemaining = now()->diffInDays($post->last_date, false);
            $isUrgent = $daysRemaining <= 5 && $daysRemaining >= 0;
        }
    @endphp
    
    <!-- TOP SECTION -->
    <div class="flex items-start gap-4 mb-4">
        <!-- LOGO -->
        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow">
            <span class="text-blue-600 text-xl font-bold">{{ strtoupper(substr($post->title, 0, 1)) }}</span>
        </div>
        
        <!-- TITLE -->
        <div class="flex-1">
            <h3 class="font-bold hover:text-blue-600" style="font-size: 18px; line-height: 1.3; color: #1e40af;">
                <a href="{{ route('posts.show', [$post->type, $post->slug]) }}">{{ $post->title }}</a>
            </h3>
            @if ($post->organization)
                <p class="text-sm text-gray-500">{{ $post->organization }}</p>
            @endif
            
            <!-- BADGES -->
            <div class="flex gap-2 mt-2 flex-wrap">
                @if($isUrgent)
                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs font-bold">URGENT</span>
                @endif
                <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs font-bold">NEW</span>
                @if ($post->state)
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs font-bold">{{ $post->state->name }}</span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- MIDDLE INFO -->
    <div class="grid grid-cols-2 gap-3 text-sm mb-4">
        <div class="flex items-center gap-2 text-gray-600">
            📅 <span>{{ $post->created_at->format('M d, Y') }}</span>
        </div>
        @if ($post->last_date)
            <div class="flex items-center gap-2 text-red-600 font-semibold">
                ⏳ <span>{{ $post->last_date->format('M d') }}</span>
            </div>
        @endif
        @if ($post->total_posts)
            <div class="flex items-center gap-2 text-gray-800 font-semibold">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
                {{ number_format($post->total_posts) }}
            </div>
        @endif
        <div class="flex items-center gap-2 text-gray-600">
            📍 {{ $post->state->name ?? 'All India' }}
        </div>
    </div>
    
    <!-- BOTTOM -->
    <div class="flex justify-between items-center border-t pt-4">
        <span class="text-xs text-gray-500">Last Date: <b>{{ $post->last_date ? $post->last_date->format('M d, Y') : '-' }}</b></span>
        <div class="flex gap-2">
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
               class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-bold rounded-lg shadow">Apply</a>
            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" 
               class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold rounded-lg shadow">Details</a>
        </div>
    </div>
</div>
