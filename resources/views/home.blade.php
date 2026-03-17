@extends('layouts.app')

@section('title', 'Government Job Portal - Latest Jobs & Opportunities')
@section('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more')

@section('content')
    <style>
        /* Breaking News Styles */
        .breaking-news-container {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
            overflow: hidden;
        }
        .breaking-news-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            color: white;
        }
        .breaking-news-badge {
            background: #ef4444;
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .breaking-news-title {
            font-size: 18px;
            font-weight: 700;
            color: white;
        }
        .breaking-news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 12px;
        }
        .breaking-news-item {
            background: white;
            border-radius: 8px;
            padding: 14px;
            transition: all 0.3s ease;
            border-left: 4px solid;
            position: relative;
            overflow: hidden;
        }
        .breaking-news-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }
        .breaking-news-item::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60px;
            height: 60px;
            opacity: 0.1;
            border-radius: 50%;
        }
        /* Post Type Colors */
        .breaking-news-item.type-job {
            border-left-color: #2563eb;
        }
        .breaking-news-item.type-job::before {
            background: #2563eb;
        }
        .breaking-news-item.type-result {
            border-left-color: #059669;
        }
        .breaking-news-item.type-result::before {
            background: #059669;
        }
        .breaking-news-item.type-admit_card {
            border-left-color: #7c3aed;
        }
        .breaking-news-item.type-admit_card::before {
            background: #7c3aed;
        }
        .breaking-news-item.type-answer_key {
            border-left-color: #d97706;
        }
        .breaking-news-item.type-answer_key::before {
            background: #d97706;
        }
        .breaking-news-item.type-syllabus {
            border-left-color: #4f46e5;
        }
        .breaking-news-item.type-syllabus::before {
            background: #4f46e5;
        }
        .breaking-news-item.type-blog {
            border-left-color: #db2777;
        }
        .breaking-news-item.type-blog::before {
            background: #db2777;
        }
        .breaking-news-type-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            color: white;
        }
        .breaking-news-type-badge.job { background: #2563eb; }
        .breaking-news-type-badge.result { background: #059669; }
        .breaking-news-type-badge.admit_card { background: #7c3aed; }
        .breaking-news-type-badge.answer_key { background: #d97706; }
        .breaking-news-type-badge.syllabus { background: #4f46e5; }
        .breaking-news-type-badge.blog { background: #db2777; }
        .breaking-news-link {
            color: #1f2937;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            line-height: 1.4;
            display: block;
            margin-bottom: 8px;
        }
        .breaking-news-link:hover {
            color: #2563eb;
        }
        .breaking-news-date {
            font-size: 11px;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .breaking-news-new {
            background: #ef4444;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            margin-left: 8px;
            animation: blink 1.5s infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .modern-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            min-height: 200px;
        }
        .modern-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        .modern-card-header {
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            border-radius: 8px 8px 0 0;
        }
        .modern-card-item {
            padding: 10px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
            line-height: 1.4;
        }
        .modern-card-item:last-child {
            border-bottom: none;
        }
        .modern-card-item a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
            display: block;
            margin-bottom: 4px;
        }
        .modern-card-item a:hover {
            color: #0052a3;
            text-decoration: underline;
        }
        .modern-card-item-date {
            font-size: 11px;
            color: #999;
            margin-top: 2px;
        }
        .modern-card-footer {
            padding: 10px 16px;
            background: #f8f9fa;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 12px;
        }
        .modern-card-footer a {
            color: inherit;
            font-weight: 600;
            text-decoration: none;
        }
        .modern-card-footer a:hover {
            text-decoration: underline;
        }
    </style>

    <!-- Breaking News Section -->
    <div class="breaking-news-container">
        <div class="breaking-news-header">
            <span class="breaking-news-badge">
                <i class="fas fa-bolt"></i> Breaking News
            </span>
            <span class="breaking-news-title">Latest Updates</span>
        </div>
        <div class="breaking-news-grid">
            @php
                $breakingNews = collect([
                    $sections['jobs']->take(3),
                    $sections['results']->take(2),
                    $sections['admit_cards']->take(2),
                    $sections['answer_keys']->take(1),
                    $sections['syllabus']->take(1),
                    $sections['blogs']->take(1)
                ])->flatten()->sortByDesc('created_at')->take(10);
            @endphp
            
            @foreach($breakingNews as $post)
            <div class="breaking-news-item type-{{ $post->type }}">
                <span class="breaking-news-type-badge {{ $post->type }}">
                    @if($post->type === 'job')
                        <i class="fas fa-briefcase"></i> Job
                    @elseif($post->type === 'result')
                        <i class="fas fa-chart-bar"></i> Result
                    @elseif($post->type === 'admit_card')
                        <i class="fas fa-id-card"></i> Admit Card
                    @elseif($post->type === 'answer_key')
                        <i class="fas fa-key"></i> Answer Key
                    @elseif($post->type === 'syllabus')
                        <i class="fas fa-book"></i> Syllabus
                    @elseif($post->type === 'blog')
                        <i class="fas fa-pen-fancy"></i> Blog
                    @endif
                </span>
                @if($post->created_at->diffInHours(now()) < 24)
                    <span class="breaking-news-new">NEW</span>
                @endif
                <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}" class="breaking-news-link">
                    {{ Str::limit($post->title, 80) }}
                </a>
                <div class="breaking-news-date">
                    <i class="fas fa-clock"></i>
                    {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Three Column Table Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left Column: Jobs -->
        @if ($sections['jobs']->count() > 0)
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-blue-600">
                <i class="fas fa-briefcase"></i> Latest Jobs
            </div>
            <div>
                @foreach ($sections['jobs']->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
                </div>
                @endforeach
            </div>
            <div class="modern-card-footer text-blue-600">
                <a href="{{ route('posts.jobs') }}">View All Jobs →</a>
            </div>
        </div>
        @endif

        <!-- Middle Column: Results -->
        @if ($sections['results']->count() > 0)
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-green-600">
                <i class="fas fa-chart-bar"></i> Exam Results
            </div>
            <div>
                @foreach ($sections['results']->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
                </div>
                @endforeach
            </div>
            <div class="modern-card-footer text-green-600">
                <a href="{{ route('posts.results') }}">View All Results →</a>
            </div>
        </div>
        @endif

        <!-- Right Column: Admit Cards -->
        @if ($sections['admit_cards']->count() > 0)
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-purple-600">
                <i class="fas fa-id-card"></i> Admit Cards
            </div>
            <div>
                @foreach ($sections['admit_cards']->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
                </div>
                @endforeach
            </div>
            <div class="modern-card-footer text-purple-600">
                <a href="{{ route('posts.admit-cards') }}">View All Admit Cards →</a>
            </div>
        </div>
        @endif
    </div>

    <!-- Additional Sections (Optional) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <!-- Answer Keys -->
        @if ($sections['answer_keys']->count() > 0)
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-yellow-600">
                <i class="fas fa-key"></i> Answer Keys
            </div>
            <div>
                @foreach ($sections['answer_keys']->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
                </div>
                @endforeach
            </div>
            <div class="modern-card-footer text-yellow-600">
                <a href="{{ route('posts.answer-keys') }}">View All Answer Keys →</a>
            </div>
        </div>
        @endif

        <!-- Syllabus -->
        @if ($sections['syllabus']->count() > 0)
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-indigo-600">
                <i class="fas fa-book"></i> Syllabus
            </div>
            <div>
                @foreach ($sections['syllabus']->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
                </div>
                @endforeach
            </div>
            <div class="modern-card-footer text-indigo-600">
                <a href="{{ route('posts.syllabus') }}">View All Syllabus →</a>
            </div>
        </div>
        @endif

        <!-- Blogs -->
        @if ($sections['blogs']->count() > 0)
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-pink-600">
                <i class="fas fa-pen-fancy"></i> Blogs
            </div>
            <div>
                @foreach ($sections['blogs']->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
                </div>
                @endforeach
            </div>
            <div class="modern-card-footer text-pink-600">
                <a href="{{ route('posts.blogs') }}">View All Blogs →</a>
            </div>
        </div>
        @endif
    </div>

    <!-- Share Section -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-0 shadow-sm">
        <h3 class="font-bold text-gray-900 mb-4 text-base flex items-center gap-2">
            <i class="fas fa-share-alt"></i> Follow & Share
        </h3>
        
        @php
            $shareUrl = route('home');
            $shareTitle = 'JobOne - Latest Government Jobs, Results, Admit Cards';
            $simpleMessage = "{$shareTitle} - Visit: {$shareUrl}";
            $encodedSimpleMessage = urlencode($simpleMessage);
            $encodedUrl = urlencode($shareUrl);
            $encodedTitle = urlencode($shareTitle);
        @endphp
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- WhatsApp -->
            <a href="https://wa.me/?text={{ $encodedSimpleMessage }}" 
               target="_blank" 
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #25D366;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-whatsapp" style="font-size: 20px;"></i>
                </div>
                <span>WhatsApp</span>
            </a>
            
            <!-- Telegram -->
            <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #0088cc;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-telegram" style="font-size: 20px;"></i>
                </div>
                <span>Telegram</span>
            </a>
            
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #1877F2;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-facebook-f" style="font-size: 20px;"></i>
                </div>
                <span>Facebook</span>
            </a>
            
            <!-- Twitter/X -->
            <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #000000;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-twitter" style="font-size: 20px;"></i>
                </div>
                <span>Twitter</span>
            </a>
        </div>
        
        <p class="text-xs text-gray-700 mt-4 text-center">
            <i class="fas fa-info-circle"></i> Share with your friends and help them stay updated!
        </p>
    </div>
@endsection
