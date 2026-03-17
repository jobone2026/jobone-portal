@extends('layouts.app')

@section('title', $category->name . ' - Government Jobs')
@section('description', 'Latest government jobs in ' . $category->name)

@section('content')
    <style>
        .post-type-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .post-type-badge.job {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }
        .post-type-badge.result {
            background: linear-gradient(135deg, #10b981, #047857);
            color: white;
        }
        .post-type-badge.admit_card {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
        }
        .post-type-badge.answer_key {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        .post-type-badge.syllabus {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
        }
        .post-type-badge.blog {
            background: linear-gradient(135deg, #ec4899, #db2777);
            color: white;
        }
        .single-column-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .single-column-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }
        .single-column-card h3 {
            margin: 0 0 8px 0;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.4;
        }
        .single-column-card h3 a {
            color: #1f2937;
            text-decoration: none;
        }
        .single-column-card h3 a:hover {
            color: #3b82f6;
        }
        .single-column-card-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            font-size: 12px;
            color: #6b7280;
            margin-top: 8px;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .meta-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 2px 6px;
            background: #f3f4f6;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            color: #374151;
        }
        .meta-badge.category {
            background: #dbeafe;
            color: #1d4ed8;
        }
        .meta-badge.state {
            background: #fce7f3;
            color: #be185d;
        }
        .meta-badge.views {
            background: #fed7aa;
            color: #c2410c;
        }
        .meta-badge.new {
            background: #dcfce7;
            color: #166534;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>

    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">
            <i class="fas fa-folder"></i> {{ $category->name }}
        </h1>
        <p class="text-gray-600 text-sm"><i class="fas fa-briefcase"></i> All posts in {{ $category->name }} category ({{ $posts->total() }} total)</p>
    </div>

    <!-- Six Column Layout - Different Post Types for This Category -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left Column: Jobs -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-blue-600">
                <i class="fas fa-briefcase"></i> Jobs in {{ $category->name }}
            </div>
            <div>
                @forelse ($posts->where('type', 'job') as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
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
            <div class="modern-card-footer text-blue-600">
                <span>{{ $posts->where('type', 'job')->count() }} jobs</span>
            </div>
        </div>

        <!-- Middle Column: Results -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-green-600">
                <i class="fas fa-chart-bar"></i> Results in {{ $category->name }}
            </div>
            <div>
                @forelse ($posts->where('type', 'result') as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
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
                <span>{{ $posts->where('type', 'result')->count() }} results</span>
            </div>
        </div>

        <!-- Right Column: Admit Cards -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-purple-600">
                <i class="fas fa-id-card"></i> Admit Cards in {{ $category->name }}
            </div>
            <div>
                @forelse ($posts->where('type', 'admit_card') as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
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
                <span>{{ $posts->where('type', 'admit_card')->count() }} admit cards</span>
            </div>
        </div>
    </div>

    <!-- Second Row: Answer Keys, Syllabus, Blogs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <!-- Answer Keys -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-yellow-600">
                <i class="fas fa-key"></i> Answer Keys in {{ $category->name }}
            </div>
            <div>
                @forelse ($posts->where('type', 'answer_key') as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
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
                <span>{{ $posts->where('type', 'answer_key')->count() }} answer keys</span>
            </div>
        </div>

        <!-- Syllabus -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-indigo-600">
                <i class="fas fa-book"></i> Syllabus in {{ $category->name }}
            </div>
            <div>
                @forelse ($posts->where('type', 'syllabus') as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
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
                <span>{{ $posts->where('type', 'syllabus')->count() }} syllabus</span>
            </div>
        </div>

        <!-- Blogs -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-pink-600">
                <i class="fas fa-pen-fancy"></i> Blogs in {{ $category->name }}
            </div>
            <div>
                @forelse ($posts->where('type', 'blog') as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date">
                        <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
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
            <div class="modern-card-footer text-pink-600">
                <span>{{ $posts->where('type', 'blog')->count() }} blogs</span>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
    @endif
@endsection
