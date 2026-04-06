@extends('layouts.app')

@section('title', 'Government Job Portal - Latest Jobs & Opportunities')
@section('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more')

@section('content')
    <!-- Column Sections for Each Type -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Jobs Column -->
        <div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-4 py-3 text-white font-bold flex items-center justify-between rounded-t-lg mb-4">
                <span><i class="fa-solid fa-briefcase"></i> Latest Jobs</span>
                <a href="{{ route('posts.jobs') }}" class="text-white hover:text-gray-200 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['jobs'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
        </div>

        <!-- Results Column -->
        <div>
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-4 py-3 text-white font-bold flex items-center justify-between rounded-t-lg mb-4">
                <span><i class="fa-solid fa-chart-bar"></i> Exam Results</span>
                <a href="{{ route('posts.results') }}" class="text-white hover:text-gray-200 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['results'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
        </div>

        <!-- Admit Cards Column -->
        <div>
            <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 px-4 py-3 text-white font-bold flex items-center justify-between rounded-t-lg mb-4">
                <span><i class="fa-solid fa-id-card"></i> Admit Cards</span>
                <a href="{{ route('posts.admit-cards') }}" class="text-white hover:text-gray-200 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['admit_cards'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
        </div>

        <!-- Answer Keys Column -->
        <div>
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-4 py-3 text-white font-bold flex items-center justify-between rounded-t-lg mb-4">
                <span><i class="fa-solid fa-key"></i> Answer Keys</span>
                <a href="{{ route('posts.answer-keys') }}" class="text-white hover:text-gray-200 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['answer_keys'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
        </div>

        <!-- Syllabus Column -->
        <div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-4 py-3 text-white font-bold flex items-center justify-between rounded-t-lg mb-4">
                <span><i class="fa-solid fa-book"></i> Syllabus</span>
                <a href="{{ route('posts.syllabus') }}" class="text-white hover:text-gray-200 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['syllabus'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
        </div>

        <!-- Blogs Column -->
        <div>
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-4 py-3 text-white font-bold flex items-center justify-between rounded-t-lg mb-4">
                <span><i class="fa-solid fa-pen-fancy"></i> Blogs</span>
                <a href="{{ route('posts.blogs') }}" class="text-white hover:text-gray-200 text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-4">
                @foreach(($sections['blogs'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
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
