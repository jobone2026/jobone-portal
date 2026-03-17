@extends('layouts.app')

@section('title', 'Government Job Portal - Latest Jobs & Opportunities')
@section('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more')

@section('content')
    <style>
        @keyframes pulse-glow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        
        @keyframes slide-in {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .modern-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 2px solid #e9ecef;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 200px;
            position: relative;
            overflow: hidden;
        }
        
        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        
        .modern-card:hover::before {
            transform: translateX(100%);
        }
        
        .modern-card:hover {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
            transform: translateY(-4px);
            border-color: #cbd5e1;
        }
        
        .modern-card-header {
            padding: 16px 20px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            background: linear-gradient(135deg, currentColor 0%, currentColor 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            flex-wrap: nowrap;
        }
        
        .modern-card-header-title {
            flex: 1;
            min-width: 120px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }
        
        .post-count-badge {
            background: rgba(255, 255, 255, 0.95);
            color: #1e293b;
            padding: 6px 14px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
            border: 2px solid rgba(255, 255, 255, 0.4);
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        
        .modern-card-item {
            padding: 12px 18px;
            border-bottom: 1px solid #f0f0f0;
            border-left: 3px solid transparent;
            font-size: 13px;
            line-height: 1.5;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
            position: relative;
        }
        
        .modern-card-item:last-child {
            border-bottom: none;
        }
        
        .modern-card-item:hover {
            background: linear-gradient(90deg, #f8f9fa 0%, #ffffff 100%);
            padding-left: 22px;
            animation: slide-in 0.3s ease;
        }
        
        /* Colorful left border on hover */
        .modern-card-item:nth-child(6n+1):hover { border-left-color: #2563eb; } /* Blue */
        .modern-card-item:nth-child(6n+2):hover { border-left-color: #059669; } /* Green */
        .modern-card-item:nth-child(6n+3):hover { border-left-color: #7c3aed; } /* Purple */
        .modern-card-item:nth-child(6n+4):hover { border-left-color: #dc2626; } /* Red */
        .modern-card-item:nth-child(6n+5):hover { border-left-color: #ea580c; } /* Orange */
        .modern-card-item:nth-child(6n+6):hover { border-left-color: #0891b2; } /* Cyan */
        
        .modern-card-item-content {
            flex: 1;
            min-width: 0;
        }
        
        .modern-card-item a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            transition: all 0.2s ease;
        }
        
        .modern-card-item a:hover {
            color: #0052a3;
            text-decoration: underline;
            transform: translateX(2px);
        }
        
        .modern-card-item-meta {
            font-size: 11px;
            color: #666;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 4px;
        }
        
        .modern-card-item-meta span {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 4px;
        }
        
        .modern-card-item-meta i {
            font-size: 9px;
        }
        
        .modern-card-item-date {
            font-size: 11px;
            color: #999;
            white-space: nowrap;
            text-align: right;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 3px;
            background: #f8fafc;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .modern-card-item-date-day {
            font-size: 18px;
            font-weight: 800;
            color: #2563eb;
            line-height: 1;
        }
        
        .modern-card-item-date-month {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            line-height: 1;
            letter-spacing: 0.5px;
        }
        
        .modern-card-item-date-year {
            font-size: 9px;
            color: #94a3b8;
            line-height: 1;
        }
        
        .post-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-new {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            animation: pulse-glow 2s ease-in-out infinite;
            box-shadow: 0 2px 6px rgba(22, 101, 52, 0.2);
        }
        
        .badge-hot {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            box-shadow: 0 2px 6px rgba(153, 27, 27, 0.2);
        }
        
        .modern-card-footer {
            padding: 12px 18px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 13px;
            border-top: 2px solid #e2e8f0;
        }
        
        .modern-card-footer a {
            color: inherit;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        
        .modern-card-footer a:hover {
            transform: translateX(4px);
        }
        
        /* Different colors for each post type */
        .modern-card-item:nth-child(6n+1) a { color: #2563eb; } /* Blue */
        .modern-card-item:nth-child(6n+2) a { color: #059669; } /* Green */
        .modern-card-item:nth-child(6n+3) a { color: #7c3aed; } /* Purple */
        .modern-card-item:nth-child(6n+4) a { color: #dc2626; } /* Red */
        .modern-card-item:nth-child(6n+5) a { color: #ea580c; } /* Orange */
        .modern-card-item:nth-child(6n+6) a { color: #0891b2; } /* Cyan */
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .modern-card-item {
                padding: 10px 14px;
                gap: 10px;
            }
            .modern-card-item-date {
                padding: 6px 8px;
            }
            .modern-card-item-date-day {
                font-size: 16px;
            }
            .modern-card-header {
                font-size: 14px;
                padding: 14px 16px;
                gap: 12px;
            }
            .modern-card-header-title {
                font-size: 14px;
                gap: 8px;
            }
            .post-count-badge {
                font-size: 11px;
                padding: 5px 12px;
            }
        }
    </style>

    <!-- Three Column Table Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left Column: Jobs -->
        @if ($sections['jobs']->count() > 0)
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-blue-600">
                <span class="modern-card-header-title"><i class="fas fa-briefcase"></i> Latest Jobs</span>
                <span class="post-count-badge">{{ $sections['jobs']->count() }}</span>
            </div>
            <div>
                @foreach ($sections['jobs']->take(50) as $post)
                <div class="modern-card-item">
                    <div class="modern-card-item-content">
                        <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                        <div class="modern-card-item-meta">
                            @if($post->isNew())
                            <span class="post-badge badge-new">NEW</span>
                            @endif
                            @if($post->category)
                            <span><i class="fas fa-tag"></i> {{ $post->category->name }}</span>
                            @endif
                            @if($post->state)
                            <span><i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-item-date">
                        <div class="modern-card-item-date-day">{{ $post->created_at->format('d') }}</div>
                        <div class="modern-card-item-date-month">{{ $post->created_at->format('M') }}</div>
                        <div class="modern-card-item-date-year">{{ $post->created_at->format('Y') }}</div>
                    </div>
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
                <span class="modern-card-header-title"><i class="fas fa-chart-bar"></i> Exam Results</span>
                <span class="post-count-badge">{{ $sections['results']->count() }}</span>
            </div>
            <div>
                @foreach ($sections['results']->take(50) as $post)
                <div class="modern-card-item">
                    <div class="modern-card-item-content">
                        <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                        <div class="modern-card-item-meta">
                            @if($post->isNew())
                            <span class="post-badge badge-new">NEW</span>
                            @endif
                            @if($post->category)
                            <span><i class="fas fa-tag"></i> {{ $post->category->name }}</span>
                            @endif
                            @if($post->state)
                            <span><i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-item-date">
                        <div class="modern-card-item-date-day">{{ $post->created_at->format('d') }}</div>
                        <div class="modern-card-item-date-month">{{ $post->created_at->format('M') }}</div>
                        <div class="modern-card-item-date-year">{{ $post->created_at->format('Y') }}</div>
                    </div>
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
                <span class="modern-card-header-title"><i class="fas fa-id-card"></i> Admit Cards</span>
                <span class="post-count-badge">{{ $sections['admit_cards']->count() }}</span>
            </div>
            <div>
                @foreach ($sections['admit_cards']->take(50) as $post)
                <div class="modern-card-item">
                    <div class="modern-card-item-content">
                        <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                        <div class="modern-card-item-meta">
                            @if($post->isNew())
                            <span class="post-badge badge-new">NEW</span>
                            @endif
                            @if($post->category)
                            <span><i class="fas fa-tag"></i> {{ $post->category->name }}</span>
                            @endif
                            @if($post->state)
                            <span><i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-item-date">
                        <div class="modern-card-item-date-day">{{ $post->created_at->format('d') }}</div>
                        <div class="modern-card-item-date-month">{{ $post->created_at->format('M') }}</div>
                        <div class="modern-card-item-date-year">{{ $post->created_at->format('Y') }}</div>
                    </div>
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
                <span class="modern-card-header-title"><i class="fas fa-key"></i> Answer Keys</span>
                <span class="post-count-badge">{{ $sections['answer_keys']->count() }}</span>
            </div>
            <div>
                @foreach ($sections['answer_keys']->take(50) as $post)
                <div class="modern-card-item">
                    <div class="modern-card-item-content">
                        <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                        <div class="modern-card-item-meta">
                            @if($post->isNew())
                            <span class="post-badge badge-new">NEW</span>
                            @endif
                            @if($post->category)
                            <span><i class="fas fa-tag"></i> {{ $post->category->name }}</span>
                            @endif
                            @if($post->state)
                            <span><i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-item-date">
                        <div class="modern-card-item-date-day">{{ $post->created_at->format('d') }}</div>
                        <div class="modern-card-item-date-month">{{ $post->created_at->format('M') }}</div>
                        <div class="modern-card-item-date-year">{{ $post->created_at->format('Y') }}</div>
                    </div>
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
                <span class="modern-card-header-title"><i class="fas fa-book"></i> Syllabus</span>
                <span class="post-count-badge">{{ $sections['syllabus']->count() }}</span>
            </div>
            <div>
                @foreach ($sections['syllabus']->take(50) as $post)
                <div class="modern-card-item">
                    <div class="modern-card-item-content">
                        <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                        <div class="modern-card-item-meta">
                            @if($post->isNew())
                            <span class="post-badge badge-new">NEW</span>
                            @endif
                            @if($post->category)
                            <span><i class="fas fa-tag"></i> {{ $post->category->name }}</span>
                            @endif
                            @if($post->state)
                            <span><i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-item-date">
                        <div class="modern-card-item-date-day">{{ $post->created_at->format('d') }}</div>
                        <div class="modern-card-item-date-month">{{ $post->created_at->format('M') }}</div>
                        <div class="modern-card-item-date-year">{{ $post->created_at->format('Y') }}</div>
                    </div>
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
                <span class="modern-card-header-title"><i class="fas fa-pen-fancy"></i> Blogs</span>
                <span class="post-count-badge">{{ $sections['blogs']->count() }}</span>
            </div>
            <div>
                @foreach ($sections['blogs']->take(50) as $post)
                <div class="modern-card-item">
                    <div class="modern-card-item-content">
                        <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                        <div class="modern-card-item-meta">
                            @if($post->isNew())
                            <span class="post-badge badge-new">NEW</span>
                            @endif
                            @if($post->category)
                            <span><i class="fas fa-tag"></i> {{ $post->category->name }}</span>
                            @endif
                            @if($post->state)
                            <span><i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modern-card-item-date">
                        <div class="modern-card-item-date-day">{{ $post->created_at->format('d') }}</div>
                        <div class="modern-card-item-date-month">{{ $post->created_at->format('M') }}</div>
                        <div class="modern-card-item-date-year">{{ $post->created_at->format('Y') }}</div>
                    </div>
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
