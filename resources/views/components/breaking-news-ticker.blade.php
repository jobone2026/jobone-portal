@php
    $latestJobs = \App\Models\Post::published()
        ->ofType('job')
        ->latest()
        ->limit(10)
        ->get();
@endphp

<div class="bg-white border-b-2 border-blue-600 py-1.5 sticky top-0 z-50 shadow-md overflow-hidden">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex items-center gap-2">
            <!-- Latest Jobs Label -->
            <div class="flex-shrink-0 flex items-center gap-1.5 font-bold text-xs whitespace-nowrap bg-blue-600 text-white px-2.5 py-1 rounded shadow-sm">
                <i class="fas fa-briefcase text-xs"></i>
                <span>LATEST JOBS</span>
            </div>
            
            <!-- Jobs Ticker -->
            <div class="flex-1 overflow-hidden">
                <div class="ticker-container">
                    <div class="ticker-content">
                        @forelse($latestJobs as $job)
                            <span class="ticker-item">
                                <a href="{{ route('posts.show', [$job->type, $job->slug]) }}" 
                                   class="hover:text-blue-600 transition inline-block font-semibold text-gray-800">
                                    {{ $job->title }}
                                </a>
                                <span class="mx-2 text-red-500 font-bold">★</span>
                            </span>
                        @empty
                            <span class="ticker-item text-gray-600">No jobs available</span>
                        @endforelse
                        
                        <!-- Duplicate for continuous scroll -->
                        @forelse($latestJobs as $job)
                            <span class="ticker-item">
                                <a href="{{ route('posts.show', [$job->type, $job->slug]) }}" 
                                   class="hover:text-blue-600 transition inline-block font-semibold text-gray-800">
                                    {{ $job->title }}
                                </a>
                                <span class="mx-2 text-red-500 font-bold">★</span>
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
        animation: scroll-left 30s linear infinite;
        white-space: nowrap;
    }
    
    .ticker-item {
        display: inline-block;
        padding: 0 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
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
            font-size: 0.7rem;
        }
        
        .ticker-content {
            animation: scroll-left 20s linear infinite;
        }
    }
    
    @media (min-width: 768px) {
        .ticker-item {
            font-size: 0.8125rem;
        }
        
        .ticker-content {
            animation: scroll-left 35s linear infinite;
        }
    }
</style>
