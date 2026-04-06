@extends('layouts.app')

@section('title', 'Government Job Portal - Latest Jobs & Opportunities')
@section('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more')

@section('content')
    <style>
        .modern-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            min-height: 250px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
        }
        .modern-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            transform: translateY(-6px);
            border-color: #3b82f6;
        }
        .modern-card-header {
            padding: 16px 20px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            border-radius: 14px 14px 0 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        .modern-card-item {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            line-height: 1.6;
            transition: all 0.3s ease;
        }
        .modern-card-item:last-child {
            border-bottom: none;
        }
        .modern-card-item:hover {
            background: linear-gradient(90deg, #f0f9ff 0%, #e0f2fe 100%);
            padding-left: 26px;
            border-left: 4px solid #3b82f6;
        }
        .modern-card-item a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            transition: color 0.2s ease;
            font-size: 14px;
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

    <!-- Latest Posts - Card Grid Layout -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-fire text-orange-500"></i>
            Latest Updates
        </h2>
        
        <!-- All Posts in Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $allPosts = collect();
                foreach ($sections as $type => $posts) {
                    $allPosts = $allPosts->merge($posts);
                }
                $allPosts = $allPosts->sortByDesc('created_at')->take(12);
            @endphp
            
            @forelse ($allPosts as $post)
                <x-post-card :post="$post" />
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <i class="fa-solid fa-inbox text-6xl mb-4 opacity-50"></i>
                    <p class="text-lg">No posts available</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- View More Buttons by Type -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <a href="{{ route('posts.jobs') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-briefcase"></i>
            <span>All Jobs</span>
        </a>
        <a href="{{ route('posts.results') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-chart-bar"></i>
            <span>Results</span>
        </a>
        <a href="{{ route('posts.admit-cards') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-id-card"></i>
            <span>Admit Cards</span>
        </a>
        <a href="{{ route('posts.answer-keys') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-key"></i>
            <span>Answer Keys</span>
        </a>
        <a href="{{ route('posts.syllabus') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-book"></i>
            <span>Syllabus</span>
        </a>
        <a href="{{ route('posts.blogs') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-pen-fancy"></i>
            <span>Blogs</span>
        </a>
    </div>

    <!-- Old Column Layout Removed -->
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
                    
                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-2 mt-2 mb-2">
                        <!-- Vacancies -->
                        @if($post->total_posts)
                        <div class="flex items-center gap-1 text-xs bg-green-50 text-green-700 px-2 py-1 rounded font-semibold border border-green-200">
                            <i class="fa-solid fa-briefcase"></i>
                            <span>{{ number_format($post->total_posts) }} Posts</span>
                        </div>
                        @endif
                        
                        <!-- Last Date -->
                        @if($post->last_date)
                        <div class="flex items-center gap-1 text-xs bg-red-50 text-red-700 px-2 py-1 rounded font-semibold border border-red-200">
                            <i class="fa-solid fa-clock"></i>
                            <span>{{ $post->last_date->format('d M') }}</span>
                        </div>
                        @endif
                        
                        <!-- Category -->
                        @if($post->category)
                        <div class="flex items-center gap-1 text-xs bg-purple-50 text-purple-700 px-2 py-1 rounded font-semibold border border-purple-200">
                            <i class="fa-solid fa-tag"></i>
                            <span>{{ $post->category->name }}</span>
                        </div>
                        @endif
                        
                        <!-- State -->
                        @if($post->state)
                        <div class="flex items-center gap-1 text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded font-semibold border border-blue-200">
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <span>{{ $post->state->name }}</span>
                        </div>
                        @else
                        <div class="flex items-center gap-1 text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded font-semibold border border-indigo-200">
                            <i class="fa-solid fa-globe"></i>
                            <span>All India</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Posted Date & NEW Badge -->
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xs text-gray-500">
                            <i class="fa-solid fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
                        </span>
                        @if($post->created_at->diffInDays(now()) <= 3)
                        <span class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-bold">
                            <i class="fa-solid fa-star"></i> NEW
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
                    
                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-2 mt-2 mb-2">
                        <!-- Category -->
                        @if($post->category)
                        <div class="flex items-center gap-1 text-xs bg-purple-50 text-purple-700 px-2 py-1 rounded font-semibold border border-purple-200">
                            <i class="fa-solid fa-tag"></i>
                            <span>{{ $post->category->name }}</span>
                        </div>
                        @endif
                        
                        <!-- State -->
                        @if($post->state)
                        <div class="flex items-center gap-1 text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded font-semibold border border-blue-200">
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <span>{{ $post->state->name }}</span>
                        </div>
                        @else
                        <div class="flex items-center gap-1 text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded font-semibold border border-indigo-200">
                            <i class="fa-solid fa-globe"></i>
                            <span>All India</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Posted Date & NEW Badge -->
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xs text-gray-500">
                            <i class="fa-solid fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
                        </span>
                        @if($post->created_at->diffInDays(now()) <= 3)
                        <span class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-bold">
                            <i class="fa-solid fa-star"></i> NEW
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
                    
                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-2 mt-2 mb-2">
                        <!-- Category -->
                        @if($post->category)
                        <div class="flex items-center gap-1 text-xs bg-purple-50 text-purple-700 px-2 py-1 rounded font-semibold border border-purple-200">
                            <i class="fa-solid fa-tag"></i>
                            <span>{{ $post->category->name }}</span>
                        </div>
                        @endif
                        
                        <!-- State -->
                        @if($post->state)
                        <div class="flex items-center gap-1 text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded font-semibold border border-blue-200">
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <span>{{ $post->state->name }}</span>
                        </div>
                        @else
                        <div class="flex items-center gap-1 text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded font-semibold border border-indigo-200">
                            <i class="fa-solid fa-globe"></i>
                            <span>All India</span>
                        </div>
                        @endif
                        
                        <!-- Views -->
                        @if($post->view_count > 0)
                        <div class="flex items-center gap-1 text-xs bg-gray-50 text-gray-700 px-2 py-1 rounded font-semibold border border-gray-200">
                            <i class="fa-solid fa-eye"></i>
                            <span>{{ number_format($post->view_count) }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Posted Date & NEW Badge -->
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xs text-gray-500">
                            <i class="fa-solid fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
                        </span>
                        @if($post->created_at->diffInDays(now()) <= 3)
                        <span class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-bold">
                            <i class="fa-solid fa-star"></i> NEW
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
