@extends('layouts.app')

@section('title', 'Government Job Portal - Latest Jobs & Opportunities')
@section('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more')

@section('content')
    <!-- India Map with State Job Counts -->

    <!-- Column Sections for Each Type -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Jobs Column -->
        <div>
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#eff6ff;border-left:4px solid #2563eb;border:1px solid #bfdbfe;">
                <span style="color:#1d4ed8;"><i class="fa-solid fa-briefcase"></i> Latest Jobs</span>
                <a href="{{ route('posts.jobs') }}" style="color:#2563eb;" class="text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-3">
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
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#fff7ed;border:1px solid #fed7aa;">
                <span style="color:#c2410c;"><i class="fa-solid fa-chart-bar"></i> Exam Results</span>
                <a href="{{ route('posts.results') }}" style="color:#ea580c;" class="text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-3">
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
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#faf5ff;border:1px solid #e9d5ff;">
                <span style="color:#7e22ce;"><i class="fa-solid fa-id-card"></i> Admit Cards</span>
                <a href="{{ route('posts.admit-cards') }}" style="color:#9333ea;" class="text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-3">
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
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#fefce8;border:1px solid #fde68a;">
                <span style="color:#92400e;"><i class="fa-solid fa-key"></i> Answer Keys</span>
                <a href="{{ route('posts.answer-keys') }}" style="color:#ca8a04;" class="text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-3">
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
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#eef2ff;border:1px solid #c7d2fe;">
                <span style="color:#3730a3;"><i class="fa-solid fa-book"></i> Syllabus</span>
                <a href="{{ route('posts.syllabus') }}" style="color:#4f46e5;" class="text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-3">
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
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#fdf2f8;border:1px solid #fbcfe8;">
                <span style="color:#9d174d;"><i class="fa-solid fa-pen-fancy"></i> Blogs</span>
                <a href="{{ route('posts.blogs') }}" style="color:#db2777;" class="text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-3">
                @foreach(($sections['blogs'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            @if(($sections['blogs'] ?? [])->count() > 25)
            <div class="mt-4">
                <a href="{{ route('posts.blogs') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-pink-500 hover:bg-pink-50 text-gray-700 hover:text-pink-600 font-semibold rounded-lg transition-all">
                    View All Blogs <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Scholarships Column -->
        <div>
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#f0fdfa;border:1px solid #99f6e4;">
                <span style="color:#0f766e;"><i class="fa-solid fa-graduation-cap"></i> Scholarships</span>
                <a href="{{ route('posts.scholarships') }}" style="color:#0d9488;" class="text-sm"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="space-y-3">
                @foreach(($sections['scholarships'] ?? [])->take(25) as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            @if(($sections['scholarships'] ?? [])->count() > 25)
            <div class="mt-4">
                <a href="{{ route('posts.scholarships') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-teal-500 hover:bg-teal-50 text-gray-700 hover:text-teal-600 font-semibold rounded-lg transition-all">
                    View All Scholarships <i class="fa-solid fa-arrow-right ml-1"></i>
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
