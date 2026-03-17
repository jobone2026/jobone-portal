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

    <!-- Breaking News Ticker -->
    <x-breaking-news-ticker />

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-50 to-indigo-50 shadow-sm sticky top-0 z-50 border-b border-blue-100">
        <nav class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-3 md:py-4">
            <div class="flex justify-between items-center gap-2">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
                    <img src="{{ asset('images/jobone-logo.png') }}" alt="JobOne.in" class="h-10 md:h-16 w-auto object-contain">
                </a>
                
                <!-- Custom Language Selector -->
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
                    <a href="{{ route('home') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 text-sm font-medium"><i class="fas fa-home"></i> Home</a>
                    <a href="{{ route('posts.jobs') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 text-sm font-medium"><i class="fas fa-briefcase"></i> Jobs</a>
                    <a href="{{ route('posts.admit-cards') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 text-sm font-medium"><i class="fas fa-id-card"></i> Admit</a>
                    <a href="{{ route('posts.results') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 text-sm font-medium"><i class="fas fa-chart-bar"></i> Results</a>
                    <a href="{{ route('posts.syllabus') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 text-sm font-medium"><i class="fas fa-book"></i> Syllabus</a>
                    <a href="{{ route('posts.blogs') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 text-sm font-medium"><i class="fas fa-pen-fancy"></i> Blogs</a>
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
            </div>
        </nav>
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
            border: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            text-decoration: none;
        }
        
        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        
        .category-icon {
            font-size: 32px;
            color: #3b82f6;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .category-card:hover .category-icon {
            color: white;
            transform: scale(1.1);
        }
        
        .category-label {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .category-card:hover .category-label {
            color: white;
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
                    <i class="fas fa-map-marker-alt category-icon"></i>
                    <span class="category-label">State PSC</span>
                </a>
                
                <!-- Defence -->
                <a href="{{ route('categories.show', 'defence') }}" class="category-card" title="Defence Jobs">
                    <i class="fas fa-shield-alt category-icon"></i>
                    <span class="category-label">Defence</span>
                </a>
                
                <!-- Police -->
                <a href="{{ route('categories.show', 'police') }}" class="category-card" title="Police Jobs">
                    <i class="fas fa-user-shield category-icon"></i>
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
            border: 2px solid #3b82f6;
            border-radius: 4px;
            text-decoration: none;
            color: #3b82f6;
            font-weight: 600;
            font-size: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 35px;
            line-height: 1.1;
        }
        
        .state-box:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
                @foreach ($statesWithJobs as $state)
                    <a href="{{ route('states.show', $state->slug) }}" class="state-box">
                        {{ $state->name }}
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
    <footer class="bg-gradient-to-r from-blue-50 to-indigo-50 text-gray-700 mt-0 border-t border-blue-100">
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
            <div class="border-t border-blue-200 pt-6 text-center">
                <p class="text-gray-600 text-sm font-semibold">&copy; 2026 JobOne.in. All rights reserved. | Designed with <i class="fas fa-heart text-red-500"></i> for Job Seekers</p>
            </div>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
