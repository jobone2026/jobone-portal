@extends('layouts.app')

@section('title', $post->meta_title)
@section('description', $post->meta_description)
@section('keywords', $post->meta_keywords)
@section('canonical', route('posts.show', [$post->type, $post->slug]))
@section('og_title', $post->meta_title)
@section('og_description', $post->meta_description)
@section('og_url', route('posts.show', [$post->type, $post->slug]))

@section('content')
    <style>
        /* Post content wrapper - basic isolation */
        .post-content-wrapper {
            isolation: isolate;
            position: relative;
        }
        
        /* Allow content to have its own styles */
        .post-content-isolated {
            display: block;
            position: relative;
        }
    </style>

    <!-- Breadcrumb -->
    @php
        $typeRouteMap = [
            'job' => 'posts.jobs',
            'admit_card' => 'posts.admit-cards',
            'result' => 'posts.results',
            'answer_key' => 'posts.answer-keys',
            'syllabus' => 'posts.syllabus',
            'blog' => 'posts.blogs'
        ];
        $typeRoute = $typeRouteMap[$post->type] ?? 'home';
    @endphp
    <x-breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => ucfirst(str_replace('_', ' ', $post->type)), 'url' => route($typeRoute)],
        ['label' => $post->title, 'url' => '#']
    ]" />

    <article class="bg-white rounded-lg shadow-md p-3 md:p-8 mb-4 md:mb-8">
        <div class="mb-3">
            <div class="flex justify-between items-start mb-2 flex-wrap gap-2">
                <h1 class="font-bold text-gray-800 flex-1" style="font-size: 15px;">{{ $post->title }}</h1>
                @if ($post->isNew())
                    <span class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold">NEW</span>
                @endif
            </div>

            <div class="flex flex-wrap gap-2 mb-2">
                <span class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium"><i class="fas fa-tag"></i> {{ ucfirst(str_replace('_', ' ', $post->type)) }}</span>
                @if ($post->category)
                    <a href="{{ route('categories.show', $post->category) }}" class="text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded-full hover:bg-gray-200 transition font-medium">
                        <i class="fas fa-folder"></i> {{ $post->category->name }}
                    </a>
                @endif
                @if ($post->state)
                    <a href="{{ route('states.show', $post->state) }}" class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full hover:bg-green-200 transition font-medium">
                        <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                    </a>
                @endif
            </div>

            <div class="flex justify-between items-center text-2xs text-gray-600 border-t border-b border-gray-200 py-2">
                <span><i class="fas fa-calendar"></i> Published: {{ $post->created_at->format('M d, Y') }}</span>
                <span><i class="fas fa-eye"></i> {{ $post->view_count }} views</span>
            </div>
        </div>

        <!-- Important Dates -->
        @if ($post->last_date || $post->notification_date || $post->total_posts)
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-600 p-4 mb-3 rounded-r-lg">
                <h3 class="font-bold text-blue-900 mb-2 text-sm"><i class="fas fa-info-circle"></i> Important Information</h3>
                <ul class="text-xs text-blue-800 space-y-1">
                    @if ($post->notification_date)
                        <li><strong>Notification Date:</strong> {{ $post->notification_date->format('M d, Y') }}</li>
                    @endif
                    @if ($post->last_date)
                        <li><strong>Last Date:</strong> {{ $post->last_date->format('M d, Y') }}</li>
                    @endif
                    @if ($post->total_posts)
                        <li><strong>Total Posts:</strong> {{ $post->total_posts }}</li>
                    @endif
                </ul>
            </div>
        @endif

        <!-- Short Description -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-lg mb-3 border border-gray-200">
            <p class="text-gray-700 text-sm leading-relaxed">{{ $post->short_description }}</p>
        </div>

        <!-- Main Content -->
        <div class="prose prose-sm max-w-none mb-3 text-sm post-content-wrapper">
            <div class="post-content-isolated">
                {!! $post->content !!}
            </div>
        </div>

        <!-- Important Links -->
        @php
            $importantLinks = $post->important_links;
            // Handle case where important_links might be a JSON string instead of array
            if (is_string($importantLinks)) {
                $importantLinks = json_decode($importantLinks, true) ?? [];
            }
            // Ensure it's an array
            if (!is_array($importantLinks)) {
                $importantLinks = [];
            }
        @endphp
        @if (count($importantLinks) > 0)
            <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 p-4 mb-3 rounded-r-lg">
                <h3 class="font-bold text-green-900 mb-3 text-sm"><i class="fas fa-link"></i> Important Links</h3>
                <ul class="space-y-2">
                    @foreach ($importantLinks as $key => $value)
                        @if (is_array($value) && isset($value['url']))
                            {{-- Old format: array with 'label' and 'url' --}}
                            <li>
                                <a href="{{ $value['url'] }}" target="_blank" rel="noopener noreferrer" class="text-green-600 hover:text-green-800 font-semibold text-xs transition">
                                    <i class="fas fa-external-link-alt"></i> {{ $value['label'] ?? ucwords(str_replace('_', ' ', $key)) }}
                                </a>
                            </li>
                        @else
                            {{-- New format: simple key-value pairs --}}
                            <li>
                                <a href="{{ $value }}" target="_blank" rel="noopener noreferrer" class="text-green-600 hover:text-green-800 font-semibold text-xs transition">
                                    <i class="fas fa-external-link-alt"></i> {{ ucwords(str_replace('_', ' ', $key)) }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Share Section -->
        <div class="share-section-wrapper bg-white border border-gray-200 rounded-xl p-3 md:p-6 mb-0 shadow-sm">
            <h3 class="share-title font-bold text-gray-900 mb-3 md:mb-4 text-sm md:text-base flex items-center gap-2">
                <i class="fas fa-share-alt"></i> Share This Post
            </h3>
            
            @php
                $shareUrl = route('posts.show', [$post->type, $post->slug]);
                $shareTitle = $post->title;
                
                // Simple message for sharing
                $simpleMessage = "{$shareTitle} - Apply: {$shareUrl}";
                $encodedSimpleMessage = urlencode($simpleMessage);
                $encodedUrl = urlencode($shareUrl);
                $encodedTitle = urlencode($shareTitle);
            @endphp
            
            <div class="share-buttons-grid grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
                <!-- WhatsApp -->
                <a href="https://wa.me/?text={{ $encodedSimpleMessage }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="share-btn share-btn-whatsapp">
                    <div class="share-btn-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <span class="share-btn-text hidden sm:inline">WhatsApp</span>
                </a>
                
                <!-- Telegram -->
                <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="share-btn share-btn-telegram">
                    <div class="share-btn-icon">
                        <i class="fab fa-telegram"></i>
                    </div>
                    <span class="share-btn-text hidden sm:inline">Telegram</span>
                </a>
                
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="share-btn share-btn-facebook">
                    <div class="share-btn-icon">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <span class="share-btn-text hidden sm:inline">Facebook</span>
                </a>
                
                <!-- Twitter/X -->
                <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="share-btn share-btn-twitter">
                    <div class="share-btn-icon">
                        <i class="fab fa-twitter"></i>
                    </div>
                    <span class="share-btn-text hidden sm:inline">Twitter</span>
                </a>
            </div>
            
            <p class="share-hint text-xs text-gray-700 mt-3 md:mt-4 text-center">
                <i class="fas fa-info-circle"></i> Share with your friends and help them stay updated!
            </p>
        </div>
        
        <style>
            /* Protect share section from post content CSS */
            .share-section-wrapper {
                all: revert !important;
                background: white !important;
                border: 1px solid #e5e7eb !important;
                border-radius: 0.75rem !important;
                padding: 1.5rem !important;
                margin-bottom: 0 !important;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
            }
            
            .share-title {
                all: revert !important;
                font-weight: 700 !important;
                color: #111827 !important;
                margin-bottom: 1rem !important;
                font-size: 0.875rem !important;
                display: flex !important;
                align-items: center !important;
                gap: 0.5rem !important;
            }
            
            .share-buttons-grid {
                all: revert !important;
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.5rem !important;
            }
            
            .share-btn {
                all: revert !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 6px !important;
                padding: 8px 10px !important;
                color: white !important;
                text-decoration: none !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
                transition: all 0.3s !important;
                font-size: 12px !important;
                cursor: pointer !important;
            }
            
            .share-btn:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
            }
            
            .share-btn-whatsapp {
                background: #25D366 !important;
            }
            
            .share-btn-telegram {
                background: #0088cc !important;
            }
            
            .share-btn-facebook {
                background: #1877F2 !important;
            }
            
            .share-btn-twitter {
                background: #000000 !important;
            }
            
            .share-btn-icon {
                all: revert !important;
                background: rgba(255,255,255,0.2) !important;
                width: 28px !important;
                height: 28px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 50% !important;
                flex-shrink: 0 !important;
            }
            
            .share-btn-icon i {
                all: revert !important;
                font-size: 16px !important;
                color: white !important;
            }
            
            .share-btn-text {
                all: revert !important;
                color: white !important;
                font-size: 12px !important;
            }
            
            .share-hint {
                all: revert !important;
                font-size: 0.75rem !important;
                color: #374151 !important;
                margin-top: 1rem !important;
                text-align: center !important;
            }
            
            @media (min-width: 640px) {
                .share-section-wrapper {
                    padding: 1.5rem !important;
                }
                
                .share-title {
                    font-size: 1rem !important;
                    margin-bottom: 1rem !important;
                }
                
                .share-buttons-grid {
                    grid-template-columns: repeat(4, 1fr) !important;
                    gap: 1rem !important;
                }
                
                .share-btn {
                    gap: 12px !important;
                    padding: 10px 20px !important;
                    font-size: 14px !important;
                }
                
                .share-btn-icon {
                    width: 40px !important;
                    height: 40px !important;
                }
                
                .share-btn-icon i {
                    font-size: 20px !important;
                }
                
                .share-btn-text {
                    font-size: 14px !important;
                }
            }
        </style>

    </article>

    <!-- Ad Slot - After Post -->
    <x-ad-slot position="after_post" />

    <!-- Related Posts -->
    @if ($related->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4"><i class="fas fa-link"></i> Related Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($related as $relatedPost)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <a href="{{ route('posts.show', ['type' => $relatedPost->type, 'post' => $relatedPost->slug]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            {{ $relatedPost->title }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection


<script>
// Handle external app opening for WebView
function openExternalApp(app, data) {
    // Check if running in WebView
    var isWebView = /WebView|wv|\.0\.0\.0|Version\/[\d.]+(?!.*Safari)/.test(navigator.userAgent);
    
    if (isWebView) {
        // For WebView, use native app schemes
        var url = '';
        switch(app) {
            case 'whatsapp':
                url = 'whatsapp://send?text=' + data;
                break;
            case 'telegram':
                url = 'tg://msg?text=' + data;
                break;
            case 'facebook':
                url = 'fb://page/';
                break;
            case 'twitter':
                url = 'twitter://post?message=' + data;
                break;
        }
        
        if (url) {
            // Try to open native app
            window.location.href = url;
            
            // Fallback to web version after 1 second if app not installed
            setTimeout(function() {
                if (app === 'whatsapp') {
                    window.location.href = 'https://wa.me/?text=' + data;
                } else if (app === 'telegram') {
                    window.location.href = 'https://t.me/share/url?text=' + data;
                }
            }, 1000);
        }
    }
}
</script>
