<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    @php
        $seoData = $seo ?? [
            'title' => 'JobOne.in - Latest Government Jobs, Admit Cards, Results & More',
            'description' => 'Find latest government job notifications, admit cards, results, answer keys, and syllabus for SSC, UPSC, Railways, Banking, State PSC, Defence, Police, and Teaching jobs across India.',
            'keywords' => 'government jobs, sarkari naukri, admit card, result, answer key, syllabus, SSC, UPSC, Railways, Banking',
            'canonical' => url()->current(),
            'og_title' => 'JobOne.in - Latest Government Jobs Portal',
            'og_description' => 'Your trusted source for government job notifications and exam updates',
            'og_image' => asset('images/og-image.jpg'),
            'og_url' => url()->current(),
        ];
    @endphp
    <x-seo-head :seo="$seoData" :schema="$schema ?? null" />
    
    <!-- Google Analytics -->
    @php
        $gaTrackingId = \App\Models\SiteSetting::where('key', 'ga_tracking_id')->value('value');
    @endphp
    @if($gaTrackingId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaTrackingId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaTrackingId }}', {
                'page_title': '{{ $seoData['title'] ?? 'JobOne.in' }}',
                'page_path': window.location.pathname
            });
            
            // Send page view with title
            gtag('event', 'page_view', {
                'page_title': '{{ $seoData['title'] ?? 'JobOne.in' }}',
                'page_path': window.location.pathname,
                'page_location': window.location.href
            });
            
            // Custom GA4 Events
            @if(isset($post))
            // Track post view
            gtag('event', 'post_view', {
                'post_id': '{{ $post->id }}',
                'post_type': '{{ $post->type }}',
                'category': '{{ $post->category->name ?? "Unknown" }}',
                'post_title': '{{ $post->title }}'
            });
            @endif
            
            // Track search events
            @if(request()->routeIs('search'))
            gtag('event', 'search', {
                'search_term': '{{ request()->input("q", "") }}'
            });
            @endif
            
            // Function to track share events
            function trackShare(method, url, title) {
                gtag('event', 'share', {
                    'method': method,
                    'content_type': 'post',
                    'item_id': url,
                    'item_name': title
                });
            }
        </script>
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Translate API -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,hi,te,ta,kn,ml,mr,gu,bn,pa,or,as'
            }, 'google_translate_element');
            
            // Wait for Google Translate to load
            setTimeout(function() {
                var combo = document.querySelector('.goog-te-combo');
                if (combo) {
                    // Restore saved language on page load
                    var savedLang = localStorage.getItem('selectedLanguage');
                    if (savedLang && savedLang !== 'en') {
                        combo.value = savedLang;
                        combo.dispatchEvent(new Event('change'));
                        
                        // Update dropdown to show selected language
                        var customSelect = document.getElementById('custom_language_select');
                        if (customSelect) {
                            customSelect.value = savedLang;
                        }
                    }
                    
                    // Sync custom dropdown with Google Translate
                    var customSelect = document.getElementById('custom_language_select');
                    if (customSelect) {
                        customSelect.addEventListener('change', function() {
                            if (this.value === '') {
                                // For English, reset Google Translate
                                combo.value = 'en';
                                combo.dispatchEvent(new Event('change'));
                                
                                // Clear localStorage
                                localStorage.removeItem('selectedLanguage');
                                
                                // Reload after a short delay to ensure translation is removed
                                setTimeout(function() {
                                    window.location.reload();
                                }, 500);
                            } else {
                                // For other languages
                                combo.value = this.value;
                                combo.dispatchEvent(new Event('change'));
                                localStorage.setItem('selectedLanguage', this.value);
                            }
                        });
                    }
                }
            }, 1500);
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    <!-- RTL Language Detection -->
    <script>
        // RTL languages
        const rtlLanguages = ['ar', 'he', 'ur', 'fa', 'yi'];
        
        function setRTL(lang) {
            const html = document.documentElement;
            if (rtlLanguages.includes(lang)) {
                html.setAttribute('dir', 'rtl');
                html.setAttribute('lang', lang);
            } else {
                html.setAttribute('dir', 'ltr');
                html.setAttribute('lang', 'en');
            }
        }
        
        // Check saved language on page load
        window.addEventListener('load', function() {
            const savedLang = localStorage.getItem('selectedLanguage');
            if (savedLang) {
                setRTL(savedLang);
            }
        });
        
        // Listen for language changes
        document.addEventListener('DOMContentLoaded', function() {
            const langSelect = document.getElementById('custom_language_select');
            if (langSelect) {
                langSelect.addEventListener('change', function() {
                    const lang = this.value || 'en';
                    setRTL(lang);
                });
            }
        });
    </script>
    
    <style>
        /* RTL Support */
        html[dir="rtl"] {
            direction: rtl;
            text-align: right;
        }
        
        html[dir="rtl"] body {
            direction: rtl;
        }
        
        html[dir="rtl"] .flex {
            flex-direction: row-reverse;
        }
        
        html[dir="rtl"] .text-left {
            text-align: right;
        }
        
        html[dir="rtl"] .text-right {
            text-align: left;
        }
        
        html[dir="rtl"] .ml-auto {
            margin-left: auto;
            margin-right: 0;
        }
        
        html[dir="rtl"] .mr-auto {
            margin-right: auto;
            margin-left: 0;
        }
        
        html[dir="rtl"] .pl-4 {
            padding-left: 0;
            padding-right: 1rem;
        }
        
        html[dir="rtl"] .pr-4 {
            padding-right: 0;
            padding-left: 1rem;
        }
        
        /* Hide Google Translate banner */
        .goog-te-banner-frame { 
            display: none !important; 
        }
        body { 
            top: 0 !important; 
        }
        
        /* Hide the top frame completely */
        body > .skiptranslate {
            display: none !important;
        }
        
        iframe.goog-te-banner-frame {
            display: none !important;
        }
        
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }
        
        /* Hide Google Translate widget completely */
        #google_translate_element {
            position: fixed;
            bottom: -200px;
            left: -200px;
            opacity: 0;
            pointer-events: none;
        }
        
        /* Custom language selector */
        #custom_language_select {
            padding: 4px 8px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            background-color: white;
            color: #4b5563;
            cursor: pointer;
            min-width: 60px;
            max-width: 80px;
        }
        
        #custom_language_select:hover {
            border-color: #3b82f6;
        }
    </style>
    

