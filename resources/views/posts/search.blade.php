@extends('layouts.app')

@section('title', 'Search Results - Government Job Portal')
@section('description', 'Search results for: ' . $query)

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Search Results</h1>
        <p class="text-gray-600">
            @if ($query)
                Found {{ $posts->total() }} results for "<strong>{{ $query }}</strong>"
            @else
                Please enter a search query
            @endif
        </p>
    </div>

    @if ($posts->count() > 0)
        <div class="space-y-4 mb-8">
            @foreach ($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-8">
            @if ($posts->onFirstPage())
                <span class="text-gray-400">← Previous</span>
            @else
                <a href="{{ $posts->previousPageUrl() }}" class="text-blue-600 hover:text-blue-800">← Previous</a>
            @endif

            <div class="text-gray-600">
                Page {{ $posts->currentPage() }}
            </div>

            @if ($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}" class="text-blue-600 hover:text-blue-800">Next →</a>
            @else
                <span class="text-gray-400">Next →</span>
            @endif
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <p class="text-gray-500 text-lg">
                @if ($query)
                    No results found for "<strong>{{ $query }}</strong>"
                @else
                    Please enter a search query
                @endif
            </p>
        </div>
    @endif
@endsection
