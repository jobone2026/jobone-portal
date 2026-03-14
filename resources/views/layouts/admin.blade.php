<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JobOne Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }
        
        /* Mobile bottom nav animation */
        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .mobile-nav {
            animation: slideUp 0.3s ease-out;
        }
        
        /* Ripple effect */
        .ripple {
            position: relative;
            overflow: hidden;
        }
        
        .ripple::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .ripple:active::after {
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex w-72 bg-white border-r border-gray-200 flex-col shadow-sm">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-briefcase text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">JobOne</h1>
                        <p class="text-xs text-gray-500 font-medium">Admin Dashboard</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group">
                    <i class="fas fa-chart-line text-lg w-5 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                
                <div class="pt-6 pb-2 px-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Content</p>
                </div>
                
                <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.posts.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group">
                    <i class="fas fa-newspaper text-lg w-5 {{ request()->routeIs('admin.posts.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="text-sm font-medium flex-1">Posts</span>
                    @if(\App\Models\Post::count() > 0)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-lg font-semibold">{{ \App\Models\Post::count() }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group">
                    <i class="fas fa-tags text-lg w-5 {{ request()->routeIs('admin.categories.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="text-sm font-medium flex-1">Categories</span>
                    @if(\App\Models\Category::count() > 0)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-lg font-semibold">{{ \App\Models\Category::count() }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.states.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.states.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group">
                    <i class="fas fa-map-marker-alt text-lg w-5 {{ request()->routeIs('admin.states.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="text-sm font-medium flex-1">States</span>
                    @if(\App\Models\State::count() > 0)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-lg font-semibold">{{ \App\Models\State::count() }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.authors.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.authors.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group">
                    <i class="fas fa-users text-lg w-5 {{ request()->routeIs('admin.authors.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="text-sm font-medium flex-1">Authors</span>
                    @if(\App\Models\Author::count() > 0)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-lg font-semibold">{{ \App\Models\Author::count() }}</span>
                    @endif
                </a>
                
                <div class="pt-6 pb-2 px-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Marketing</p>
                </div>
                
                <a href="{{ route('admin.ads.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.ads.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group">
                    <i class="fas fa-ad text-lg w-5 {{ request()->routeIs('admin.ads.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="text-sm font-medium flex-1">Advertisements</span>
                    @if(\App\Models\Ad::count() > 0)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-lg font-semibold">{{ \App\Models\Ad::count() }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.notifications.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.notifications.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group">
                    <i class="fas fa-bell text-lg w-5 {{ request()->routeIs('admin.notifications.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="text-sm font-medium">Notifications</span>
                </a>
                
                <div class="pt-6 pb-2 px-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">System</p>
                </div>
                
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.settings.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group">
                    <i class="fas fa-cog text-lg w-5 {{ request()->routeIs('admin.settings.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="text-sm font-medium">Settings</span>
                </a>
                
                <a href="{{ route('admin.backups.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.backups.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} group">
                    <i class="fas fa-database text-lg w-5 {{ request()->routeIs('admin.backups.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="text-sm font-medium">Backup</span>
                </a>
            </nav>
            
            <!-- User Profile -->
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-sm">{{ substr(auth('admin')->user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth('admin')->user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-2 hover:bg-red-50 rounded-lg" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="flex justify-between items-center px-4 lg:px-6 py-4">
                    <div class="flex items-center gap-4">
                        <!-- Mobile Menu Button -->
                        <button onclick="toggleMobileMenu()" class="lg:hidden text-gray-600 hover:text-gray-900 p-2">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <div>
                            <h2 class="text-lg lg:text-xl font-bold text-gray-900">@yield('title', 'Dashboard')</h2>
                            <p class="text-xs text-gray-500 hidden md:block">
                                <i class="fas fa-clock mr-1"></i>
                                <span id="current-time"></span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.posts.create') }}" class="bg-blue-600 text-white px-3 lg:px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow-sm ripple">
                            <i class="fas fa-plus mr-1"></i>
                            <span class="hidden sm:inline">New Post</span>
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="bg-white border border-gray-300 text-gray-700 px-3 lg:px-4 py-2 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                            <i class="fas fa-external-link-alt"></i>
                            <span class="hidden sm:inline ml-1">View Site</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto bg-gray-50 pb-20 lg:pb-6">
                <div class="p-4 lg:p-6">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-sm">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-red-800 mb-2">Please fix the following errors:</h4>
                                    <ul class="list-disc list-inside text-red-700 space-y-1 text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <p class="font-semibold text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-times-circle text-red-500 mr-3"></i>
                                <p class="font-semibold text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg mobile-nav z-50">
        <div class="grid grid-cols-5 gap-1 px-2 py-2">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center py-2 px-1 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">
                <i class="fas fa-chart-line text-xl mb-1"></i>
                <span class="text-xs font-medium">Dashboard</span>
            </a>
            
            <a href="{{ route('admin.posts.index') }}" class="flex flex-col items-center justify-center py-2 px-1 rounded-lg {{ request()->routeIs('admin.posts.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">
                <i class="fas fa-newspaper text-xl mb-1"></i>
                <span class="text-xs font-medium">Posts</span>
            </a>
            
            <a href="{{ route('admin.posts.create') }}" class="flex flex-col items-center justify-center -mt-6">
                <div class="bg-blue-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-plus text-2xl"></i>
                </div>
            </a>
            
            <a href="{{ route('admin.notifications.index') }}" class="flex flex-col items-center justify-center py-2 px-1 rounded-lg {{ request()->routeIs('admin.notifications.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">
                <i class="fas fa-bell text-xl mb-1"></i>
                <span class="text-xs font-medium">Notify</span>
            </a>
            
            <button onclick="toggleMobileMenu()" class="flex flex-col items-center justify-center py-2 px-1 rounded-lg text-gray-600">
                <i class="fas fa-bars text-xl mb-1"></i>
                <span class="text-xs font-medium">Menu</span>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleMobileMenu()">
        <div class="absolute right-0 top-0 bottom-0 w-80 bg-white shadow-2xl overflow-y-auto" onclick="event.stopPropagation()">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Menu</h3>
                    <button onclick="toggleMobileMenu()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold">{{ substr(auth('admin')->user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ auth('admin')->user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-1">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 py-2">Content</p>
                
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-tags text-gray-400"></i>
                    <span class="text-sm font-medium">Categories</span>
                </a>
                
                <a href="{{ route('admin.states.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                    <span class="text-sm font-medium">States</span>
                </a>
                
                <a href="{{ route('admin.authors.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-users text-gray-400"></i>
                    <span class="text-sm font-medium">Authors</span>
                </a>
                
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 py-2 mt-4">Marketing</p>
                
                <a href="{{ route('admin.ads.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-ad text-gray-400"></i>
                    <span class="text-sm font-medium">Advertisements</span>
                </a>
                
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 py-2 mt-4">System</p>
                
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-cog text-gray-400"></i>
                    <span class="text-sm font-medium">Settings</span>
                </a>
                
                <a href="{{ route('admin.backups.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-database text-gray-400"></i>
                    <span class="text-sm font-medium">Backup & Restore</span>
                </a>
                
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-external-link-alt text-gray-400"></i>
                    <span class="text-sm font-medium">View Website</span>
                </a>
            </nav>
            
            <div class="p-4 border-t border-gray-200">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition font-medium">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // Real-time Clock
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: true, 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            const dateString = now.toLocaleDateString('en-US', { 
                weekday: 'short', 
                month: 'short', 
                day: 'numeric' 
            });
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = `${dateString}, ${timeString}`;
            }
        }
        
        updateTime();
        setInterval(updateTime, 1000);
        
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        // Close mobile menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('mobile-menu').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