</head>
<body class="bg-gray-50">

    <!-- Breaking News Ticker -->
    <x-breaking-news-ticker />

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-50 to-indigo-50 shadow-sm sticky top-0 z-50 border-b border-blue-100">
        <nav class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-3 md:py-4">
            <div class="flex justify-between items-center gap-2">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center flex-shrink-0">
                    <img src="{{ asset('images/jobone-logo.png') }}" alt="JobOne.in" class="h-10 md:h-16 w-auto object-contain">
                </a>
                
                <!-- Custom Language Selector (visible on all screens) -->
                <div class="flex items-center gap-1 notranslate">
                    <i class="fas fa-globe text-blue-600 text-sm"></i>
                    <select id="custom_language_select" class="text-xs notranslate">
                        <option value="">English</option>
                        <option value="hi">हिंदी</option>
                        <option value="te">తెలుగు</option>
                        <option value="ta">தமிழ்</option>
                        <option value="kn">ಕನ್ನಡ</option>
                        <option value="ml">മലയാളം</option>
                        <option value="mr">मराठी</option>
                        <option value="gu">ગુજરાતી</option>
                        <option value="bn">বাংলা</option>
                        <option value="pa">ਪੰਜਾਬੀ</option>
                        <option value="or">ଓଡ଼ିଆ</option>
                        <option value="as">অসমীয়া</option>
                    </select>
                </div>
                
                <!-- Hidden Google Translate Widget -->
                <div id="google_translate_element"></div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('home') ? 'border-b-2 border-blue-600' : '' }} text-sm font-medium"><i class="fas fa-home"></i> Home</a>
                    <a href="{{ route('posts.jobs') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('posts.jobs') ? 'border-b-2 border-blue-600' : '' }} text-sm font-medium"><i class="fas fa-briefcase"></i> Jobs</a>
                    <a href="{{ route('posts.admit-cards') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('posts.admit-cards') ? 'border-b-2 border-blue-600' : '' }} text-sm font-medium"><i class="fas fa-id-card"></i> Admit</a>
                    <a href="{{ route('posts.results') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('posts.results') ? 'border-b-2 border-blue-600' : '' }} text-sm font-medium"><i class="fas fa-chart-bar"></i> Results</a>
                    <a href="{{ route('posts.syllabus') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('posts.syllabus') ? 'border-b-2 border-blue-600' : '' }} text-sm font-medium"><i class="fas fa-book"></i> Syllabus</a>
                    <a href="{{ route('posts.blogs') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->routeIs('posts.blogs') ? 'border-b-2 border-blue-600' : '' }} text-sm font-medium"><i class="fas fa-pen-fancy"></i> Blogs</a>
                </div>
                
                <!-- Search Bar -->
                <div x-data="{
                    query: '',
                    results: [],
                    showResults: false,
                    async search() {
                        if (this.query.length < 3) {
                            this.results = [];
                            this.showResults = false;
                            return;
                        }
                        const response = await fetch(`/search/autocomplete?q=${encodeURIComponent(this.query)}`);
                        this.results = await response.json();
                        this.showResults = this.results.length > 0;
                    },
                    selectResult(post) {
                        window.location.href = `/${post.type}/${post.slug}`;
                    }
                }" class="relative w-64 md:w-80">
                    <form action="{{ route('search') }}" method="GET" class="flex items-center gap-1">
                        <input 
                            type="text" 
                            name="q" 
                            x-model="query"
                            @input.debounce.300ms="search()"
                            @click.away="showResults = false"
                            placeholder="Search..." 
                            class="px-2 py-1.5 bg-blue-100 border border-blue-300 rounded-lg focus:outline-none focus:border-blue-500 focus:bg-white w-full text-xs"
                            autocomplete="off">
                        <button type="submit" class="px-2.5 py-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 font-medium text-xs shadow-md flex-shrink-0"><i class="fas fa-search"></i></button>
                    </form>
                    
                    <!-- Autocomplete Results -->
                    <div x-show="showResults" 
                         x-transition
                         class="absolute top-full right-0 mt-1 w-48 md:w-80 bg-white border border-gray-200 rounded-lg shadow-lg max-h-64 overflow-y-auto z-50">
                        <template x-for="post in results" :key="post.id">
                            <div @click="selectResult(post)" 
                                 class="px-3 py-2 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0">
                                <p class="text-xs text-gray-800 font-medium" x-text="post.title"></p>
                                <p class="text-xs text-gray-500 mt-0.5" x-text="post.type.replace('_', ' ').toUpperCase()"></p>
                            </div>
                        </template>
                    </div>
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden hidden text-gray-700" x-data="{ open: false }" @click="open = !open">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <!-- Mobile Navigation - Hidden (using bottom nav instead) -->
            <div class="md:hidden mt-4 space-y-2 hidden" x-show="open">
                <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 text-sm"><i class="fas fa-home"></i> Home</a>
                <a href="{{ route('posts.jobs') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 text-sm"><i class="fas fa-briefcase"></i> Jobs</a>
                <a href="{{ route('posts.admit-cards') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 text-sm"><i class="fas fa-id-card"></i> Admit Cards</a>
                <a href="{{ route('posts.results') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 text-sm"><i class="fas fa-chart-bar"></i> Results</a>
                <a href="{{ route('posts.syllabus') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 text-sm"><i class="fas fa-book"></i> Syllabus</a>
                <a href="{{ route('posts.blogs') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 text-sm"><i class="fas fa-pen-fancy"></i> Blogs</a>
                <form action="{{ route('search') }}" method="GET" class="flex gap-2 mt-4">
                    <input type="text" name="q" placeholder="Search..." class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none text-sm">
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </nav>
    </header>

    <!-- States Navigation Bar -->
    <div class="bg-white overflow-x-auto sticky top-[52px] md:top-16 z-40 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-1 py-2 flex-nowrap">
                @foreach ($states ?? [] as $state)
                    <a href="{{ route('states.show', $state) }}" class="px-3 py-1 bg-white text-blue-600 border border-blue-600 rounded text-xs font-semibold whitespace-nowrap hover:bg-blue-50">
                        {{ $state->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Categories Navigation Bar -->
    <div class="bg-gray-100 overflow-x-auto sticky top-[96px] md:top-32 z-40 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-1 py-2 flex-nowrap">
                @foreach ($categories ?? [] as $category)
                    <a href="{{ route('categories.show', $category) }}" class="px-3 py-1 bg-white text-gray-700 border border-gray-300 rounded text-xs font-semibold whitespace-nowrap hover:bg-gray-50">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Ad Slot - Header -->
    <x-ad-slot position="header" />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8">
            <!-- Content Area -->
            <div>
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Ad Slot - Footer -->
    <x-ad-slot position="footer" />

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-blue-50 to-indigo-50 text-gray-700 mt-12 border-t border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                <!-- About Section -->
                <div>
                    <h4 class="text-gray-900 font-semibold mb-3 text-sm flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i> About
                    </h4>
                    <ul class="space-y-1.5">
                        <li><a href="{{ route('pages.about') }}" class="text-gray-600 hover:text-blue-600 text-xs transition"><i class="fas fa-chevron-right text-xs"></i> About Us</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-gray-600 hover:text-blue-600 text-xs transition"><i class="fas fa-chevron-right text-xs"></i> Contact</a></li>
                    </ul>
                </div>
                
                <!-- Legal Section -->
                <div>
                    <h4 class="text-gray-900 font-semibold mb-3 text-sm flex items-center gap-2">
                        <i class="fas fa-shield-alt text-emerald-600"></i> Legal
                    </h4>
                    <ul class="space-y-1.5">
                        <li><a href="{{ route('pages.privacy') }}" class="text-gray-600 hover:text-emerald-600 text-xs transition"><i class="fas fa-chevron-right text-xs"></i> Privacy Policy</a></li>
                        <li><a href="{{ route('pages.disclaimer') }}" class="text-gray-600 hover:text-emerald-600 text-xs transition"><i class="fas fa-chevron-right text-xs"></i> Disclaimer</a></li>
                    </ul>
                </div>
                
                <!-- Social Section -->
                <div>
                    <h4 class="text-gray-900 font-semibold mb-3 text-sm flex items-center gap-2">
                        <i class="fas fa-share-alt text-purple-600"></i> Follow Us
                    </h4>
                    <ul class="space-y-1.5">
                        @php
                            $facebookUrl = \App\Models\SiteSetting::where('key', 'facebook_url')->value('value');
                            $twitterUrl = \App\Models\SiteSetting::where('key', 'twitter_url')->value('value');
                            $telegramUrl = \App\Models\SiteSetting::where('key', 'telegram_url')->value('value');
                        @endphp
                        @if($facebookUrl)
                            <li><a href="{{ $facebookUrl }}" target="_blank" class="text-gray-600 hover:text-purple-600 text-xs transition"><i class="fab fa-facebook"></i> Facebook</a></li>
                        @endif
                        @if($twitterUrl)
                            <li><a href="{{ $twitterUrl }}" target="_blank" class="text-gray-600 hover:text-purple-600 text-xs transition"><i class="fab fa-twitter"></i> Twitter</a></li>
                        @endif
                        @if($telegramUrl)
                            <li><a href="{{ $telegramUrl }}" target="_blank" class="text-gray-600 hover:text-purple-600 text-xs transition"><i class="fab fa-telegram"></i> Telegram</a></li>
                        @endif
                    </ul>
                </div>
                
                <!-- Contact Section -->
                <div>
                    <h4 class="text-gray-900 font-semibold mb-3 text-sm flex items-center gap-2">
                        <i class="fas fa-envelope text-orange-600"></i> Contact
                    </h4>
                    @php
                        $contactEmail = \App\Models\SiteSetting::where('key', 'contact_email')->value('value');
                        $phone = \App\Models\SiteSetting::where('key', 'phone')->value('value');
                    @endphp
                    @if($contactEmail)
                        <p class="mb-1.5 text-gray-600 text-xs"><i class="fas fa-envelope text-xs"></i> {{ $contactEmail }}</p>
                    @endif
                    @if($phone)
                        <p class="text-gray-600 text-xs"><i class="fas fa-phone text-xs"></i> {{ $phone }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-blue-200 pt-6 text-center">
                <p class="text-gray-600 text-xs">&copy; 2026 JobOne.in. All rights reserved. | Designed with <i class="fas fa-heart text-red-500"></i> for Job Seekers</p>
            </div>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-gray-200 z-40 shadow-lg">
        <div class="flex justify-around items-center">
            <a href="{{ route('home') }}" class="flex-1 flex flex-col items-center justify-center py-2.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                <i class="fas fa-home text-lg"></i>
                <span class="text-xs mt-0.5">Home</span>
            </a>
            <a href="{{ route('posts.jobs') }}" class="flex-1 flex flex-col items-center justify-center py-2.5 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition {{ request()->routeIs('posts.jobs') ? 'text-emerald-600 bg-emerald-50' : '' }}">
                <i class="fas fa-briefcase text-lg"></i>
                <span class="text-xs mt-0.5">Jobs</span>
            </a>
            <a href="{{ route('posts.admit-cards') }}" class="flex-1 flex flex-col items-center justify-center py-2.5 text-gray-500 hover:text-purple-600 hover:bg-purple-50 transition {{ request()->routeIs('posts.admit-cards') ? 'text-purple-600 bg-purple-50' : '' }}">
                <i class="fas fa-id-card text-lg"></i>
                <span class="text-xs mt-0.5">Admit</span>
            </a>
            <a href="{{ route('posts.results') }}" class="flex-1 flex flex-col items-center justify-center py-2.5 text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition {{ request()->routeIs('posts.results') ? 'text-orange-600 bg-orange-50' : '' }}">
                <i class="fas fa-chart-bar text-lg"></i>
                <span class="text-xs mt-0.5">Results</span>
            </a>
            <a href="{{ route('posts.syllabus') }}" class="flex-1 flex flex-col items-center justify-center py-2.5 text-gray-500 hover:text-pink-600 hover:bg-pink-50 transition {{ request()->routeIs('posts.syllabus') ? 'text-pink-600 bg-pink-50' : '' }}">
                <i class="fas fa-book text-lg"></i>
                <span class="text-xs mt-0.5">Syllabus</span>
            </a>
            <a href="{{ route('posts.blogs') }}" class="flex-1 flex flex-col items-center justify-center py-2.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 transition {{ request()->routeIs('posts.blogs') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                <i class="fas fa-pen-fancy text-lg"></i>
                <span class="text-xs mt-0.5">Blogs</span>
            </a>
        </div>
    </nav>

    <!-- Add padding to main content and footer for mobile bottom nav -->
    <style>
        @media (max-width: 768px) {
            main {
                padding-bottom: 80px;
            }
            footer {
                padding-bottom: 70px;
            }
        }
    </style>
</body>
</html>
