@extends('layouts.app')

@section('title', 'Government Job Portal - Latest Jobs & Opportunities')
@section('description', 'Find latest government jobs, admit cards, results, syllabus, answer keys and more')

@section('content')
    <!-- India Map with State Job Counts -->

    <!-- Welcome Modal (WhatsApp / Telegram) -->
    <div id="joinCommunityModal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-md hidden opacity-0 transition-opacity duration-300" style="z-index: 999999;">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300 relative" id="joinModalContent">
            
            <!-- Close Button (Clearly visible dark cross) -->
            <button type="button" onclick="closeJoinModal()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-800 transition-colors z-10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Clean Header -->
            <div class="pt-8 pb-4 px-6 text-center">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-blue-100">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-1">Stay Updated!</h3>
                <p class="text-gray-500 text-sm">Join our community for instant alerts</p>
            </div>
            
            <div class="px-6 pb-6 space-y-3">
                <!-- WhatsApp Option -->
                <a href="https://www.whatsapp.com/channel/0029VbD9cau2P59hFZ1nwh22" target="_blank" class="flex items-center gap-4 p-3 rounded-2xl transition-all group hover:opacity-90" style="background-color: #f0fdf4; border: 1px solid #bbf7d0; text-decoration: none;">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform flex-shrink-0" style="background-color: #25D366;">
                        <svg class="w-7 h-7" style="fill: #ffffff;" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 1.856.001 3.598.723 4.907 2.034 1.31 1.311 2.031 3.054 2.03 4.908-.001 3.825-3.113 6.938-6.937 6.938z"/></svg>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">Join WhatsApp Channel</div>
                        <div style="color: #6b7280; font-size: 0.75rem;">Jobone.in – Indian Govt Job Updates</div>
                    </div>
                </a>
                
                <!-- Telegram Option -->
                <a href="https://t.me/jobone2026" target="_blank" class="flex items-center gap-4 p-3 rounded-2xl transition-all group hover:opacity-90" style="background-color: #f0f9ff; border: 1px solid #bae6fd; text-decoration: none;">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform flex-shrink-0" style="background-color: #0088cc;">
                        <svg class="w-7 h-7" style="fill: #ffffff;" viewBox="0 0 24 24"><path d="M12 0A12 12 0 1 0 24 12 12.013 12.013 0 0 0 12 0Zm5.84 8.24l-1.95 9.21c-.14.63-.51.79-1.04.49l-2.88-2.12-1.39 1.34a.76.76 0 0 1-.54.22l.19-2.92 5.31-4.8c.23-.21-.05-.33-.36-.12L8.6 13.68l-2.83-.88c-.61-.19-.62-.61.13-.9l11.08-4.27c.52-.18.96.11.86.82Z"/></svg>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">Join Telegram Group</div>
                        <div style="color: #6b7280; font-size: 0.75rem;">Jobone.in – Indian Govt Job Updates</div>
                    </div>
                </a>
                
                <!-- Close option at bottom -->
                <button onclick="closeJoinModal()" class="w-full text-center mt-3 text-sm font-medium text-gray-400 hover:text-gray-600 no-underline py-2">
                    Maybe later, continue to site
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('joinCommunityModal');
            const content = document.getElementById('joinModalContent');
            
            // Move modal to body to prevent stacking context z-index issues from layouts
            document.body.appendChild(modal);
            
            // Only show if they haven't seen it before (jobone_alert_shown is null)
            if (!localStorage.getItem('jobone_alert_shown')) {
                // Short delay to let the page load before throwing a popup at them
                setTimeout(() => {
                    modal.classList.remove('hidden');
                    // Force DOM reflow to allow transition animation to play
                    void modal.offsetWidth; 
                    modal.classList.remove('opacity-0');
                    content.classList.remove('scale-95');
                    content.classList.add('scale-100');
                    
                    // Mark as shown so it doesn't bother them on subsequent visits
                    localStorage.setItem('jobone_alert_shown', 'true');
                }, 1200); 
            }
        });

        function closeJoinModal() {
            const modal = document.getElementById('joinCommunityModal');
            const content = document.getElementById('joinModalContent');
            
            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            
            // Hide completely after fade-out transition finishes
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
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

    <div class="space-y-4 md:space-y-6 mb-8">

        <!-- About -->
        <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 md:p-6 shadow-sm">
            <h2 class="text-sm sm:text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
                <div class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-50 flex-shrink-0">
                    <i class="fas fa-info text-blue-600 text-[10px]"></i>
                </div>
                About JobOne.in – India's Trusted Sarkari Naukri Portal
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                <div class="bg-gray-50 border border-gray-100 p-3 rounded-xl text-xs sm:text-sm text-gray-500 leading-relaxed">
                    <p><strong>JobOne.in</strong> is India's most trusted <strong>government job portal</strong> providing the latest <strong>sarkari naukri</strong>, <strong>sarkari result</strong>, admit cards, answer keys, and exam syllabus — completely free. We cover SSC, UPSC, Railways, Banking, State PSC, Defence, Police, and Teaching.</p>
                </div>
                <div class="bg-gray-50 border border-gray-100 p-3 rounded-xl text-xs sm:text-sm text-gray-500 leading-relaxed">
                    <p>Get instant <strong>free job alerts</strong> for every new government recruitment notification. Our team updates all <strong>sarkari naukri {{ $yr }}</strong> job listings daily. Whether you are looking for central government, state government, or PSU jobs — we have it all.</p>
                </div>
                <div class="bg-gray-50 border border-gray-100 p-3 rounded-xl text-xs sm:text-sm text-gray-500 leading-relaxed">
                    <p>We provide <strong>hall ticket download</strong> links, <strong>exam results {{ $yr }}</strong>, official <strong>answer keys</strong>, detailed <strong>exam syllabus PDF</strong>, cut-off marks, and merit lists — all completely free in one beautifully designed place.</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-1.5">
                @foreach($tags as $seoTag)
                <a href="{{ route('search') }}?q={{ urlencode($seoTag) }}"
                   class="text-[10px] sm:text-xs px-2 sm:px-3 py-1 rounded-md border border-blue-100 bg-blue-50/50 text-blue-600 hover:bg-blue-500 hover:border-blue-500 hover:text-white transition-all font-medium whitespace-nowrap">
                    {{ $seoTag }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- FAQ -->
        <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-6 md:p-8 shadow-sm">
            <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-5 flex items-center gap-2">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 flex-shrink-0">
                    <i class="fas fa-question text-indigo-600 text-sm"></i>
                </div>
                Frequently Asked Questions (FAQ)
            </h2>
            <div class="space-y-3">
                @foreach($faqs as $faq)
                <details class="group bg-gray-50 border border-gray-100 rounded-xl overflow-hidden [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex justify-between items-center cursor-pointer p-4 text-sm sm:text-base font-semibold text-gray-800 hover:text-blue-600 hover:bg-blue-50/50 transition-colors list-none">
                        <span>{{ $faq['q'] }}</span>
                        <span class="ml-4 flex-shrink-0 flex items-center justify-center w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 group-open:bg-blue-600 group-open:border-blue-600 group-open:text-white transition-all">
                            <i class="fas fa-plus text-[10px] group-open:hidden"></i>
                            <i class="fas fa-minus text-[10px] hidden group-open:block"></i>
                        </span>
                    </summary>
                    <div class="px-4 pb-4 pt-1 text-sm sm:text-base text-gray-600 leading-loose border-t border-gray-100 bg-white">
                        {{ $faq['a'] }}
                    </div>
                </details>
                @endforeach
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-6 md:p-8 shadow-sm">
            <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-50 flex-shrink-0">
                    <i class="fas fa-link text-green-600 text-sm"></i>
                </div>
                Quick Links
            </h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach($quickLinks as $ql)
                <a href="{{ route($ql['route']) }}"
                   class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50 hover:border-blue-300 hover:bg-blue-50 transition-all font-medium text-gray-700 hover:text-blue-700 shadow-sm hover:shadow-md">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-100 shadow-sm flex-shrink-0">
                        <i class="fas {{ $ql['icon'] }}" style="color:{{ $ql['color'] }};font-size:12px;"></i>
                    </div>
                    <span class="text-xs sm:text-sm leading-tight">{{ $ql['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

    </div>

@endsection
