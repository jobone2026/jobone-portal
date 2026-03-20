@extends('layouts.app')

@section('title', 'Government Job Portal - Latest Jobs & Opportunities')
@section('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more')

@section('content')
    <style>
        .modern-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            min-height: 200px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 12px;
        }
        .modern-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: translateY(-4px);
            border-color: #cbd5e1;
        }
        .modern-card-header {
            padding: 14px 18px;
            font-size: 15px;
            font-weight: 700;
            color: white;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .modern-card-item {
            padding: 12px 18px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
            line-height: 1.5;
            transition: all 0.3s ease;
        }
        .modern-card-item:last-child {
            border-bottom: none;
        }
        .modern-card-item:hover {
            background: linear-gradient(90deg, #f0f9ff 0%, #e0f2fe 100%);
            padding-left: 24px;
            border-left: 3px solid #3b82f6;
        }
        .modern-card-item a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            transition: color 0.2s ease;
        }
        .modern-card-item a:hover {
            color: #1d4ed8;
            text-decoration: none;
        }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .modern-card {
                min-height: 180px;
            }
            .modern-card-header {
                padding: 8px 12px;
                font-size: 12px;
            }
            .modern-card-item {
                padding: 8px 12px;
                font-size: 12px;
            }
            .modern-card-item:hover {
                padding-left: 16px;
            }
            .modern-card-item a {
                font-size: 12px;
                line-height: 1.3;
            }
            .modern-card-footer {
                padding: 8px 12px;
                font-size: 11px;
            }
        }
        
        /* Ensure proper grid behavior */
        .grid {
            display: grid;
            width: 100%;
        }
        
        @media (max-width: 767px) {
            .grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        .modern-card-item-date {
            font-size: 11px;
            color: #999;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .modern-card-item-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 2px 6px;
            background: #f0f0f0;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            color: #666;
        }
        .modern-card-item-badge.category {
            background: #e3f2fd;
            color: #1976d2;
        }
        .modern-card-item-badge.state {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        .modern-card-item-badge.views {
            background: #fff3e0;
            color: #e65100;
        }
        .modern-card-item-badge.new {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            animation: pulse 2s infinite;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        }
        @keyframes pulse {
            0%, 100% { 
                opacity: 1;
                transform: scale(1);
            }
            50% { 
                opacity: 0.8;
                transform: scale(1.05);
            }
        }
        .modern-card-footer {
            padding: 12px 18px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            text-align: center;
            border-radius: 0 0 10px 10px;
            font-size: 13px;
            border-top: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .modern-card-footer:hover {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        }
        .modern-card-footer a {
            color: inherit;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: transform 0.2s ease;
        }
        .modern-card-footer a:hover {
            transform: translateX(4px);
        }
        
        /* Consistent color for all job cards */
        .modern-card-item a { color: #0066cc !important; } /* Single blue color for all */
    </style>

    <!-- Six Column Layout - Different Post Types -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-4">
        <!-- Left Column: Jobs -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fas fa-briefcase"></i> Latest Jobs
            </div>
            <div>
                @forelse ($sections['jobs'] ?? [] as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    
                    <!-- Vacancies and Last Date -->
                    @if($post->total_posts || $post->last_date)
                    <div class="flex gap-2 mt-2 mb-2 flex-wrap">
                        @if($post->total_posts)
                        <div class="flex items-center gap-1 text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded font-semibold border border-blue-200">
                            <i class="fas fa-users"></i>
                            <span>{{ number_format($post->total_posts) }}</span>
                        </div>
                        @endif
                        @if($post->last_date)
                        <div class="flex items-center gap-1 text-xs bg-red-50 text-red-700 px-2 py-1 rounded font-semibold border border-red-200">
                            <i class="fas fa-calendar-times"></i>
                            <span>{{ $post->last_date->format('d M') }}</span>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        @if($post->category)
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> {{ $post->category->name }}
                        </span>
                        @endif
                        @if($post->state)
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                        </span>
                        @endif
                        @if($post->created_at->diffInDays(now()) <= 3)
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="modern-card-item text-gray-500">
                    No jobs found
                </div>
                @endforelse
            </div>
            <div class="modern-card-footer text-blue-600">
                <a href="{{ route('posts.jobs') }}">View All Jobs →</a>
            </div>
        </div>

        <!-- Middle Column: Results -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);">
                <i class="fas fa-chart-bar"></i> Exam Results
            </div>
            <div>
                @forelse ($sections['results'] ?? [] as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        @if($post->category)
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> {{ $post->category->name }}
                        </span>
                        @endif
                        @if($post->state)
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                        </span>
                        @endif
                        @if($post->view_count > 0)
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> {{ number_format($post->view_count) }}
                        </span>
                        @endif
                        @if($post->created_at->diffInDays(now()) <= 3)
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="modern-card-item text-gray-500">
                    No results found
                </div>
                @endforelse
            </div>
            <div class="modern-card-footer text-green-600">
                <a href="{{ route('posts.results') }}">View All Results →</a>
            </div>
        </div>

        <!-- Right Column: Admit Cards -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                <i class="fas fa-id-card"></i> Admit Cards
            </div>
            <div>
                @forelse ($sections['admit_cards'] ?? [] as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        @if($post->category)
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> {{ $post->category->name }}
                        </span>
                        @endif
                        @if($post->state)
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                        </span>
                        @endif
                        @if($post->view_count > 0)
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> {{ number_format($post->view_count) }}
                        </span>
                        @endif
                        @if($post->created_at->diffInDays(now()) <= 3)
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="modern-card-item text-gray-500">
                    No admit cards found
                </div>
                @endforelse
            </div>
            <div class="modern-card-footer text-purple-600">
                <a href="{{ route('posts.admit-cards') }}">View All Admit Cards →</a>
            </div>
        </div>

        <!-- Answer Keys -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                <i class="fas fa-key"></i> Answer Keys
            </div>
            <div>
                @forelse ($sections['answer_keys'] ?? [] as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        @if($post->category)
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> {{ $post->category->name }}
                        </span>
                        @endif
                        @if($post->state)
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                        </span>
                        @endif
                        @if($post->view_count > 0)
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> {{ number_format($post->view_count) }}
                        </span>
                        @endif
                        @if($post->created_at->diffInDays(now()) <= 3)
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="modern-card-item text-gray-500">
                    No answer keys found
                </div>
                @endforelse
            </div>
            <div class="modern-card-footer text-yellow-600">
                <a href="{{ route('posts.answer-keys') }}">View All Answer Keys →</a>
            </div>
        </div>

        <!-- Syllabus -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <i class="fas fa-book"></i> Syllabus
            </div>
            <div>
                @forelse ($sections['syllabus'] ?? [] as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        @if($post->category)
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> {{ $post->category->name }}
                        </span>
                        @endif
                        @if($post->state)
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                        </span>
                        @endif
                        @if($post->view_count > 0)
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> {{ number_format($post->view_count) }}
                        </span>
                        @endif
                        @if($post->created_at->diffInDays(now()) <= 3)
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="modern-card-item text-gray-500">
                    No syllabus found
                </div>
                @endforelse
            </div>
            <div class="modern-card-footer text-indigo-600">
                <a href="{{ route('posts.syllabus') }}">View All Syllabus →</a>
            </div>
        </div>

        <!-- Blogs -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);">
                <i class="fas fa-pen-fancy"></i> Blogs
            </div>
            <div>
                @forelse ($sections['blogs'] ?? [] as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        @if($post->category)
                        <span class="modern-card-item-badge category">
                            <i class="fas fa-tag"></i> {{ $post->category->name }}
                        </span>
                        @endif
                        @if($post->state)
                        <span class="modern-card-item-badge state">
                            <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                        </span>
                        @endif
                        @if($post->view_count > 0)
                        <span class="modern-card-item-badge views">
                            <i class="fas fa-eye"></i> {{ number_format($post->view_count) }}
                        </span>
                        @endif
                        @if($post->created_at->diffInDays(now()) <= 3)
                        <span class="modern-card-item-badge new">
                            <i class="fas fa-star"></i> NEW
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="modern-card-item text-gray-500">
                    No blogs found
                </div>
                @endforelse
            </div>
            <div class="modern-card-footer">
                <a href="{{ route('posts.blogs') }}" class="text-pink-600">
                    <span>{{ count($sections['blogs'] ?? []) }} blogs</span>
                </a>
            </div>
        </div>
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
