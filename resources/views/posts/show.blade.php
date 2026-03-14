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
        .modern-content {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #e9ecef;
        }
        .modern-content h1, .modern-content h2, .modern-content h3 {
            color: #1a202c;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .modern-content p {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 1rem;
            font-size: 14px;
        }
        .modern-content a {
            color: #0066cc;
            text-decoration: none;
        }
        .modern-content a:hover {
            text-decoration: underline;
        }
        
        /* Isolate post content - prevent styles from leaking out */
        .post-content-wrapper {
            isolation: isolate;
            contain: layout style;
        }
        
        .post-content-isolated {
            display: block;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #4a5568;
        }
        
        /* Remove extra spacing */
        .post-content-isolated > *:first-child {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        .post-content-isolated > *:last-child {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
        
        .post-content-isolated p:empty,
        .post-content-isolated div:empty {
            display: none;
        }
        
        /* Style elements inside post content */
        .post-content-isolated p {
            margin: 0 0 1rem 0;
            line-height: 1.6;
        }
        
        .post-content-isolated h1,
        .post-content-isolated h2,
        .post-content-isolated h3,
        .post-content-isolated h4,
        .post-content-isolated h5,
        .post-content-isolated h6 {
            margin: 1.5rem 0 0.75rem 0;
            font-weight: bold;
            color: #1a202c;
        }
        
        .post-content-isolated h1:first-child,
        .post-content-isolated h2:first-child,
        .post-content-isolated h3:first-child {
            margin-top: 0;
        }
        
        .post-content-isolated ul,
        .post-content-isolated ol {
            margin: 0 0 1rem 1.5rem;
            padding: 0;
        }
        
        .post-content-isolated li {
            margin-bottom: 0.5rem;
        }
        
        .post-content-isolated table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        
        .post-content-isolated table td,
        .post-content-isolated table th {
            border: 1px solid #e5e7eb;
            padding: 0.5rem;
            text-align: left;
        }
        
        .post-content-isolated table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        
        .post-content-isolated a {
            color: #0066cc;
            text-decoration: none;
        }
        
        .post-content-isolated a:hover {
            text-decoration: underline;
        }
        
        .post-content-isolated img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 1rem 0;
        }
        
        .post-content-isolated strong,
        .post-content-isolated b {
            font-weight: bold;
        }
        
        .post-content-isolated em,
        .post-content-isolated i {
            font-style: italic;
        }
        
        .post-content-isolated blockquote {
            border-left: 4px solid #e5e7eb;
            padding-left: 1rem;
            margin: 1rem 0;
            color: #6b7280;
        }
        
        .post-content-isolated code {
            background-color: #f3f4f6;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: monospace;
            font-size: 0.9em;
        }
        
        .post-content-isolated pre {
            background-color: #f3f4f6;
            padding: 1rem;
            border-radius: 5px;
            overflow-x: auto;
            margin: 1rem 0;
        }
        
        .post-content-isolated pre code {
            background-color: transparent;
            padding: 0;
        }
        
        /* Prevent any inline styles in content from affecting outside */
        .post-content-isolated style,
        .post-content-isolated link[rel="stylesheet"] {
            display: none !important;
        }
        
        /* Override any inline background colors or styles */
        .post-content-isolated [style*="background"],
        .post-content-isolated [style*="color"],
        .post-content-isolated [style*="font"] {
            background: transparent !important;
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

    <article class="modern-content rounded-lg shadow-md p-3 md:p-8 mb-4 md:mb-8">
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
                @php
                    // Remove <style> tags and inline style attributes from content
                    $cleanContent = $post->content;
                    // Remove <style>...</style> tags
                    $cleanContent = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $cleanContent);
                    // Remove inline style attributes
                    $cleanContent = preg_replace('/\s*style\s*=\s*["\'][^"\']*["\']/i', '', $cleanContent);
                    // Remove <link> tags (CSS links)
                    $cleanContent = preg_replace('/<link\b[^>]*>/i', '', $cleanContent);
                @endphp
                {!! $cleanContent !!}
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
        <div class="bg-white border border-gray-200 rounded-xl p-3 md:p-6 mb-0 shadow-sm">
            <h3 class="font-bold text-gray-900 mb-3 md:mb-4 text-sm md:text-base flex items-center gap-2">
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
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
                <!-- WhatsApp -->
                <a href="https://wa.me/?text={{ $encodedSimpleMessage }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="share-btn"
                   style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px 10px; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.3s; background: #25D366; font-size: 12px;">
                    <div style="background: rgba(255,255,255,0.2); width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 50%; flex-shrink: 0;">
                        <i class="fab fa-whatsapp" style="font-size: 16px;"></i>
                    </div>
                    <span class="hidden sm:inline">WhatsApp</span>
                </a>
                
                <!-- Telegram -->
                <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="share-btn"
                   style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px 10px; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.3s; background: #0088cc; font-size: 12px;">
                    <div style="background: rgba(255,255,255,0.2); width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 50%; flex-shrink: 0;">
                        <i class="fab fa-telegram" style="font-size: 16px;"></i>
                    </div>
                    <span class="hidden sm:inline">Telegram</span>
                </a>
                
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="share-btn"
                   style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px 10px; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.3s; background: #1877F2; font-size: 12px;">
                    <div style="background: rgba(255,255,255,0.2); width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 50%; flex-shrink: 0;">
                        <i class="fab fa-facebook-f" style="font-size: 16px;"></i>
                    </div>
                    <span class="hidden sm:inline">Facebook</span>
                </a>
                
                <!-- Twitter/X -->
                <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="share-btn"
                   style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px 10px; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.3s; background: #000000; font-size: 12px;">
                    <div style="background: rgba(255,255,255,0.2); width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 50%; flex-shrink: 0;">
                        <i class="fab fa-twitter" style="font-size: 16px;"></i>
                    </div>
                    <span class="hidden sm:inline">Twitter</span>
                </a>
            </div>
            
            <p class="text-xs text-gray-700 mt-3 md:mt-4 text-center">
                <i class="fas fa-info-circle"></i> Share with your friends and help them stay updated!
            </p>
        </div>
        
        <style>
            @media (min-width: 640px) {
                .share-btn {
                    gap: 12px !important;
                    padding: 10px 20px !important;
                    font-size: 14px !important;
                }
                .share-btn div {
                    width: 40px !important;
                    height: 40px !important;
                }
                .share-btn i {
                    font-size: 20px !important;
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
                    <div class="modern-content rounded-lg p-4">
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
