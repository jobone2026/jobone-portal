<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    
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
        </script>
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

    <!-- Language Chooser Bar -->
    <div class="bg-gradient-to-r from-sky-50 via-blue-50 to-indigo-50 border-b border-gray-200 py-3 shadow-sm notranslate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-3 flex-wrap notranslate">
                <div class="flex items-center gap-2 flex-wrap notranslate">
                    <button onclick="changeLanguage('')" class="language-btn notranslate" data-lang="">English</button>
                    
                    @if (!config('app.domain_state_id'))
                        <!-- Show all languages for main domain -->
                        <button onclick="changeLanguage('hi')" class="language-btn notranslate" data-lang="hi">हिंदी</button>
                        <button onclick="changeLanguage('te')" class="language-btn notranslate" data-lang="te">తెలుగు</button>
                        <button onclick="changeLanguage('ta')" class="language-btn notranslate" data-lang="ta">தமிழ்</button>
                        <button onclick="changeLanguage('kn')" class="language-btn notranslate" data-lang="kn">ಕನ್ನಡ</button>
                        <button onclick="changeLanguage('ml')" class="language-btn notranslate" data-lang="ml">മലയാളം</button>
                        <button onclick="changeLanguage('mr')" class="language-btn notranslate" data-lang="mr">मराठी</button>
                        <button onclick="changeLanguage('gu')" class="language-btn notranslate" data-lang="gu">ગુજરાતી</button>
                        <button onclick="changeLanguage('bn')" class="language-btn notranslate" data-lang="bn">বাংলা</button>
                        <button onclick="changeLanguage('pa')" class="language-btn notranslate" data-lang="pa">ਪੰਜਾਬੀ</button>
                        <button onclick="changeLanguage('or')" class="language-btn notranslate" data-lang="or">ଓଡ଼ିଆ</button>
                        <button onclick="changeLanguage('as')" class="language-btn notranslate" data-lang="as">অসমীয়া</button>
                    @else
                        <!-- Show only state-specific language for filtered domains -->
                        @if (config('app.domain_state_slug') === 'karnataka')
                            <button onclick="changeLanguage('kn')" class="language-btn notranslate" data-lang="kn">ಕನ್ನಡ</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .language-btn {
            padding: 6px 16px;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0c4a6e;
            border: 2px solid #0ea5e9;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }
        
        .language-btn:hover {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
        
        @media (max-width: 768px) {
            .language-btn {
                padding: 4px 12px;
                font-size: 12px;
            }
        }
    </style>

    <!-- Header -->
    <header class="bg-gradient-to-r from-emerald-50 to-teal-50 shadow-sm sticky top-0 z-50 border-b border-emerald-100">
        <nav class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-3 md:py-4">
            <div class="flex justify-between items-center gap-2">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
                    <img src="{{ asset('images/jobone-logo.png') }}" alt="JobOne.in" class="h-10 md:h-16 w-auto object-contain">
                </a>
                
                <!-- Custom Language Selector - Hidden -->
                <div class="hidden">
                    <select id="custom_language_select" class="text-xs notranslate">
                        <option value="">English</option>
                        @if (!config('app.domain_state_id'))
                            <!-- Show all languages for main domain -->
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
                        @else
                            <!-- Show only state-specific language for filtered domains -->
                            @if (config('app.domain_state_slug') === 'karnataka')
                                <option value="kn">ಕನ್ನಡ</option>
                            @endif
                        @endif
                    </select>
                </div>
                
                <!-- Hidden Google Translate Widget -->
                <div id="google_translate_element"></div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="p-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                        <i id="mobile-menu-icon" class="fas fa-bars text-lg"></i>
                    </button>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="px-5 py-3 text-gray-700 hover:text-blue-600 text-lg font-semibold"><i class="fas fa-home"></i> Home</a>
                    <a href="{{ route('posts.jobs') }}" class="px-5 py-3 text-gray-700 hover:text-blue-600 text-lg font-semibold"><i class="fas fa-briefcase"></i> Jobs</a>
                    <a href="{{ route('posts.admit-cards') }}" class="px-5 py-3 text-gray-700 hover:text-blue-600 text-lg font-semibold"><i class="fas fa-id-card"></i> Admit</a>
                    <a href="{{ route('posts.results') }}" class="px-5 py-3 text-gray-700 hover:text-blue-600 text-lg font-semibold"><i class="fas fa-chart-bar"></i> Results</a>
                    <a href="{{ route('posts.syllabus') }}" class="px-5 py-3 text-gray-700 hover:text-blue-600 text-lg font-semibold"><i class="fas fa-book"></i> Syllabus</a>
                    <a href="{{ route('posts.blogs') }}" class="px-5 py-3 text-gray-700 hover:text-blue-600 text-lg font-semibold"><i class="fas fa-pen-fancy"></i> Blogs</a>
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
                }" class="relative w-80 md:w-96">
                    <form action="{{ route('search') }}" method="GET" class="flex items-center gap-2">
                        <input 
                            type="text" 
                            name="q" 
                            x-model="query"
                            @input.debounce.300ms="search()"
                            @click.away="showResults = false"
                            placeholder="Search jobs, results..." 
                            class="px-4 py-3 bg-blue-100 border-2 border-blue-300 rounded-lg focus:outline-none focus:border-blue-500 focus:bg-white w-full text-base font-medium"
                            autocomplete="off">
                        <button type="submit" class="px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 font-semibold text-base shadow-md flex-shrink-0"><i class="fas fa-search"></i></button>
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
            </div>
        </nav>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden bg-white border-t border-gray-200 shadow-lg hidden">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded text-sm font-medium">
                    <i class="fas fa-home w-4"></i> Home
                </a>
                <a href="{{ route('posts.jobs') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded text-sm font-medium">
                    <i class="fas fa-briefcase w-4"></i> Jobs
                </a>
                <a href="{{ route('posts.admit-cards') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded text-sm font-medium">
                    <i class="fas fa-id-card w-4"></i> Admit Cards
                </a>
                <a href="{{ route('posts.results') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded text-sm font-medium">
                    <i class="fas fa-chart-bar w-4"></i> Results
                </a>
                <a href="{{ route('posts.syllabus') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded text-sm font-medium">
                    <i class="fas fa-book w-4"></i> Syllabus
                </a>
                <a href="{{ route('posts.blogs') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded text-sm font-medium">
                    <i class="fas fa-pen-fancy w-4"></i> Blogs
                </a>
                
                <!-- Mobile Search -->
                <div class="pt-3 border-t border-gray-200">
                    <form action="{{ route('search') }}" method="GET" class="flex gap-2">
                        <input type="text" name="q" placeholder="Search..." 
                               class="flex-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    

    <!-- Category Image Cards Section -->
    <style>
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
            gap: 12px;
            padding: 16px 0;
        }
        
        .category-card {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 100px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px solid;
            text-decoration: none;
        }
        
        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        /* Banking - Emerald/Green */
        .category-card:nth-child(1) {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-color: #10b981;
        }
        .category-card:nth-child(1) .category-icon {
            color: #059669;
        }
        .category-card:nth-child(1) .category-label {
            color: #065f46;
        }
        .category-card:nth-child(1):hover {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .category-card:nth-child(1):hover .category-icon,
        .category-card:nth-child(1):hover .category-label {
            color: white;
        }
        
        /* Railways - Teal */
        .category-card:nth-child(2) {
            background: linear-gradient(135deg, #ccfbf1 0%, #99f6e4 100%);
            border-color: #14b8a6;
        }
        .category-card:nth-child(2) .category-icon {
            color: #0f766e;
        }
        .category-card:nth-child(2) .category-label {
            color: #134e4a;
        }
        .category-card:nth-child(2):hover {
            background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        }
        .category-card:nth-child(2):hover .category-icon,
        .category-card:nth-child(2):hover .category-label {
            color: white;
        }
        
        /* SSC - Cyan */
        .category-card:nth-child(3) {
            background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
            border-color: #06b6d4;
        }
        .category-card:nth-child(3) .category-icon {
            color: #0891b2;
        }
        .category-card:nth-child(3) .category-label {
            color: #164e63;
        }
        .category-card:nth-child(3):hover {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }
        .category-card:nth-child(3):hover .category-icon,
        .category-card:nth-child(3):hover .category-label {
            color: white;
        }
        
        /* UPSC - Indigo */
        .category-card:nth-child(4) {
            background: linear-gradient(135deg, #c7d2fe 0%, #a5b4fc 100%);
            border-color: #6366f1;
        }
        .category-card:nth-child(4) .category-icon {
            color: #4f46e5;
        }
        .category-card:nth-child(4) .category-label {
            color: #3730a3;
        }
        .category-card:nth-child(4):hover {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
        .category-card:nth-child(4):hover .category-icon,
        .category-card:nth-child(4):hover .category-label {
            color: white;
        }
        
        /* State PSC - Teal */
        .category-card:nth-child(5) {
            background: linear-gradient(135deg, #ccfbf1 0%, #99f6e4 100%);
            border-color: #14b8a6;
        }
        .category-card:nth-child(5) .category-icon {
            color: #0d9488;
        }
        .category-card:nth-child(5) .category-label {
            color: #115e59;
        }
        .category-card:nth-child(5):hover {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
        }
        .category-card:nth-child(5):hover .category-icon,
        .category-card:nth-child(5):hover .category-label {
            color: white;
        }
        
        /* Defence - Slate */
        .category-card:nth-child(6) {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            border-color: #64748b;
        }
        .category-card:nth-child(6) .category-icon {
            color: #475569;
        }
        .category-card:nth-child(6) .category-label {
            color: #334155;
        }
        .category-card:nth-child(6):hover {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }
        .category-card:nth-child(6):hover .category-icon,
        .category-card:nth-child(6):hover .category-label {
            color: white;
        }
        
        /* Police - Blue */
        .category-card:nth-child(7) {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #3b82f6;
        }
        .category-card:nth-child(7) .category-icon {
            color: #2563eb;
        }
        .category-card:nth-child(7) .category-label {
            color: #1e40af;
        }
        .category-card:nth-child(7):hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        .category-card:nth-child(7):hover .category-icon,
        .category-card:nth-child(7):hover .category-label {
            color: white;
        }
        
        /* Blog - Rose */
        .category-card:nth-child(8) {
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
            border-color: #ec4899;
        }
        .category-card:nth-child(8) .category-icon {
            color: #db2777;
        }
        .category-card:nth-child(8) .category-label {
            color: #9f1239;
        }
        .category-card:nth-child(8):hover {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        }
        .category-card:nth-child(8):hover .category-icon,
        .category-card:nth-child(8):hover .category-label {
            color: white;
        }
        
        .category-icon {
            font-size: 32px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .category-card:hover .category-icon {
            transform: scale(1.1);
        }
        
        .category-label {
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .category-grid {
                grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
                gap: 10px;
            }
            
            .category-card {
                height: 90px;
            }
            
            .category-icon {
                font-size: 28px;
                margin-bottom: 6px;
            }
            
            .category-label {
                font-size: 11px;
            }
        }
    </style>
    <div class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="category-grid">
                <!-- Banking -->
                <a href="{{ route('categories.show', 'banking') }}" class="category-card" title="Banking Jobs">
                    <i class="fas fa-university category-icon"></i>
                    <span class="category-label">Banking</span>
                </a>
                
                <!-- Railways -->
                <a href="{{ route('categories.show', 'railways') }}" class="category-card" title="Railways Jobs">
                    <i class="fas fa-train category-icon"></i>
                    <span class="category-label">Railways</span>
                </a>
                
                <!-- SSC -->
                <a href="{{ route('categories.show', 'ssc') }}" class="category-card" title="SSC Jobs">
                    <i class="fas fa-file-alt category-icon"></i>
                    <span class="category-label">SSC</span>
                </a>
                
                <!-- UPSC -->
                <a href="{{ route('categories.show', 'upsc') }}" class="category-card" title="UPSC Jobs">
                    <i class="fas fa-graduation-cap category-icon"></i>
                    <span class="category-label">UPSC</span>
                </a>
                
                <!-- State PSC -->
                <a href="{{ route('categories.show', 'state-psc') }}" class="category-card" title="State PSC Jobs">
                    <i class="fa-solid fa-landmark category-icon"></i>
                    <span class="category-label">State PSC</span>
                </a>
                
                <!-- Defence -->
                <a href="{{ route('categories.show', 'defence') }}" class="category-card" title="Defence Jobs">
                    <i class="fas fa-shield-alt category-icon"></i>
                    <span class="category-label">Defence</span>
                </a>
                
                <!-- Police -->
                <a href="{{ route('categories.show', 'police') }}" class="category-card" title="Police Jobs">
                    <i class="fa-solid fa-user-police category-icon"></i>
                    <span class="category-label">Police</span>
                </a>
                
                <!-- Blog -->
                <a href="{{ route('posts.blogs') }}" class="category-card" title="Blog">
                    <i class="fas fa-blog category-icon"></i>
                    <span class="category-label">Blog</span>
                </a>
            </div>
        </div>
    </div>
<!-- States Navigation Bar -->
    <style>
        .states-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(65px, 1fr));
            gap: 8px;
            padding: 12px 0;
        }
        
        .state-box {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 6px;
            background: white;
            border: 2px solid;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 35px;
            line-height: 1.1;
        }
        
        /* All India - Special gradient */
        .state-box:first-child {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: #059669;
            font-weight: 700;
        }
        
        .state-box:first-child:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.4);
        }
        
        /* Cycle through colors for other states */
        .state-box:nth-child(6n+2) {
            border-color: #14b8a6;
            color: #0f766e;
            background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
        }
        .state-box:nth-child(6n+2):hover {
            background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
        }
        
        .state-box:nth-child(6n+3) {
            border-color: #06b6d4;
            color: #0891b2;
            background: linear-gradient(135deg, #f0fdff 0%, #cffafe 100%);
        }
        .state-box:nth-child(6n+3):hover {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
        }
        
        .state-box:nth-child(6n+4) {
            border-color: #6366f1;
            color: #4f46e5;
            background: linear-gradient(135deg, #faf5ff 0%, #c7d2fe 100%);
        }
        .state-box:nth-child(6n+4):hover {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .state-box:nth-child(6n+5) {
            border-color: #8b5cf6;
            color: #7c3aed;
            background: linear-gradient(135deg, #faf5ff 0%, #e9d5ff 100%);
        }
        .state-box:nth-child(6n+5):hover {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }
        
        .state-box:nth-child(6n+6) {
            border-color: #64748b;
            color: #475569;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        .state-box:nth-child(6n+6):hover {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
        }
        
        .state-box:nth-child(6n+7) {
            border-color: #ea580c;
            color: #dc2626;
            background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);
        }
        .state-box:nth-child(6n+7):hover {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);
        }
        
        .state-box:hover {
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .states-grid {
                grid-template-columns: repeat(auto-fit, minmax(55px, 1fr));
                gap: 6px;
                padding: 10px 0;
            }
            
            .state-box {
                font-size: 9px;
                padding: 6px 4px;
                min-height: 30px;
            }
        }
    </style>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="states-grid">
                @php
                    use Illuminate\Support\Str;
                    $allStates = [
                        'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh',
                        'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand',
                        'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur',
                        'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab',
                        'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura',
                        'Uttar Pradesh', 'Uttarakhand', 'West Bengal', 'Delhi', 'Jammu & Kashmir',
                        'Ladakh', 'Puducherry', 'Chandigarh', 'Andaman & Nicobar', 'Lakshadweep',
                        'Dadra & Nagar Haveli', 'Daman & Diu'
                    ];
                    
                    // Filter states based on domain
                    $domainStateId = config('app.domain_state_id');
                    if ($domainStateId) {
                        $domainState = \App\Models\State::find($domainStateId);
                        if ($domainState) {
                            $allStates = [$domainState->name];
                        }
                    }
                    
                    // Get states with job counts
                    $statesWithJobs = collect($allStates)->map(function($stateName) use ($states) {
                        $state = $states->firstWhere('name', $stateName);
                        if ($state) {
                            // Get job count for this state
                            $jobCount = \App\Models\Post::where('state_id', $state->id)
                                ->where('is_published', 1)
                                ->count();
                            return $jobCount > 0 ? $state : null;
                        }
                        return null;
                    })->filter(); // Remove null values (states with 0 jobs)
                @endphp
                
                <!-- Show state selector only if not domain-filtered -->
                @if (!config('app.domain_state_id'))
                    <!-- All India Box -->
                    <a href="{{ route('posts.all') }}" class="state-box">
                        All India
                    </a>
                    
                    @foreach ($statesWithJobs as $state)
                        <a href="{{ route('states.show', $state->slug) }}" class="state-box">
                            {{ $state->name }}
                        </a>
                    @endforeach
                @else
                    <!-- Show All India + current state for domain-filtered pages -->
                    <a href="https://jobone.in/all-posts" class="state-box">
                        All India
                    </a>
                    
                    @foreach ($statesWithJobs as $state)
                        <a href="{{ route('states.show', $state->slug) }}" class="state-box">
                            {{ $state->name }}
                        </a>
                    @endforeach
                @endif
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
    <footer class="bg-gradient-to-r from-emerald-50 to-teal-50 text-gray-700 mt-0 border-t border-emerald-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                <!-- About Section -->
                <div>
                    <h4 class="text-gray-900 font-bold mb-3 text-base flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i> About
                    </h4>
                    <ul class="space-y-1.5">
                        <li><a href="{{ route('pages.about') }}" class="text-gray-600 hover:text-blue-600 text-sm font-semibold transition"><i class="fas fa-chevron-right text-xs"></i> About Us</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-gray-600 hover:text-blue-600 text-sm font-semibold transition"><i class="fas fa-chevron-right text-xs"></i> Contact</a></li>
                    </ul>
                </div>
                
                <!-- Legal Section -->
                <div>
                    <h4 class="text-gray-900 font-bold mb-3 text-base flex items-center gap-2">
                        <i class="fas fa-shield-alt text-emerald-600"></i> Legal
                    </h4>
                    <ul class="space-y-1.5">
                        <li><a href="{{ route('pages.privacy') }}" class="text-gray-600 hover:text-emerald-600 text-sm font-semibold transition"><i class="fas fa-chevron-right text-xs"></i> Privacy Policy</a></li>
                        <li><a href="{{ route('pages.disclaimer') }}" class="text-gray-600 hover:text-emerald-600 text-sm font-semibold transition"><i class="fas fa-chevron-right text-xs"></i> Disclaimer</a></li>
                    </ul>
                </div>
                
                <!-- Social Section -->
                <div>
                    <h4 class="text-gray-900 font-bold mb-3 text-base flex items-center gap-2">
                        <i class="fas fa-share-alt text-purple-600"></i> Follow Us
                    </h4>
                    <ul class="space-y-1.5">
                        @php
                            $facebookUrl = \App\Models\SiteSetting::where('key', 'facebook_url')->value('value');
                            $twitterUrl = \App\Models\SiteSetting::where('key', 'twitter_url')->value('value');
                            $telegramUrl = \App\Models\SiteSetting::where('key', 'telegram_url')->value('value');
                        @endphp
                        @if($facebookUrl)
                            <li><a href="{{ $facebookUrl }}" target="_blank" class="text-gray-600 hover:text-purple-600 text-sm font-semibold transition"><i class="fab fa-facebook"></i> Facebook</a></li>
                        @endif
                        @if($twitterUrl)
                            <li><a href="{{ $twitterUrl }}" target="_blank" class="text-gray-600 hover:text-purple-600 text-sm font-semibold transition"><i class="fab fa-twitter"></i> Twitter</a></li>
                        @endif
                        @if($telegramUrl)
                            <li><a href="{{ $telegramUrl }}" target="_blank" class="text-gray-600 hover:text-purple-600 text-sm font-semibold transition"><i class="fab fa-telegram"></i> Telegram</a></li>
                        @endif
                    </ul>
                </div>
                
                <!-- Contact Section -->
                <div>
                    <h4 class="text-gray-900 font-bold mb-3 text-base flex items-center gap-2">
                        <i class="fas fa-envelope text-orange-600"></i> Contact
                    </h4>
                    @php
                        $contactEmail = \App\Models\SiteSetting::where('key', 'contact_email')->value('value');
                        $phone = \App\Models\SiteSetting::where('key', 'phone')->value('value');
                        $androidAppUrl = \App\Models\SiteSetting::where('key', 'android_app_url')->value('value');
                    @endphp
                    @if($contactEmail)
                        <p class="mb-1.5 text-gray-600 text-sm font-semibold"><i class="fas fa-envelope text-xs"></i> {{ $contactEmail }}</p>
                    @endif
                    @if($phone)
                        <p class="mb-3 text-gray-600 text-sm font-semibold"><i class="fas fa-phone text-xs"></i> {{ $phone }}</p>
                    @endif
                    @if($androidAppUrl)
                        <a href="{{ $androidAppUrl }}" target="_blank" class="inline-block">
                            <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Get it on Google Play" style="height: 50px; width: auto;">
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-emerald-200 pt-6 text-center">
                <p class="text-gray-600 text-sm font-semibold">&copy; 2026 JobOne.in. All rights reserved. | Designed with <i class="fas fa-heart text-red-500"></i> for Job Seekers</p>
            </div>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Translate Script -->
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
                    if (savedLang) {
                        combo.value = savedLang;
                        combo.dispatchEvent(new Event('change'));
                        
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
                            } else {
                                // Change to selected language
                                combo.value = this.value;
                                combo.dispatchEvent(new Event('change'));
                                
                                // Save to localStorage
                                localStorage.setItem('selectedLanguage', this.value);
                            }
                        });
                    }
                    
                    // Language chooser buttons
                    var languageButtons = document.querySelectorAll('.language-btn');
                    languageButtons.forEach(function(button) {
                        button.addEventListener('click', function() {
                            var langCode = this.getAttribute('data-lang');
                            if (langCode === '') {
                                combo.value = 'en';
                                combo.dispatchEvent(new Event('change'));
                                localStorage.removeItem('selectedLanguage');
                            } else {
                                combo.value = langCode;
                                combo.dispatchEvent(new Event('change'));
                                localStorage.setItem('selectedLanguage', langCode);
                            }
                            
                            // Update custom select
                            var customSelect = document.getElementById('custom_language_select');
                            if (customSelect) {
                                customSelect.value = langCode;
                            }
                        });
                    });
                }
            }, 1500);
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            var mobileMenuButton = document.getElementById('mobile-menu-button');
            var mobileMenu = document.getElementById('mobile-menu');
            var mobileMenuIcon = document.getElementById('mobile-menu-icon');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    
                    if (mobileMenu.classList.contains('hidden')) {
                        mobileMenuIcon.className = 'fas fa-bars text-lg';
                    } else {
                        mobileMenuIcon.className = 'fas fa-times text-lg';
                    }
                });
            }
        });
    </script>
    
    <!-- Toast Notification Component -->
    <x-toast-notification />
    
    <!-- Back to Top Button -->
    <x-back-to-top />
</body>
</html>
