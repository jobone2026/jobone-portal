@extends('layouts.app')

@php
    $typeLabel = ucfirst(str_replace('_', ' ', $type ?? 'Post'));
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
                        <div class="modern-list-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @else
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border border-gray-200 p-12 text-center">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-base font-medium">No posts found</p>
            </div>
        @endif
    </div>
@endsection
