<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JobOne Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-white flex flex-col shadow-2xl">
            <!-- Logo -->
            <div class="p-5 border-b border-slate-700/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-briefcase text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">JobOne.in</h1>
                        <p class="text-xs text-blue-400 font-medium">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl mb-1 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50' }}">
                    <i class="fas fa-chart-line text-lg w-5"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                
                <div class="mt-6 mb-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Content</div>
                
                <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl mb-1 transition-all {{ request()->routeIs('admin.posts.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50' }}">
                    <i class="fas fa-newspaper text-lg w-5"></i>
                    <span class="text-sm font-medium">Posts</span>
                    @if(\App\Models\Post::count() > 0)
                    <span class="ml-auto bg-blue-500/20 text-blue-300 text-xs px-2 py-1 rounded-lg font-semibold">{{ \App\Models\Post::count() }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl mb-1 transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50' }}">
                    <i class="fas fa-tags text-lg w-5"></i>
                    <span class="text-sm font-medium">Categories</span>
                    @if(\App\Models\Category::count() > 0)
                    <span class="ml-auto bg-blue-500/20 text-blue-300 text-xs px-2 py-1 rounded-lg font-semibold">{{ \App\Models\Category::count() }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.states.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl mb-1 transition-all {{ request()->routeIs('admin.states.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50' }}">
                    <i class="fas fa-map-marker-alt text-lg w-5"></i>
                    <span class="text-sm font-medium">States</span>
                    @if(\App\Models\State::count() > 0)
                    <span class="ml-auto bg-blue-500/20 text-blue-300 text-xs px-2 py-1 rounded-lg font-semibold">{{ \App\Models\State::count() }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.authors.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl mb-1 transition-all {{ request()->routeIs('admin.authors.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50' }}">
                    <i class="fas fa-users text-lg w-5"></i>
                    <span class="text-sm font-medium">Authors</span>
                    @if(\App\Models\Author::count() > 0)
                    <span class="ml-auto bg-blue-500/20 text-blue-300 text-xs px-2 py-1 rounded-lg font-semibold">{{ \App\Models\Author::count() }}</span>
                    @endif
                </a>
                
                <div class="mt-6 mb-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Monetization</div>
                
                <a href="{{ route('admin.ads.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl mb-1 transition-all {{ request()->routeIs('admin.ads.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50' }}">
                    <i class="fas fa-ad text-lg w-5"></i>
                    <span class="text-sm font-medium">Ads</span>
                    @if(\App\Models\Ad::count() > 0)
                    <span class="ml-auto bg-blue-500/20 text-blue-300 text-xs px-2 py-1 rounded-lg font-semibold">{{ \App\Models\Ad::count() }}</span>
                    @endif
                </a>
                
                <div class="mt-6 mb-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Settings</div>
                
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl mb-1 transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50' }}">
                    <i class="fas fa-cog text-lg w-5"></i>
                    <span class="text-sm font-medium">Site Settings</span>
                </a>
                
                <a href="{{ route('admin.backups.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl mb-1 transition-all {{ request()->routeIs('admin.backups.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50' }}">
                    <i class="fas fa-database text-lg w-5"></i>
                    <span class="text-sm font-medium">Backup & Restore</span>
                </a>
            </nav>
            
            <!-- User Profile -->
            <div class="p-4 border-t border-slate-700/50 bg-slate-900/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate">{{ auth('admin')->user()->name }}</p>
                        <p class="text-xs text-blue-400 font-medium">Administrator</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 transition-colors p-2 hover:bg-slate-800 rounded-lg" title="Logout">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-slate-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center gap-4">
                        <h2 class="text-xl font-bold text-slate-800">@yield('title', 'Dashboard')</h2>
                        <div class="hidden md:flex items-center gap-2 text-sm text-slate-500">
                            <i class="fas fa-clock"></i>
                            <span id="current-time"></span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                            <i class="fas fa-plus mr-1"></i>New Post
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition text-sm font-medium">
                            <i class="fas fa-external-link-alt mr-1"></i>View Site
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto p-6">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <h4 class="font-semibold text-red-800">Please fix the following errors:</h4>
                        </div>
                        <ul class="list-disc list-inside text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-emerald-500 mr-2"></i>
                            <p class="font-semibold text-emerald-800">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Real-time Clock -->
    <script>
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
    </script>
</body>
</html>
