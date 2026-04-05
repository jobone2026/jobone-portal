@extends('layouts.app')

@section('title', 'Search Results - Government Job Portal')
@section('description', 'Search results for: ' . $query)

@section('content')
    <!-- Premium Header Section -->
    <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <nav class="flex mb-3" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2">Search Results</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
                    Search Results
                </h1>
                <p class="text-gray-500 text-sm md:text-base flex items-center gap-2">
                    @if ($query)
                        Found <span class="font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded">{{ $posts->total() }}</span> results for "<strong class="text-gray-800">{{ $query }}</strong>"
                    @else
                        Please enter a search query
                    @endif
                </p>
            </div>
            
            <div class="flex items-center gap-3 bg-gray-50 p-2 rounded-xl border border-gray-100 w-full md:w-auto">
                <form action="{{ route('search') }}" method="GET" class="relative w-full">
                    <input type="text" name="q" placeholder="Search again..." value="{{ $query }}" 
                           class="w-full md:w-64 pl-10 pr-4 py-2 border-none bg-white rounded-lg focus:ring-2 focus:ring-blue-500 text-sm shadow-sm ring-1 ring-gray-200">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>
            </div>
        </div>
    </div>

    @if ($posts->count() > 0)
        <!-- Grid of Post Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <div class="transform hover:-translate-y-1 transition-all duration-300 h-full">
                    <x-post-card :post="$post" />
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="mt-12 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex justify-between items-center px-6">
            @if ($posts->onFirstPage())
                <span class="text-gray-400 flex items-center font-medium opacity-50"><svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Previous</span>
            @else
                <a href="{{ $posts->previousPageUrl() }}" class="text-blue-600 hover:text-blue-800 flex items-center font-medium transition-colors"><svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Previous</a>
            @endif

            <div class="text-gray-600 font-medium bg-gray-50 px-3 py-1 rounded-lg text-sm border border-gray-100">
                Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}
            </div>

            @if ($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}" class="text-blue-600 hover:text-blue-800 flex items-center font-medium transition-colors">Next <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
            @else
                <span class="text-gray-400 flex items-center font-medium opacity-50">Next <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>
            @endif
        </div>
        @endif
    @else
        <!-- Premium Empty State -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-white opacity-50 z-0"></div>
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-24 h-24 mb-6 bg-gray-50 rounded-full flex items-center justify-center shadow-inner">
                    <i class="fas fa-search text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    @if ($query)
                        No results found for "<span class="text-gray-900">{{ $query }}</span>"
                    @else
                        Please enter a search query
                    @endif
                </h3>
                <p class="text-gray-500 max-w-sm mx-auto mb-6">Try adjusting your keywords or search for a different organization or job title.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Home
                </a>
            </div>
        </div>
    @endif
@endsection
