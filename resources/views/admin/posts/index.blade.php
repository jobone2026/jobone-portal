@extends('layouts.admin')

@section('title', 'Posts Management')

@section('content')
    <div x-data="{ 
        selectedPosts: [], 
        selectAll: false, 
        showFilters: false
    }" class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                        <i class="fas fa-newspaper text-blue-500"></i>
                        Posts Management
                    </h2>
                    <p class="text-slate-600 mt-1">Manage all your content in one place</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <button @click="showFilters = !showFilters" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-filter"></i>
                        <span>Filters</span>
                    </button>
                    <a href="{{ route('admin.posts.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-xl hover:shadow-lg transition-all duration-200 flex items-center gap-2 font-medium">
                        <i class="fas fa-plus"></i>
                        <span>New Post</span>
                    </a>
                </div>
            </div>
            
            <!-- Filters Section -->
            <div x-show="showFilters" x-transition class="mt-4 pt-4 border-t border-slate-200">
                <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap items-end gap-3">
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Type</label>
                        <select name="type" class="w-full px-2 py-1.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                            <option value="">All Types</option>
                            <option value="job" {{ request('type') == 'job' ? 'selected' : '' }}>Jobs</option>
                            <option value="result" {{ request('type') == 'result' ? 'selected' : '' }}>Results</option>
                            <option value="admit_card" {{ request('type') == 'admit_card' ? 'selected' : '' }}>Admit Cards</option>
                            <option value="answer_key" {{ request('type') == 'answer_key' ? 'selected' : '' }}>Answer Keys</option>
                            <option value="syllabus" {{ request('type') == 'syllabus' ? 'selected' : '' }}>Syllabus</option>
                            <option value="blog" {{ request('type') == 'blog' ? 'selected' : '' }}>Blogs</option>
                        </select>
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full px-2 py-1.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                            <option value="">All Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Category</label>
                        <select name="category_id" class="w-full px-2 py-1.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs font-medium text-slate-700 mb-1">State</label>
                        <select name="state_id" class="w-full px-2 py-1.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                            <option value="">All States</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." class="w-full px-2 py-1.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-1.5 rounded-lg hover:bg-blue-700 transition text-xs font-medium whitespace-nowrap">
                            <i class="fas fa-search mr-1"></i>Apply
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="bg-slate-200 text-slate-700 px-4 py-1.5 rounded-lg hover:bg-slate-300 transition text-xs font-medium whitespace-nowrap">
                            <i class="fas fa-times mr-1"></i>Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bulk Actions Bar -->
        <div x-show="selectedPosts.length > 0" x-transition class="bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-2xl p-4 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    <span class="font-semibold text-slate-700">
                        <span x-text="selectedPosts.length"></span> post(s) selected
                    </span>
                </div>
                
                <form action="{{ route('admin.posts.bulk-action') }}" method="POST" class="flex flex-wrap gap-2" id="bulkActionForm">
                    @csrf
                    <template x-for="postId in selectedPosts" :key="postId">
                        <input type="hidden" name="posts[]" :value="postId">
                    </template>
                    
                    <button type="submit" name="action" value="publish" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg transition-all duration-200 text-sm font-medium flex items-center gap-2">
                        <i class="fas fa-eye"></i>
                        Publish
                    </button>
                    <button type="submit" name="action" value="unpublish" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-all duration-200 text-sm font-medium flex items-center gap-2">
                        <i class="fas fa-eye-slash"></i>
                        Unpublish
                    </button>
                    <button type="submit" name="action" value="delete" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200 text-sm font-medium flex items-center gap-2" onclick="return confirm('Delete selected posts?')">
                        <i class="fas fa-trash"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if ($posts->count() > 0)
            <!-- Posts Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" @change="selectAll = !selectAll; selectedPosts = selectAll ? {{ json_encode($posts->pluck('id')->toArray()) }} : []" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">Post Details</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">Type & Category</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">Analytics</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($posts as $post)
                                <tr class="hover:bg-slate-50 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" :value="{{ $post->id }}" 
                                            @change="selectedPosts.includes({{ $post->id }}) ? selectedPosts = selectedPosts.filter(id => id !== {{ $post->id }}) : selectedPosts.push({{ $post->id }})"
                                            :checked="selectedPosts.includes({{ $post->id }})"
                                            class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-gradient-to-br from-slate-200 to-slate-300 rounded-xl flex items-center justify-center flex-shrink-0">
                                                @switch($post->type)
                                                    @case('job')
                                                        <i class="fas fa-briefcase text-slate-600"></i>
                                                        @break
                                                    @case('result')
                                                        <i class="fas fa-chart-bar text-slate-600"></i>
                                                        @break
                                                    @case('admit_card')
                                                        <i class="fas fa-id-card text-slate-600"></i>
                                                        @break
                                                    @case('answer_key')
                                                        <i class="fas fa-key text-slate-600"></i>
                                                        @break
                                                    @case('syllabus')
                                                        <i class="fas fa-book text-slate-600"></i>
                                                        @break
                                                    @case('blog')
                                                        <i class="fas fa-pen-fancy text-slate-600"></i>
                                                        @break
                                                    @default
                                                        <i class="fas fa-file text-slate-600"></i>
                                                @endswitch
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-800 mb-1">{{ Str::limit($post->title, 40) }}</p>
                                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                                    <i class="fas fa-calendar"></i>
                                                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                                                    <span>•</span>
                                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                @switch($post->type)
                                                    @case('job') bg-blue-100 text-blue-800 @break
                                                    @case('result') bg-emerald-100 text-emerald-800 @break
                                                    @case('admit_card') bg-orange-100 text-orange-800 @break
                                                    @case('answer_key') bg-purple-100 text-purple-800 @break
                                                    @case('syllabus') bg-indigo-100 text-indigo-800 @break
                                                    @case('blog') bg-pink-100 text-pink-800 @break
                                                    @default bg-slate-100 text-slate-800
                                                @endswitch
                                            ">
                                                {{ ucfirst(str_replace('_', ' ', $post->type)) }}
                                            </span>
                                            <div class="text-xs text-slate-600">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ $post->category->name ?? 'No Category' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($post->is_published)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4 text-sm text-slate-600">
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-eye text-blue-500"></i>
                                                <span class="font-medium">{{ number_format($post->view_count) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 p-2 rounded-lg transition-all duration-200" title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <a href="{{ route('posts.show', [$post->type, $post]) }}" target="_blank" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 p-2 rounded-lg transition-all duration-200" title="View">
                                                <i class="fas fa-external-link-alt text-sm"></i>
                                            </a>
                                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg transition-all duration-200" title="Delete">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
                <div class="flex justify-center">
                    {{ $posts->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-slate-100">
                <div class="w-24 h-24 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-newspaper text-slate-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">No posts yet</h3>
                <p class="text-slate-600 mb-6">Get started by creating your first post</p>
                <a href="{{ route('admin.posts.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-200 inline-flex items-center gap-2 font-medium">
                    <i class="fas fa-plus"></i>
                    <span>Create First Post</span>
                </a>
            </div>
        @endif
    </div>

@endsection
