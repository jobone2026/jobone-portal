@extends('layouts.app')

@section('title', $state->name . ' - Government Jobs')
@section('description', 'Latest government jobs in ' . $state->name)

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">
            <i class="fas fa-map-marker-alt"></i> {{ $state->name }} - Government Jobs
        </h1>
        <p class="text-gray-600 text-sm"><i class="fas fa-briefcase"></i> Showing {{ $posts->count() }} of {{ $posts->total() }} posts in {{ $state->name }}</p>
    </div>

    <!-- Column Sections for Each Type -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Jobs Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-briefcase"></i> Jobs in {{ $state->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($posts->where('type', 'job') as $post)
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
                <span><i class="fa-solid fa-chart-bar"></i> Results in {{ $state->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($posts->where('type', 'result') as $post)
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
                <span><i class="fa-solid fa-id-card"></i> Admit Cards in {{ $state->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($posts->where('type', 'admit_card') as $post)
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
                <span><i class="fa-solid fa-key"></i> Answer Keys in {{ $state->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($posts->where('type', 'answer_key') as $post)
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
                <span><i class="fa-solid fa-book"></i> Syllabus in {{ $state->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($posts->where('type', 'syllabus') as $post)
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
                <span><i class="fa-solid fa-pen-fancy"></i> Blogs in {{ $state->name }}</span>
            </div>
            <div class="space-y-4">
                @forelse ($posts->where('type', 'blog') as $post)
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

    <!-- Pagination Links -->
    @if ($posts->hasPages())
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
    @endif
@endsection
