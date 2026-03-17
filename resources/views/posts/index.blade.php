@extends('layouts.app')

@php
    if ($type === 'all') {
        $typeLabel = 'All Posts';
    } else {
        $typeLabel = ucfirst(str_replace('_', ' ', $type ?? 'Post'));
    }
    
    if (isset($category)) {
        $title = $category->name . ' - ' . $typeLabel;
    } elseif (isset($state)) {
        $title = $state->name . ' - ' . $typeLabel;
    } else {
        $title = $typeLabel;
    }
@endphp

@section('title', $title . ' - Government Job Portal')
@section('description', 'Browse all ' . strtolower($title) . ' on Government Job Portal')

@section('content')
    <style>
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
            transition: all 0.2s ease;
        }
        .modern-card-item:last-child {
            border-bottom: none;
        }
        .modern-card-item:hover {
            background: #f8f9fa;
            padding-left: 20px;
        }
        .modern-card-item a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
            display: block;
            margin-bottom: 4px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .modern-card-item a:hover {
            color: #0052a3;
            text-decoration: underline;
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
            background: #e8f5e9;
            color: #2e7d32;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
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
                word-wrap: break-word;
                overflow-wrap: break-word;
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
    </style>

    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">{{ $title }}</h1>
        <p class="text-gray-600 text-sm"><i class="fas fa-list"></i> Showing {{ $posts->count() }} of {{ $posts->total() }} posts</p>
    </div>

    @if ($posts->count() > 0)
        @php
            // Use sections data if available (for 'all' type), otherwise group from posts
            if (isset($sections)) {
                $sectionsData = $sections;
            } else {
                $sectionsData = [
                    'jobs' => $posts->where('type', 'job'),
                    'results' => $posts->where('type', 'result'),
                    'admit_cards' => $posts->where('type', 'admit_card'),
                    'answer_keys' => $posts->where('type', 'answer_key'),
                    'syllabus' => $posts->where('type', 'syllabus'),
                    'blogs' => $posts->where('type', 'blog')
                ];
            }
        @endphp

        <!-- Six Column Layout - Different Post Types -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-4">
            <!-- Jobs -->
            <div class="modern-card rounded-lg overflow-hidden">
                <div class="modern-card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-briefcase"></i> Jobs
                </div>
                <div>
                    @forelse ($sectionsData['jobs'] as $post)
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
                        No jobs found
                    </div>
                    @endforelse
                </div>
                <div class="modern-card-footer">
                    <a href="{{ route('posts.jobs') }}" class="text-emerald-600">
                        <span>{{ $sectionsData['jobs']->count() }} jobs</span>
                    </a>
                </div>
            </div>

            <!-- Results -->
            <div class="modern-card rounded-lg overflow-hidden">
                <div class="modern-card-header" style="background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);">
                    <i class="fas fa-chart-bar"></i> Results
                </div>
                <div>
                    @forelse ($sectionsData['results'] as $post)
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
                <div class="modern-card-footer">
                    <a href="{{ route('posts.results') }}" class="text-teal-600">
                        <span>{{ $sectionsData['results']->count() }} results</span>
                    </a>
                </div>
            </div>

            <!-- Admit Cards -->
            <div class="modern-card rounded-lg overflow-hidden">
                <div class="modern-card-header" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                    <i class="fas fa-id-card"></i> Admit Cards
                </div>
                <div>
                    @forelse ($sectionsData['admit_cards'] as $post)
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
                <div class="modern-card-footer">
                    <a href="{{ route('posts.admit-cards') }}" class="text-cyan-600">
                        <span>{{ $sectionsData['admit_cards']->count() }} admit cards</span>
                    </a>
                </div>
            </div>

            <!-- Answer Keys -->
            <div class="modern-card rounded-lg overflow-hidden">
                <div class="modern-card-header" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                    <i class="fas fa-key"></i> Answer Keys
                </div>
                <div>
                    @forelse ($sectionsData['answer_keys'] as $post)
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
                <div class="modern-card-footer">
                    <a href="{{ route('posts.answer-keys') }}" class="text-indigo-600">
                        <span>{{ $sectionsData['answer_keys']->count() }} answer keys</span>
                    </a>
                </div>
            </div>

            <!-- Syllabus -->
            <div class="modern-card rounded-lg overflow-hidden">
                <div class="modern-card-header" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                    <i class="fas fa-book"></i> Syllabus
                </div>
                <div>
                    @forelse ($sectionsData['syllabus'] as $post)
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
                <div class="modern-card-footer">
                    <a href="{{ route('posts.syllabus') }}" class="text-violet-600">
                        <span>{{ $sectionsData['syllabus']->count() }} syllabus</span>
                    </a>
                </div>
            </div>

            <!-- Blogs -->
            <div class="modern-card rounded-lg overflow-hidden">
                <div class="modern-card-header" style="background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);">
                    <i class="fas fa-pen-fancy"></i> Blogs
                </div>
                <div>
                    @forelse ($sectionsData['blogs'] as $post)
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
                    <a href="{{ route('posts.blogs') }}" class="text-orange-600">
                        <span>{{ $sectionsData['blogs']->count() }} blogs</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pagination Links -->
        @if($posts->hasPages())
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
        @endif
    @else
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border border-gray-200 p-12 text-center">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-base font-medium">No posts found</p>
        </div>
    @endif
@endsection
