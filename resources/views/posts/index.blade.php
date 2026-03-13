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

    <div x-data="{ 
        currentPage: 1, 
        isLoading: false, 
        hasMore: {{ $posts->hasMorePages() ? 'true' : 'false' }} 
    }">
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">{{ $title }}</h1>
            <p class="text-gray-600 text-sm"><i class="fas fa-list"></i> Showing <span x-text="(currentPage * 50)"></span> posts</p>
        </div>

        @if ($posts->count() > 0)
            <div class="space-y-0 mb-8" id="posts-container">
                @foreach ($posts as $post)
                    <div class="modern-list-item">
                        <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                        <div class="modern-list-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Load More Button -->
            <div x-show="hasMore" x-transition class="flex justify-center mt-8">
                <button 
                    @click="loadMore()"
                    :disabled="isLoading"
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:shadow-lg transition-all duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    <span x-show="!isLoading">
                        <i class="fas fa-chevron-down mr-2"></i>Load More Posts
                    </span>
                    <span x-show="isLoading" class="flex items-center gap-2">
                        <i class="fas fa-spinner fa-spin"></i>Loading...
                    </span>
                </button>
            </div>

            <!-- No More Posts Message -->
            <div x-show="!hasMore && currentPage > 1" x-transition class="text-center mt-8 text-gray-500">
                <p><i class="fas fa-check-circle"></i> All posts loaded</p>
            </div>
        @else
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border border-gray-200 p-12 text-center">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-base font-medium">No posts found</p>
            </div>
        @endif

        <script>
            function loadMore() {
                const xData = document.querySelector('[x-data]').__x.$data;
                if (xData.isLoading) return;

                xData.isLoading = true;
                xData.currentPage++;

                const type = '{{ $type }}';
                let routeName = '';
                
                // Map type to route name
                switch(type) {
                    case 'job':
                        routeName = '{{ route("posts.jobs.load-more") }}';
                        break;
                    case 'admit_card':
                        routeName = '{{ route("posts.admit-cards.load-more") }}';
                        break;
                    case 'result':
                        routeName = '{{ route("posts.results.load-more") }}';
                        break;
                    case 'answer_key':
                        routeName = '{{ route("posts.answer-keys.load-more") }}';
                        break;
                    case 'syllabus':
                        routeName = '{{ route("posts.syllabus.load-more") }}';
                        break;
                    case 'blog':
                        routeName = '{{ route("posts.blogs.load-more") }}';
                        break;
                }
                
                const url = `${routeName}?page=${xData.currentPage}`;

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const container = document.getElementById('posts-container');
                        container.insertAdjacentHTML('beforeend', html);
                        
                        // Check if there are more pages
                        if (!html.includes('modern-list-item') || html.trim().split('modern-list-item').length < 51) {
                            xData.hasMore = false;
                        }
                        
                        xData.isLoading = false;
                    })
                    .catch(error => {
                        console.error('Error loading more posts:', error);
                        xData.isLoading = false;
                        alert('Error loading more posts. Please try again.');
                    });
            }
        </script>
    </div>
@endsection
