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
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#fff7ed;border-left:4px solid #ea580c;border:1px solid #fed7aa;">
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
                <a href="{{ route('posts.results') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-orange-500 hover:bg-orange-50 text-gray-700 hover:text-orange-600 font-semibold rounded-lg transition-all">
                    View All Results <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Admit Cards Column -->
        <div>
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#faf5ff;border-left:4px solid #9333ea;border:1px solid #e9d5ff;">
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
                <a href="{{ route('posts.admit-cards') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-purple-500 hover:bg-purple-50 text-gray-700 hover:text-purple-600 font-semibold rounded-lg transition-all">
                    View All Admit Cards <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Answer Keys Column -->
        <div>
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#fefce8;border-left:4px solid #ca8a04;border:1px solid #fde68a;">
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
                <a href="{{ route('posts.answer-keys') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-yellow-500 hover:bg-yellow-50 text-gray-700 hover:text-yellow-600 font-semibold rounded-lg transition-all">
                    View All Answer Keys <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Syllabus Column -->
        <div>
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#eef2ff;border-left:4px solid #4f46e5;border:1px solid #c7d2fe;">
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
                <a href="{{ route('posts.syllabus') }}" class="block text-center px-4 py-3 bg-white border border-gray-300 hover:border-indigo-500 hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-semibold rounded-lg transition-all">
                    View All Syllabus <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Blogs Column -->
        <div>
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#fdf2f8;border-left:4px solid #db2777;border:1px solid #fbcfe8;">
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
            <div class="px-4 py-3 font-bold flex items-center justify-between rounded-lg mb-3" style="background:#f0fdfa;border-left:4px solid #0d9488;border:1px solid #99f6e4;">
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
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6 shadow-sm">
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
            <a href="https://wa.me/?text={{ $encodedSimpleMessage }}" target="_blank" rel="noopener noreferrer"
               style="display:flex;align-items:center;gap:12px;padding:10px 20px;color:white;text-decoration:none;border-radius:10px;font-weight:600;transition:0.3s;background:#25D366;"
               onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="background:rgba(255,255,255,0.2);width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:50%;"><i class="fab fa-whatsapp" style="font-size:20px;"></i></div>
                <span>WhatsApp</span>
            </a>
            <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedTitle }}" target="_blank" rel="noopener noreferrer"
               style="display:flex;align-items:center;gap:12px;padding:10px 20px;color:white;text-decoration:none;border-radius:10px;font-weight:600;transition:0.3s;background:#0088cc;"
               onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="background:rgba(255,255,255,0.2);width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:50%;"><i class="fab fa-telegram" style="font-size:20px;"></i></div>
                <span>Telegram</span>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" target="_blank" rel="noopener noreferrer"
               style="display:flex;align-items:center;gap:12px;padding:10px 20px;color:white;text-decoration:none;border-radius:10px;font-weight:600;transition:0.3s;background:#1877F2;"
               onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="background:rgba(255,255,255,0.2);width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:50%;"><i class="fab fa-facebook" style="font-size:20px;"></i></div>
                <span>Facebook</span>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" target="_blank" rel="noopener noreferrer"
               style="display:flex;align-items:center;gap:12px;padding:10px 20px;color:white;text-decoration:none;border-radius:10px;font-weight:600;transition:0.3s;background:#1DA1F2;"
               onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="background:rgba(255,255,255,0.2);width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:50%;"><i class="fab fa-twitter" style="font-size:20px;"></i></div>
                <span>Twitter</span>
            </a>
        </div>
    </div>

    {{-- ===================== SEO CONTENT SECTION ===================== --}}
    @php
        $yr = date('Y');
        $faqs = [
            ['q' => 'What is the latest government job notification for ' . $yr . '?',
             'a' => 'JobOne.in updates daily with the latest government job notifications for ' . $yr . '. Browse all openings for SSC, UPSC, Railways, Banking, State PSC, Defence and Police on our Jobs page.'],
            ['q' => 'How to get free job alert for sarkari naukri?',
             'a' => 'Subscribe to free job alert notifications by clicking the notification bell on JobOne.in. We send instant alerts for every new sarkari naukri posting across India.'],
            ['q' => 'How to download admit card / hall ticket?',
             'a' => 'Visit the Admit Cards section, find your exam, and click the official link. We provide direct links to official government websites for admit card and hall ticket download.'],
            ['q' => 'How to check sarkari result ' . $yr . '?',
             'a' => 'Go to the Results section on JobOne.in for the latest sarkari result ' . $yr . '. We post SSC, UPSC, Railways, Banking, State PSC results with merit list and cut off marks.'],
            ['q' => 'What qualifications are needed for government jobs?',
             'a' => 'Qualifications vary by post. Group D & police jobs require 10th/12th pass. Clerical posts require graduation. UPSC IAS, SSC CGL, and banking PO require any degree from a recognized university.'],
            ['q' => 'Is JobOne.in free?',
             'a' => 'Yes! JobOne.in is completely free. Browse unlimited job notifications, download admit cards, check results — no registration required, no fees.'],
        ];
        $quickLinks = [
            ['label' => 'Latest Jobs ' . $yr, 'route' => 'posts.jobs',        'icon' => 'fa-briefcase',       'color' => '#2563eb'],
            ['label' => 'Sarkari Result',      'route' => 'posts.results',     'icon' => 'fa-chart-bar',       'color' => '#ea580c'],
            ['label' => 'Admit Card',          'route' => 'posts.admit-cards', 'icon' => 'fa-id-card',         'color' => '#9333ea'],
            ['label' => 'Answer Key',          'route' => 'posts.answer-keys', 'icon' => 'fa-key',             'color' => '#ca8a04'],
            ['label' => 'Exam Syllabus',       'route' => 'posts.syllabus',    'icon' => 'fa-book',            'color' => '#4f46e5'],
            ['label' => 'Scholarships',        'route' => 'posts.scholarships','icon' => 'fa-graduation-cap',  'color' => '#0d9488'],
            ['label' => 'SSC Jobs',            'route' => 'posts.jobs',        'icon' => 'fa-building-columns','color' => '#be185d'],
            ['label' => 'UPSC Jobs',           'route' => 'posts.jobs',        'icon' => 'fa-landmark',        'color' => '#7c3aed'],
        ];
        $tags = ['SSC Jobs','UPSC Jobs','Railway Jobs','Banking Jobs','State PSC','Defence Jobs','Police Jobs','Teaching Jobs','Sarkari Result','Admit Card','Answer Key','Syllabus PDF'];
    @endphp

    <div class="space-y-6 mb-8">

        <!-- About -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-600"></i>
                About JobOne.in – India's Trusted Sarkari Naukri Portal
            </h2>
            <div class="text-sm text-gray-600 leading-relaxed space-y-2">
                <p><strong>JobOne.in</strong> is India's most trusted <strong>government job portal</strong> providing the latest <strong>sarkari naukri</strong>, <strong>sarkari result</strong>, admit cards, answer keys, and exam syllabus — completely free. We cover <strong>SSC</strong>, <strong>UPSC</strong>, <strong>Railways</strong>, <strong>Banking</strong>, <strong>State PSC</strong>, <strong>Defence</strong>, <strong>Police</strong>, <strong>Teaching</strong>, and more.</p>
                <p>Get instant <strong>free job alerts</strong> for every new government recruitment notification. Our team updates all <strong>sarkari naukri {{ $yr }}</strong> job listings daily. Whether you are looking for <strong>central government jobs</strong>, <strong>state government jobs</strong>, or <strong>PSU jobs</strong> — JobOne.in has it all.</p>
                <p>We also provide <strong>hall ticket download</strong> links, <strong>exam results {{ $yr }}</strong>, official <strong>answer keys</strong>, detailed <strong>exam syllabus PDF</strong>, cut-off marks, merit lists — all free in one place.</p>
            </div>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($tags as $seoTag)
                <a href="{{ route('search') }}?q={{ urlencode($seoTag) }}"
                   class="text-xs px-3 py-1 rounded-full border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition-all font-medium">
                    {{ $seoTag }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- FAQ -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-circle-question text-indigo-600"></i>
                Frequently Asked Questions (FAQ)
            </h2>
            <div class="divide-y divide-gray-100">
                @foreach($faqs as $faq)
                <details class="py-3">
                    <summary class="flex justify-between items-center cursor-pointer text-sm font-semibold text-gray-800 list-none hover:text-blue-600">
                        <span>{{ $faq['q'] }}</span>
                        <i class="fas fa-plus text-gray-400 text-xs ml-2 flex-shrink-0"></i>
                    </summary>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed pl-1">{{ $faq['a'] }}</p>
                </details>
                @endforeach
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-link text-green-600"></i> Quick Links
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                @foreach($quickLinks as $ql)
                <a href="{{ route($ql['route']) }}"
                   class="flex items-center gap-2 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition-all font-medium text-gray-700 hover:text-blue-700">
                    <i class="fas {{ $ql['icon'] }}" style="color:{{ $ql['color'] }};font-size:15px;"></i>
                    {{ $ql['label'] }}
                </a>
                @endforeach
            </div>
        </div>

    </div>

@endsection
