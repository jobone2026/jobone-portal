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
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">{{ $title }}</h1>
        <p class="text-gray-600 text-sm"><i class="fas fa-list"></i> Showing {{ $posts->count() }} of {{ $posts->total() }} posts</p>
    </div>

    @if ($posts->count() > 0)
        <!-- Grid of Post Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach ($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
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
