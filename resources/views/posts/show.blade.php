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

    <!-- Share Buttons -->
    <x-share-buttons />

    <article class="modern-content rounded-lg shadow-md p-6 md:p-8 mb-8">
        <div class="mb-6">
            <div class="flex justify-between items-start mb-4 flex-wrap gap-2">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex-1">{{ $post->title }}</h1>
                @if ($post->isNew())
                    <span class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold">NEW</span>
                @endif
            </div>

            <div class="flex flex-wrap gap-2 mb-4">
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

            <div class="flex justify-between items-center text-2xs text-gray-600 border-t border-b border-gray-200 py-3">
                <span><i class="fas fa-calendar"></i> Published: {{ $post->created_at->format('M d, Y') }}</span>
                <span><i class="fas fa-eye"></i> {{ $post->view_count }} views</span>
            </div>
        </div>

        <!-- Important Dates -->
        @if ($post->last_date || $post->notification_date || $post->total_posts)
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-600 p-4 mb-6 rounded-r-lg">
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
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-lg mb-6 border border-gray-200">
            <p class="text-gray-700 text-sm leading-relaxed">{{ $post->short_description }}</p>
        </div>

        <!-- Main Content -->
        <div class="prose prose-sm max-w-none mb-6 text-sm">
            {!! $post->content !!}
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
            <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 p-4 mb-6 rounded-r-lg">
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

        <!-- Modern Share Section -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl p-6 mb-6 shadow-sm">
            <h3 class="font-bold text-purple-900 mb-4 text-base flex items-center gap-2">
                <i class="fas fa-share-alt"></i> Share This Post
            </h3>
            
            @php
                $shareUrl = route('posts.show', [$post->type, $post->slug]);
                $shareTitle = $post->title;
                
                // Create a simple text message for WhatsApp
                $whatsappMessage = "🔔 {$shareTitle}\n\n";
                
                if ($post->last_date) {
                    $whatsappMessage .= "📅 Last Date: " . $post->last_date->format('d M Y') . "\n";
                }
                if ($post->total_posts) {
                    $whatsappMessage .= "📊 Total Posts: {$post->total_posts}\n";
                }
                
                $whatsappMessage .= "\n🔗 Apply Now: {$shareUrl}\n\n";
                $whatsappMessage .= "📢 Join us for more updates:\n";
                
                $settings = \App\Models\SiteSetting::whereIn('key', ['telegram_url', 'facebook_url', 'whatsapp_url'])->pluck('value', 'key');
                
                if (!empty($settings['telegram_url'])) {
                    $whatsappMessage .= "📱 Telegram: {$settings['telegram_url']}\n";
                }
                if (!empty($settings['facebook_url'])) {
                    $whatsappMessage .= "👍 Facebook: {$settings['facebook_url']}\n";
                }
                if (!empty($settings['whatsapp_url'])) {
                    $whatsappMessage .= "💬 WhatsApp Group: {$settings['whatsapp_url']}\n";
                }
                
                $whatsappMessage .= "\n✅ Visit: https://jobone.in";
                
                $encodedWhatsappMessage = urlencode($whatsappMessage);
                $encodedUrl = urlencode($shareUrl);
                $encodedTitle = urlencode($shareTitle);
            @endphp
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <!-- WhatsApp -->
                <a href="https://wa.me/?text={{ $encodedWhatsappMessage }}" 
                   target="_blank" 
                   onclick="trackShare('WhatsApp', '{{ $shareUrl }}', '{{ $shareTitle }}')"
                   class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg transition transform hover:scale-105 shadow-md">
                    <i class="fab fa-whatsapp text-xl"></i>
                    <span class="font-semibold text-sm">WhatsApp</span>
                </a>
                
                <!-- Telegram -->
                <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedWhatsappMessage }}" 
                   target="_blank"
                   onclick="trackShare('Telegram', '{{ $shareUrl }}', '{{ $shareTitle }}')"
                   class="flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg transition transform hover:scale-105 shadow-md">
                    <i class="fab fa-telegram text-xl"></i>
                    <span class="font-semibold text-sm">Telegram</span>
                </a>
                
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
                   target="_blank"
                   onclick="trackShare('Facebook', '{{ $shareUrl }}', '{{ $shareTitle }}')"
                   class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition transform hover:scale-105 shadow-md">
                    <i class="fab fa-facebook-f text-xl"></i>
                    <span class="font-semibold text-sm">Facebook</span>
                </a>
                
                <!-- Twitter/X -->
                <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
                   target="_blank"
                   onclick="trackShare('Twitter', '{{ $shareUrl }}', '{{ $shareTitle }}')"
                   class="flex items-center justify-center gap-2 bg-black hover:bg-gray-800 text-white px-4 py-3 rounded-lg transition transform hover:scale-105 shadow-md">
                    <i class="fab fa-twitter text-xl"></i>
                    <span class="font-semibold text-sm">Twitter</span>
                </a>
            </div>
            
            <p class="text-xs text-purple-700 mt-4 text-center">
                <i class="fas fa-info-circle"></i> Share with your friends and help them stay updated!
            </p>
        </div>
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
