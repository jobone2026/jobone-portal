@extends('layouts.app')

@section('title', $category->name . ' - Government Jobs')
@section('description', 'Latest government jobs in ' . $category->name)

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">
            <i class="fas fa-folder"></i> {{ $category->name }}
        </h1>
        <p class="text-gray-600 text-sm"><i class="fas fa-briefcase"></i> All posts in {{ $category->name }} category ({{ $posts->total() }} total)</p>
    </div>

    @php
        // Separate posts by type
        $jobPosts = $posts->where('type', 'job');
        $resultPosts = $posts->where('type', 'result');
        $admitCardPosts = $posts->where('type', 'admit_card');
        $answerKeyPosts = $posts->where('type', 'answer_key');
        $syllabusPosts = $posts->where('type', 'syllabus');
        $blogPosts = $posts->where('type', 'blog');
    @endphp

    <!-- Column Sections for Each Type -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Jobs Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-briefcase"></i> Jobs in {{ $category->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($jobPosts->take(25) as $post)
                    <x-post-card :post="$post" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No jobs found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Results Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-chart-bar"></i> Results in {{ $category->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($resultPosts->take(25) as $post)
                    <x-post-card :post="$post" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No results found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Admit Cards Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-id-card"></i> Admit Cards in {{ $category->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($admitCardPosts->take(25) as $post)
                    <x-post-card :post="$post" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No admit cards found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Answer Keys Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-key"></i> Answer Keys in {{ $category->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($answerKeyPosts->take(25) as $post)
                    <x-post-card :post="$post" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No answer keys found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Syllabus Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-book"></i> Syllabus in {{ $category->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($syllabusPosts->take(25) as $post)
                    <x-post-card :post="$post" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No syllabus found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Blogs Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-pen-fancy"></i> Blogs in {{ $category->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($blogPosts->take(25) as $post)
                    <x-post-card :post="$post" />
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
                        <p>No blogs found</p>
                    </div>
                @endforelse
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
