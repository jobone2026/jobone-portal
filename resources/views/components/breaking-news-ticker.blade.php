@php
    $breakingNews = \App\Models\Post::published()
        ->where('is_featured', true)
        ->latest()
        ->limit(10)
        ->get();
@endphp

<div class="bg-red-600 text-white py-2 sticky top-0 z-50 shadow-lg overflow-hidden">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex items-center gap-3">
            <!-- Breaking News Label -->
            <div class="flex-shrink-0 flex items-center gap-2 font-bold text-sm md:text-base whitespace-nowrap">
                <i class="fas fa-exclamation-circle animate-pulse"></i>
                <span>BREAKING</span>
            </div>
            
            <!-- News Ticker -->
            <div class="flex-1 overflow-hidden">
                <div class="ticker-container">
                    <div class="ticker-content">
                        @forelse($breakingNews as $news)
                            <span class="ticker-item">
                                <a href="{{ route('posts.show', [$news->type, $news->slug]) }}" 
                                   class="hover:text-yellow-200 transition inline-block">
                                    {{ $news->title }}
                                </a>
                                <span class="mx-4">•</span>
                            </span>
                        @empty
                            <span class="ticker-item">No breaking news available</span>
                        @endforelse
                        
                        <!-- Duplicate for continuous scroll -->
                        @forelse($breakingNews as $news)
                            <span class="ticker-item">
                                <a href="{{ route('posts.show', [$news->type, $news->slug]) }}" 
                                   class="hover:text-yellow-200 transition inline-block">
                                    {{ $news->title }}
                                </a>
                                <span class="mx-4">•</span>
                            </span>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ticker-container {
        overflow: hidden;
        width: 100%;
    }
    
    .ticker-content {
        display: flex;
        animation: scroll-left 60s linear infinite;
        white-space: nowrap;
    }
    
    .ticker-item {
        display: inline-block;
        padding: 0 1rem;
        font-size: 0.875rem;
    }
    
    @keyframes scroll-left {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }
    
    /* Pause on hover */
    .ticker-container:hover .ticker-content {
        animation-play-state: paused;
    }
    
    /* Mobile optimization */
    @media (max-width: 640px) {
        .ticker-item {
            padding: 0 0.5rem;
            font-size: 0.75rem;
        }
        
        .ticker-content {
            animation: scroll-left 40s linear infinite;
        }
    }
</style>
