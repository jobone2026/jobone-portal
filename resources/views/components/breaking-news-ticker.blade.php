@php
    $latestJobs = \App\Models\Post::published()
        ->ofType('job')
        ->latest()
        ->limit(10)
        ->get();
@endphp

<div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-2 sticky top-0 z-50 shadow-md overflow-hidden">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex items-center gap-2 md:gap-3">
            <!-- Latest Jobs Label -->
            <div class="flex-shrink-0 flex items-center gap-2 font-bold text-sm md:text-base whitespace-nowrap bg-white bg-opacity-20 px-3 py-1 rounded">
                <i class="fas fa-briefcase"></i>
                <span>LATEST JOBS</span>
            </div>
            
            <!-- Jobs Ticker -->
            <div class="flex-1 overflow-hidden">
                <div class="ticker-container">
                    <div class="ticker-content">
                        @forelse($latestJobs as $job)
                            <span class="ticker-item">
                                <a href="{{ route('posts.show', [$job->type, $job->slug]) }}" 
                                   class="hover:text-yellow-200 transition inline-block font-medium">
                                    {{ $job->title }}
                                </a>
                                <span class="mx-3 md:mx-4 text-yellow-300">•</span>
                            </span>
                        @empty
                            <span class="ticker-item">No jobs available</span>
                        @endforelse
                        
                        <!-- Duplicate for continuous scroll -->
                        @forelse($latestJobs as $job)
                            <span class="ticker-item">
                                <a href="{{ route('posts.show', [$job->type, $job->slug]) }}" 
                                   class="hover:text-yellow-200 transition inline-block font-medium">
                                    {{ $job->title }}
                                </a>
                                <span class="mx-3 md:mx-4 text-yellow-300">•</span>
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
        padding: 0 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
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
            padding: 0 0.25rem;
            font-size: 0.75rem;
        }
        
        .ticker-content {
            animation: scroll-left 40s linear infinite;
        }
    }
    
    @media (min-width: 768px) {
        .ticker-item {
            font-size: 0.9375rem;
        }
    }
</style>
