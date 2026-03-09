@extends('layouts.app')

@section('title', $state->name . ' - Government Jobs')
@section('description', 'Latest government jobs in ' . $state->name)

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

    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">
            <i class="fas fa-map-marker-alt"></i> {{ $state->name }} - Government Jobs
        </h1>
        <p class="text-gray-600 text-sm"><i class="fas fa-briefcase"></i> All job opportunities in {{ $state->name }}</p>
    </div>

    <!-- Share Buttons -->
    <x-share-buttons />

    <!-- Three Column Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left Column: Jobs -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-blue-600">
                <i class="fas fa-briefcase"></i> Latest Jobs
            </div>
            <div>
                @forelse ($posts->where('type', 'job')->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
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
            <div class="modern-card-header bg-green-600">
                <i class="fas fa-chart-bar"></i> Exam Results
            </div>
            <div>
                @forelse ($posts->where('type', 'result')->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
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
            <div class="modern-card-header bg-purple-600">
                <i class="fas fa-id-card"></i> Admit Cards
            </div>
            <div>
                @forelse ($posts->where('type', 'admit_card')->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
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
    </div>

    <!-- Second Row: Answer Keys, Syllabus, Blogs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <!-- Answer Keys -->
        <div class="modern-card rounded-lg overflow-hidden">
            <div class="modern-card-header bg-yellow-600">
                <i class="fas fa-key"></i> Answer Keys
            </div>
            <div>
                @forelse ($posts->where('type', 'answer_key')->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
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
            <div class="modern-card-header bg-indigo-600">
                <i class="fas fa-book"></i> Syllabus
            </div>
            <div>
                @forelse ($posts->where('type', 'syllabus')->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
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
            <div class="modern-card-header bg-pink-600">
                <i class="fas fa-pen-fancy"></i> Blogs
            </div>
            <div>
                @forelse ($posts->where('type', 'blog')->take(50) as $post)
                <div class="modern-card-item">
                    <a href="{{ route('posts.show', ['type' => $post->type, 'post' => $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                    <div class="modern-card-item-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</div>
                </div>
                @empty
                <div class="modern-card-item text-gray-500">
                    No blogs found
                </div>
                @endforelse
            </div>
            <div class="modern-card-footer text-pink-600">
                <a href="{{ route('posts.blogs') }}">View All Blogs →</a>
            </div>
        </div>
    </div>
@endsection
