@extends('layouts.app')

@section('title', 'Government Job Portal - Latest Jobs & Opportunities')
@section('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more')

@section('content')
    <!-- Featured Jobs Section with Category Badges -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">🔥 Featured Jobs</h2>
                <p class="text-gray-600 mt-1">Latest opportunities across categories</p>
            </div>
            <a href="{{ route('posts.jobs') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
                View All <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <!-- Category Filter Tabs -->
        <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
            <button class="filter-btn active" onclick="filterJobsByCategory('all')">
                <span class="badge-icon">📋</span> All Jobs
            </button>
            <button class="filter-btn" onclick="filterJobsByCategory('new')">
                <span class="badge-icon">🆕</span> New
            </button>
            <button class="filter-btn" onclick="filterJobsByCategory('urgent')">
                <span class="badge-icon">⚡</span> Urgent
            </button>
            <button class="filter-btn" onclick="filterJobsByCategory('banking')">
                <span class="badge-icon">🏦</span> Banking
            </button>
            <button class="filter-btn" onclick="filterJobsByCategory('railway')">
                <span class="badge-icon">🚂</span> Railway
            </button>
            <button class="filter-btn" onclick="filterJobsByCategory('ssc')">
                <span class="badge-icon">📝</span> SSC
            </button>
            <button class="filter-btn" onclick="filterJobsByCategory('upsc')">
                <span class="badge-icon">🎓</span> UPSC
            </button>
            <button class="filter-btn" onclick="filterJobsByCategory('allindia')">
                <span class="badge-icon">🇮🇳</span> All India
            </button>
        </div>

        <!-- Job Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="featuredJobsGrid">
            @forelse(($sections['jobs'] ?? [])->take(6) as $post)
                @php
                    $isNew = $post->created_at->diffInDays(now()) <= 7;
                    $isUrgent = $post->last_date && $post->last_date->diffInDays(now()) <= 7;
                @endphp
                <div class="job-card-featured bg-white rounded-lg border border-gray-200 hover:border-blue-400 hover:shadow-lg transition-all overflow-hidden"
                     data-is-new="{{ $isNew ? 'true' : 'false' }}"
                     data-is-urgent="{{ $isUrgent ? 'true' : 'false' }}"
                     data-category="{{ $post->category ? strtolower($post->category->name) : '' }}"
                     data-state="{{ $post->state ? strtolower($post->state->name) : '' }}">
                    <!-- Category Badge -->
                    <div class="flex gap-2 p-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                        @if($isNew)
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                🆕 New
                            </span>
                        @endif
                        @if($isUrgent)
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                ⚡ Urgent
                            </span>
                        @endif
                        @if($post->category)
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        @if($post->state && $post->state->name !== 'All India')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                {{ $post->state->name }}
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                                🇮🇳 All India
                            </span>
                        @endif
                    </div>

                    <!-- Card Content -->
                    <div class="p-4">
                        <!-- Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600">
                            <a href="{{ route('posts.show', [$post->type, $post->slug]) }}">{{ $post->title }}</a>
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ $post->short_description ?? substr(strip_tags($post->content), 0, 100) }}
                        </p>

                        <!-- Meta Info -->
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3 pb-3 border-b border-gray-100">
                            <span>
                                <i class="fa-solid fa-calendar-days"></i>
                                {{ $post->created_at->format('M d, Y') }}
                            </span>
                            @if($post->last_date)
                                <span class="text-red-600 font-semibold">
                                    <i class="fa-solid fa-hourglass-end"></i>
                                    {{ $post->last_date->format('M d') }}
                                </span>
                            @endif
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('posts.show', [$post->type, $post->slug]) }}" class="block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                            View Details <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No jobs available yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Column Sections for Each Type -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Jobs Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-briefcase"></i> Latest Jobs</span>
                <a href="{{ route('posts.jobs') }}" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['jobs'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            @if(($sections['jobs'] ?? [])->count() > 25)
            <div class="mt-4">
                <a href="{{ route('posts.jobs') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Jobs <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Results Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-chart-bar"></i> Exam Results</span>
                <a href="{{ route('posts.results') }}" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['results'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            @if(($sections['results'] ?? [])->count() > 25)
            <div class="mt-4">
                <a href="{{ route('posts.results') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Results <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Admit Cards Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-id-card"></i> Admit Cards</span>
                <a href="{{ route('posts.admit-cards') }}" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['admit_cards'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            @if(($sections['admit_cards'] ?? [])->count() > 25)
            <div class="mt-4">
                <a href="{{ route('posts.admit-cards') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Admit Cards <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Answer Keys Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-key"></i> Answer Keys</span>
                <a href="{{ route('posts.answer-keys') }}" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['answer_keys'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            @if(($sections['answer_keys'] ?? [])->count() > 25)
            <div class="mt-4">
                <a href="{{ route('posts.answer-keys') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Answer Keys <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Syllabus Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-book"></i> Syllabus</span>
                <a href="{{ route('posts.syllabus') }}" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['syllabus'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            @if(($sections['syllabus'] ?? [])->count() > 25)
            <div class="mt-4">
                <a href="{{ route('posts.syllabus') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Syllabus <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Blogs Column -->
        <div>
            <div class="bg-white border border-gray-300 px-4 py-3 text-gray-800 font-bold flex items-center justify-between rounded-lg mb-4">
                <span><i class="fa-solid fa-pen-fancy"></i> Blogs</span>
                <a href="{{ route('posts.blogs') }}" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['blogs'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            @if(($sections['blogs'] ?? [])->count() > 25)
            <div class="mt-4">
                <a href="{{ route('posts.blogs') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-semibold rounded-lg transition-all">
                    View All Blogs <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Share Section -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-0 shadow-sm">
        <h3 class="font-bold text-gray-900 mb-4 text-base flex items-center gap-2">
            <i class="fas fa-share-alt"></i> Follow & Share
        </h3>
        
        @php
            $shareUrl = route('home');
            $shareTitle = 'JobOne - Latest Government Jobs, Results, Admit Cards';
            $simpleMessage = "{$shareTitle} - Visit: {$shareUrl}";
            $encodedSimpleMessage = urlencode($simpleMessage);
            $encodedUrl = urlencode($shareUrl);
            $encodedTitle = urlencode($shareTitle);
        @endphp
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- WhatsApp -->
            <a href="https://wa.me/?text={{ $encodedSimpleMessage }}" 
               target="_blank" 
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #25D366;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-whatsapp" style="font-size: 20px;"></i>
                </div>
                <span>WhatsApp</span>
            </a>
            
            <!-- Telegram -->
            <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #0088cc;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-telegram" style="font-size: 20px;"></i>
                </div>
                <span>Telegram</span>
            </a>
            
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #1877F2;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-facebook" style="font-size: 20px;"></i>
                </div>
                <span>Facebook</span>
            </a>
            
            <!-- Twitter -->
            <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
               target="_blank"
               rel="noopener noreferrer"
               style="display: flex; align-items: center; gap: 12px; padding: 10px 20px; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: 0.3s; background: #1DA1F2;"
               onmouseover="this.style.transform='scale(1.05)'" 
               onmouseout="this.style.transform='scale(1)'">
                <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                    <i class="fab fa-twitter" style="font-size: 20px;"></i>
                </div>
                <span>Twitter</span>
            </a>
        </div>
    </div>
@endsection
