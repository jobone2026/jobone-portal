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
        .modern-list-item {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #e9ecef;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-bottom: 8px;
        }
        .modern-list-item:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        .modern-list-item a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            line-height: 1.5;
            display: block;
            margin-bottom: 4px;
        }
        .modern-list-item a:hover {
            color: #0052a3;
            text-decoration: underline;
        }
        .modern-list-item-date {
            font-size: 11px;
            color: #999;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 4px;
        }
        .modern-list-item-badge {
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
        .modern-list-item-badge.category {
            background: #e3f2fd;
            color: #1976d2;
        }
        .modern-list-item-badge.state {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        .modern-list-item-badge.views {
            background: #fff3e0;
            color: #e65100;
        }
        .modern-list-item-badge.new {
            background: #e8f5e9;
            color: #2e7d32;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>

    <div>
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">{{ $title }}</h1>
            <p class="text-gray-600 text-sm"><i class="fas fa-list"></i> Showing {{ $posts->count() }} of {{ $posts->total() }} posts</p>
        </div>

        @if ($posts->count() > 0)
            <div class="space-y-0 mb-8">
                @foreach ($posts as $post)
                    <div class="modern-list-item">
                        <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                        <div class="modern-list-item-date">
                            <span><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
                            @if($post->category)
                            <span class="modern-list-item-badge category">
                                <i class="fas fa-tag"></i> {{ $post->category->name }}
                            </span>
                            @endif
                            @if($post->state)
                            <span class="modern-list-item-badge state">
                                <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                            </span>
                            @endif
                            @if($post->view_count > 0)
                            <span class="modern-list-item-badge views">
                                <i class="fas fa-eye"></i> {{ number_format($post->view_count) }}
                            </span>
                            @endif
                            @if($post->created_at->diffInDays(now()) <= 3)
                            <span class="modern-list-item-badge new">
                                <i class="fas fa-star"></i> NEW
                            </span>
                            @endif
                            <span class="modern-list-item-badge type" style="background: 
                                @if($post->type == 'job') #e3f2fd; color: #1976d2;
                                @elseif($post->type == 'result') #e8f5e9; color: #2e7d32;
                                @elseif($post->type == 'admit_card') #f3e5f5; color: #7b1fa2;
                                @elseif($post->type == 'answer_key') #fff3e0; color: #e65100;
                                @elseif($post->type == 'syllabus') #e8eaf6; color: #3f51b5;
                                @elseif($post->type == 'blog') #fce4ec; color: #c2185b;
                                @else #f0f0f0; color: #666;
                                @endif">
                                <i class="fas fa-
                                    @if($post->type == 'job') briefcase
                                    @elseif($post->type == 'result') chart-bar
                                    @elseif($post->type == 'admit_card') id-card
                                    @elseif($post->type == 'answer_key') key
                                    @elseif($post->type == 'syllabus') book
                                    @elseif($post->type == 'blog') pen-fancy
                                    @else file
                                    @endif"></i> 
                                {{ ucfirst(str_replace('_', ' ', $post->type)) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $posts->links('vendor.pagination.custom') }}
            </div>
        @else
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border border-gray-200 p-12 text-center">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-base font-medium">No posts found</p>
            </div>
        @endif
    </div>
@endsection
