@extends('layouts.app')

@section('title', 'Government Job Portal - Latest Jobs & Opportunities')
@section('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more')

@section('content')
    <!-- Latest Posts - Card Grid Layout -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-fire text-orange-500"></i>
            Latest Updates
        </h2>
        
        <!-- All Posts in Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $allPosts = collect();
                foreach ($sections as $type => $posts) {
                    $allPosts = $allPosts->merge($posts);
                }
                $allPosts = $allPosts->sortByDesc('created_at')->take(12);
            @endphp
            
            @forelse ($allPosts as $post)
                <x-post-card :post="$post" />
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <i class="fa-solid fa-inbox text-6xl mb-4 opacity-50"></i>
                    <p class="text-lg">No posts available</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- View More Buttons by Type -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <a href="{{ route('posts.jobs') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-briefcase"></i>
            <span>All Jobs</span>
        </a>
        <a href="{{ route('posts.results') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-chart-bar"></i>
            <span>Results</span>
        </a>
        <a href="{{ route('posts.admit-cards') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-id-card"></i>
            <span>Admit Cards</span>
        </a>
        <a href="{{ route('posts.answer-keys') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-key"></i>
            <span>Answer Keys</span>
        </a>
        <a href="{{ route('posts.syllabus') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-book"></i>
            <span>Syllabus</span>
        </a>
        <a href="{{ route('posts.blogs') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
            <i class="fa-solid fa-pen-fancy"></i>
            <span>Blogs</span>
        </a>
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
