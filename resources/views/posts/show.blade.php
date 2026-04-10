@extends('layouts.app')

@section('title', $post->meta_title)
@section('description', $post->meta_description)
@section('keywords', $post->meta_keywords)
@section('canonical', route('posts.show', [$post->type, $post->slug]))
@section('og_title', $post->meta_title)
@section('og_description', $post->meta_description)
@section('og_url', route('posts.show', [$post->type, $post->slug]))

@section('content')
    <style>
        /* Post content wrapper - basic isolation */
        .post-content-wrapper {
            isolation: isolate;
            position: relative;
        }
        
        /* PUC Blog Styles - for custom HTML content */
        .puc-blog * { box-sizing: border-box; margin: 0; padding: 0; }
        .puc-blog { font-family: 'DM Sans', -apple-system, sans-serif; color: #1A1A1A; background: #fff; font-size: 15px; line-height: 1.7; }
        .pb-hero { background: linear-gradient(135deg, #0D2137 0%, #1B3A5C 60%, #1565C0 100%); color: #fff; padding: 48px 20px 40px; text-align: center; position: relative; overflow: hidden; border-radius: 12px; margin-bottom: 24px; }
        .pb-hero-badge { display: inline-block; background: #C9A84C; color: #1A1A1A; font-size: 11px; font-weight: 600; padding: 4px 14px; border-radius: 20px; margin-bottom: 16px; letter-spacing: 0.06em; text-transform: uppercase; }
        .pb-h1 { font-family: 'Playfair Display', Georgia, serif; font-size: clamp(22px, 5vw, 36px); line-height: 1.25; margin-bottom: 12px; color: #fff; }
        .pb-h1 span { color: #C9A84C; }
        .pb-hero-meta { font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 24px; }
        .pb-stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; max-width: 540px; margin: 0 auto; }
        .pb-stat-box { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; padding: 12px 8px; text-align: center; }
        .pb-stat-num { font-size: 22px; font-weight: 600; color: #C9A84C; display: block; }
        .pb-stat-label { font-size: 11px; color: rgba(255,255,255,0.7); margin-top: 2px; }
        .pb-banner { background: #E8F5EE; border: 1px solid #A8D5BE; border-radius: 10px; padding: 14px 16px; margin: 24px 0; display: flex; align-items: center; gap: 12px; }
        .pb-banner-icon { font-size: 24px; flex-shrink: 0; }
        .pb-banner p { font-size: 13px; color: #145235; line-height: 1.5; }
        .pb-section { padding: 32px 0 0; }
        .pb-h2 { font-family: 'Playfair Display', Georgia, serif; font-size: 20px; font-weight: 700; margin-bottom: 4px; color: #1A1A1A; }
        .pb-sub { font-size: 13px; color: #666; margin-bottom: 20px; }
        .pb-stream-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 24px; }
        .pb-stream-card { border-radius: 10px; padding: 16px; text-align: center; border: 1px solid transparent; }
        .pb-stream-card.sc { background: #E8F0FE; border-color: #BBDEFB; }
        .pb-stream-card.co { background: #FFF8E1; border-color: #FFE082; }
        .pb-stream-card.ar { background: #F3E5F5; border-color: #CE93D8; }
        .pb-stream-icon { font-size: 22px; margin-bottom: 6px; display: block; }
        .pb-stream-name { font-size: 12px; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase; margin-bottom: 4px; display: block; }
        .pb-stream-card.sc .pb-stream-name { color: #1565C0; }
        .pb-stream-card.co .pb-stream-name { color: #795548; }
        .pb-stream-card.ar .pb-stream-name { color: #6A1B9A; }
        .pb-stream-pct { font-size: 28px; font-weight: 700; display: block; }
        .pb-stream-card.sc .pb-stream-pct { color: #1565C0; }
        .pb-stream-card.co .pb-stream-pct { color: #5D4037; }
        .pb-stream-card.ar .pb-stream-pct { color: #6A1B9A; }
        .pb-stream-appeared { font-size: 11px; color: #666; margin-top: 3px; display: block; }
        .pb-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .pb-info-box { background: #FAFAFA; border: 1px solid #E5E5E5; border-radius: 8px; padding: 12px 14px; }
        .pb-info-label { font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; display: block; }
        .pb-info-val { font-size: 14px; font-weight: 600; color: #1A1A1A; display: block; }
        .pb-divider { border: none; border-top: 1px solid #E5E5E5; margin: 32px 0; }
        .pb-topper-section { margin-bottom: 24px; }
        .pb-stream-hdr { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px 8px 0 0; border: 1px solid transparent; }
        .pb-stream-hdr.sc { background: #E8F0FE; border-color: #BBDEFB; }
        .pb-stream-hdr.co { background: #FFF8E1; border-color: #FFE082; }
        .pb-stream-hdr.ar { background: #F3E5F5; border-color: #CE93D8; }
        .pb-stitle { font-size: 14px; font-weight: 600; }
        .pb-stream-hdr.sc .pb-stitle { color: #1565C0; }
        .pb-stream-hdr.co .pb-stitle { color: #5D4037; }
        .pb-stream-hdr.ar .pb-stitle { color: #6A1B9A; }
        .pb-stotal { font-size: 12px; color: #666; margin-left: auto; }
        .pb-toppers { width: 100%; border-collapse: collapse; border: 1px solid #E5E5E5; border-top: none; border-radius: 0 0 8px 8px; overflow: hidden; }
        .pb-toppers thead { background: #FAFAFA; }
        .pb-toppers th { padding: 9px 12px; font-size: 11px; font-weight: 600; color: #666; text-align: left; text-transform: uppercase; letter-spacing: 0.04em; border-bottom: 1px solid #E5E5E5; }
        .pb-toppers td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #E5E5E5; }
        .pb-toppers tr:last-child td { border-bottom: none; }
        .pb-toppers tr:hover { background: #FAFAFA; }
        
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .pb-stream-grid, .pb-info-grid { grid-template-columns: 1fr; }
            .pb-hero { padding: 32px 16px 28px; }
            .pb-h1 { font-size: 20px; }
            .pb-stat-row { grid-template-columns: 1fr; gap: 8px; }
            .pb-stat-box { padding: 10px; }
            .pb-stat-num { font-size: 18px; }
            .pb-banner { flex-direction: column; text-align: center; padding: 12px; }
            .pb-banner-icon { font-size: 20px; }
            .pb-section { padding: 20px 0 0; }
            .pb-h2 { font-size: 18px; }
            .pb-stream-card { padding: 12px; }
            .pb-stream-pct { font-size: 24px; }
            .pb-info-box { padding: 10px 12px; }
            .pb-stream-hdr { flex-direction: column; align-items: flex-start; gap: 4px; padding: 8px 12px; }
            .pb-stotal { margin-left: 0; font-size: 11px; }
            .pb-toppers { font-size: 12px; display: block; overflow-x: auto; }
            .pb-toppers thead, .pb-toppers tbody, .pb-toppers tr { display: block; }
            .pb-toppers th, .pb-toppers td { padding: 8px 10px; font-size: 11px; }
        }
        
        /* Ensure content doesn't overflow */
        .post-content-wrapper { 
            max-width: 100%; 
            overflow-x: hidden; 
        }
        .puc-blog { 
            max-width: 100%; 
            overflow-x: hidden; 
        }
        .puc-blog table {
            width: 100%;
            display: block;
            overflow-x: auto;
        }
        
        /* Allow content to have its own styles */
        .post-content-isolated {
            display: block;
            position: relative;
            line-height: 1.75;
            color: #374151;
        }
        
        /* Typography styles for post content */
        .post-content-isolated h1,
        .post-content-isolated h2,
        .post-content-isolated h3,
        .post-content-isolated h4,
        .post-content-isolated h5,
        .post-content-isolated h6 {
            font-weight: 700;
            color: #111827;
            margin-top: 1.5em;
            margin-bottom: 0.75em;
            line-height: 1.3;
        }
        
        .post-content-isolated h1 { font-size: 1.875rem; }
        .post-content-isolated h2 { font-size: 1.5rem; }
        .post-content-isolated h3 { font-size: 1.25rem; }
        .post-content-isolated h4 { font-size: 1.125rem; }
        .post-content-isolated h5 { font-size: 1rem; }
        .post-content-isolated h6 { font-size: 0.875rem; }
        
        .post-content-isolated p {
            margin-bottom: 1.25em;
            line-height: 1.75;
        }
        
        .post-content-isolated ul,
        .post-content-isolated ol {
            margin-bottom: 1.25em;
            padding-left: 1.75em;
        }
        
        .post-content-isolated ul {
            list-style-type: disc;
        }
        
        .post-content-isolated ol {
            list-style-type: decimal;
        }
        
        .post-content-isolated li {
            margin-bottom: 0.5em;
            line-height: 1.75;
        }
        
        .post-content-isolated li > ul,
        .post-content-isolated li > ol {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }
        
        .post-content-isolated a {
            color: #2563eb;
            text-decoration: underline;
            font-weight: 500;
        }
        
        .post-content-isolated a:hover {
            color: #1d4ed8;
        }
        
        .post-content-isolated strong,
        .post-content-isolated b {
            font-weight: 700;
            color: #111827;
        }
        
        .post-content-isolated em,
        .post-content-isolated i {
            font-style: italic;
        }
        
        .post-content-isolated blockquote {
            border-left: 4px solid #e5e7eb;
            padding-left: 1em;
            margin: 1.5em 0;
            font-style: italic;
            color: #6b7280;
        }
        
        /* Table wrapper for horizontal scroll on mobile */
        .post-content-isolated > table {
            display: block;
            width: 100%;
            overflow-x: auto;
            margin: 1.5em 0;
            -webkit-overflow-scrolling: touch;
        }
        
        .post-content-isolated table {
            width: 100%;
            border-collapse: collapse;
            display: table;
            min-width: 100%;
        }
        
        .post-content-isolated table thead {
            background-color: #f3f4f6;
        }
        
        .post-content-isolated table tbody {
            display: table-row-group;
        }
        
        .post-content-isolated table tr {
            display: table-row;
        }
        
        .post-content-isolated table th,
        .post-content-isolated table td {
            display: table-cell;
            border: 1px solid #d1d5db;
            padding: 0.75em 1em;
            text-align: left;
            vertical-align: top;
        }
        
        .post-content-isolated table th {
            font-weight: 700;
            color: #111827;
            background-color: #f3f4f6;
        }
        
        .post-content-isolated table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .post-content-isolated table tbody tr:hover {
            background-color: #f0f9ff;
        }
        
        .post-content-isolated img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5em 0;
        }
        
        .post-content-isolated code {
            background-color: #f3f4f6;
            padding: 0.2em 0.4em;
            border-radius: 0.25rem;
            font-size: 0.875em;
            font-family: 'Courier New', monospace;
        }
        
        .post-content-isolated pre {
            background-color: #1f2937;
            color: #f9fafb;
            padding: 1em;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1.5em 0;
        }
        
        .post-content-isolated pre code {
            background-color: transparent;
            padding: 0;
            color: inherit;
        }
        
        .post-content-isolated hr {
            border: none;
            border-top: 2px solid #e5e7eb;
            margin: 2em 0;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .post-content-isolated h1 { font-size: 1.5rem; }
            .post-content-isolated h2 { font-size: 1.25rem; }
            .post-content-isolated h3 { font-size: 1.125rem; }
            .post-content-isolated h4 { font-size: 1rem; }
            
            .post-content-isolated table {
                font-size: 0.875rem;
            }
            
            .post-content-isolated table th,
            .post-content-isolated table td {
                padding: 0.5em 0.75em;
            }
        }
        
        /* Additional content enhancements */
        .post-content-isolated h2:first-child,
        .post-content-isolated h3:first-child {
            margin-top: 0;
        }
        
        /* Better link styling in tables */
        .post-content-isolated table a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid transparent;
            transition: border-color 0.2s;
        }
        
        .post-content-isolated table a:hover {
            border-bottom-color: #2563eb;
        }
        
        /* Ensure proper spacing between sections */
        .post-content-isolated > *:first-child {
            margin-top: 0;
        }
        
        .post-content-isolated > *:last-child {
            margin-bottom: 0;
        }
    </style>

    <!-- Breadcrumb -->
    @php
        $typeRouteMap = [
            'job' => 'posts.jobs',
            'admit_card' => 'posts.admit-cards',
            'result' => 'posts.results',
            'answer_key' => 'posts.answer-keys',
            'syllabus' => 'posts.syllabus',
            'blog' => 'posts.blogs'
        ];
        $typeRoute = $typeRouteMap[$post->type] ?? 'home';
    @endphp
    <x-breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => ucfirst(str_replace('_', ' ', $post->type)), 'url' => route($typeRoute)],
        ['label' => $post->title, 'url' => '#']
    ]" />

    <article class="bg-white rounded-xl shadow-lg p-4 md:p-8 mb-4 md:mb-8 border border-gray-200">
        <div class="mb-4">
            <div class="flex justify-between items-start mb-3 flex-wrap gap-3">
                <h1 class="font-bold text-gray-900 flex-1 leading-tight" style="font-size: 18px; line-height: 1.4;">{{ $post->title }}</h1>
                @if ($post->isNew())
                    <span class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-md animate-pulse flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        NEW
                    </span>
                @endif
            </div>

            <div class="flex flex-wrap gap-2 mb-3">
                <span class="text-xs bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-1.5 rounded-full font-semibold shadow-sm">
                    <i class="fas fa-tag"></i> {{ ucfirst(str_replace('_', ' ', $post->type)) }}
                </span>
                @if ($post->category)
                    <a href="{{ route('categories.show', $post->category) }}" class="text-xs bg-gradient-to-r from-gray-600 to-gray-700 text-white px-3 py-1.5 rounded-full hover:from-gray-700 hover:to-gray-800 transition font-semibold shadow-sm">
                        <i class="fas fa-folder"></i> {{ $post->category->name }}
                    </a>
                @endif
                @if ($post->state)
                    <a href="{{ route('states.show', $post->state) }}" class="text-xs bg-gradient-to-r from-green-600 to-green-700 text-white px-3 py-1.5 rounded-full hover:from-green-700 hover:to-green-800 transition font-semibold shadow-sm">
                        <i class="fas fa-map-marker-alt"></i> {{ $post->state->name }}
                    </a>
                @endif
            </div>

            <div class="flex justify-between items-center text-xs text-gray-600 border-t border-b border-gray-200 py-3 bg-gray-50 rounded px-3">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Published: {{ $post->created_at->format('M d, Y') }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ number_format($post->view_count) }} views
                </span>
            </div>
        </div>

        <!-- Important Dates -->
        @if ($post->last_date || $post->notification_date || $post->total_posts || $post->organization)
            <div class="bg-gradient-to-r from-blue-50 via-blue-100 to-blue-50 border-l-4 border-blue-600 p-5 mb-4 rounded-r-xl shadow-sm">
                <h3 class="font-bold text-blue-900 mb-3 text-base flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Important Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @if ($post->organization)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-200">
                            <div class="text-xs text-blue-600 font-semibold mb-1">Organization</div>
                            <div class="text-sm text-blue-900 font-bold">{{ $post->organization }}</div>
                        </div>
                    @endif
                    @if ($post->notification_date)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-200">
                            <div class="text-xs text-blue-600 font-semibold mb-1">Notification Date</div>
                            <div class="text-sm text-blue-900 font-bold">{{ $post->notification_date->format('M d, Y') }}</div>
                        </div>
                    @endif
                    @if ($post->last_date)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-red-200">
                            <div class="text-xs text-red-600 font-semibold mb-1">Last Date to Apply</div>
                            <div class="text-sm text-red-900 font-bold">{{ $post->last_date->format('M d, Y') }}</div>
                        </div>
                    @endif
                    @if ($post->total_posts)
                        <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-200">
                            <div class="text-xs text-blue-600 font-semibold mb-1 flex items-center gap-1">
                                <i class="fa-solid fa-briefcase"></i>
                                Total Vacancies
                            </div>
                            <div class="text-sm text-blue-900 font-bold">{{ number_format($post->total_posts) }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="max-w-none mb-4 post-content-wrapper bg-white rounded-lg p-5 border border-gray-200">
            <div class="post-content-isolated">
                {!! $post->content !!}
            </div>
        </div>

        <!-- Important Links -->
        @php
            $importantLinks = $post->important_links;
            // Handle case where important_links might be a JSON string instead of array
            if (is_string($importantLinks)) {
                $importantLinks = json_decode($importantLinks, true) ?? [];
            }
            // Ensure it's an array
            if (!is_array($importantLinks)) {
                $importantLinks = [];
            }
        @endphp
        @if (count($importantLinks) > 0)
            <div class="bg-gradient-to-r from-green-50 via-green-100 to-green-50 border-l-4 border-green-600 p-5 mb-4 rounded-r-xl shadow-sm">
                <h3 class="font-bold text-green-900 mb-4 text-base flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                    </svg>
                    Important Links
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($importantLinks as $key => $value)
                        @if (is_array($value) && isset($value['url']))
                            {{-- Old format: array with 'label' and 'url' --}}
                            <a href="{{ $value['url'] }}" target="_blank" rel="noopener noreferrer" 
                               class="flex items-center justify-between gap-3 bg-white hover:bg-green-50 border-2 border-green-200 hover:border-green-400 rounded-lg p-4 transition-all duration-200 shadow-sm hover:shadow-md group">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-green-800 group-hover:text-green-900 truncate">
                                        {{ $value['label'] ?? ucwords(str_replace('_', ' ', $key)) }}
                                    </span>
                                </div>
                                <svg class="w-5 h-5 text-green-600 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @else
                            {{-- New format: simple key-value pairs --}}
                            <a href="{{ $value }}" target="_blank" rel="noopener noreferrer" 
                               class="flex items-center justify-between gap-3 bg-white hover:bg-green-50 border-2 border-green-200 hover:border-green-400 rounded-lg p-4 transition-all duration-200 shadow-sm hover:shadow-md group">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-green-800 group-hover:text-green-900 truncate">
                                        {{ ucwords(str_replace('_', ' ', $key)) }}
                                    </span>
                                </div>
                                <svg class="w-5 h-5 text-green-600 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

    </article>

    <!-- Share Section - Outside article to avoid CSS conflicts -->
    <div class="share-section-wrapper bg-white border border-gray-200 rounded-xl p-3 md:p-6 mb-4 md:mb-8 shadow-sm">
        <h3 class="share-title font-bold text-gray-900 mb-3 md:mb-4 text-sm md:text-base flex items-center gap-2">
            <i class="fas fa-share-alt"></i> Share This Post
        </h3>
        
        @php
            $shareUrl = route('posts.show', [$post->type, $post->slug]);
            $shareTitle = $post->title;
            
            // Simple message for sharing
            $simpleMessage = "{$shareTitle} - Apply: {$shareUrl}";
            $encodedSimpleMessage = urlencode($simpleMessage);
            $encodedUrl = urlencode($shareUrl);
            $encodedTitle = urlencode($shareTitle);
        @endphp
        
        <div class="share-buttons-grid grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
            <!-- WhatsApp -->
            <a href="https://wa.me/?text={{ $encodedSimpleMessage }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="share-btn share-btn-whatsapp"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; padding: 8px 10px !important; color: white !important; text-decoration: none !important; border-radius: 8px !important; font-weight: 600 !important; background: #25D366 !important; font-size: 12px !important; border: none !important; box-shadow: none !important;">
                <i class="fab fa-whatsapp" style="font-size: 16px !important; color: white !important; margin: 0 !important; padding: 0 !important; background: none !important; border: none !important; box-shadow: none !important;"></i>
                <span class="share-btn-text hidden sm:inline" style="color: white !important; font-size: 12px !important;">WhatsApp</span>
            </a>
            
            <!-- Telegram -->
            <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="share-btn share-btn-telegram"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; padding: 8px 10px !important; color: white !important; text-decoration: none !important; border-radius: 8px !important; font-weight: 600 !important; background: #0088cc !important; font-size: 12px !important; border: none !important; box-shadow: none !important;">
                <i class="fab fa-telegram" style="font-size: 16px !important; color: white !important; margin: 0 !important; padding: 0 !important; background: none !important; border: none !important; box-shadow: none !important;"></i>
                <span class="share-btn-text hidden sm:inline" style="color: white !important; font-size: 12px !important;">Telegram</span>
            </a>
            
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="share-btn share-btn-facebook"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; padding: 8px 10px !important; color: white !important; text-decoration: none !important; border-radius: 8px !important; font-weight: 600 !important; background: #1877F2 !important; font-size: 12px !important; border: none !important; box-shadow: none !important;">
                <i class="fab fa-facebook-f" style="font-size: 16px !important; color: white !important; margin: 0 !important; padding: 0 !important; background: none !important; border: none !important; box-shadow: none !important;"></i>
                <span class="share-btn-text hidden sm:inline" style="color: white !important; font-size: 12px !important;">Facebook</span>
            </a>
            
            <!-- Twitter/X -->
            <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="share-btn share-btn-twitter"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; padding: 8px 10px !important; color: white !important; text-decoration: none !important; border-radius: 8px !important; font-weight: 600 !important; background: #000000 !important; font-size: 12px !important; border: none !important; box-shadow: none !important;">
                <i class="fab fa-twitter" style="font-size: 16px !important; color: white !important; margin: 0 !important; padding: 0 !important; background: none !important; border: none !important; box-shadow: none !important;"></i>
                <span class="share-btn-text hidden sm:inline" style="color: white !important; font-size: 12px !important;">Twitter</span>
            </a>
        </div>
        
        <p class="share-hint text-xs text-gray-700 mt-3 md:mt-4 text-center">
            <i class="fas fa-info-circle"></i> Share with your friends and help them stay updated!
        </p>
    </div>

    <!-- Ad Slot - After Post -->
    <x-ad-slot position="after_post" />

    <!-- Related Posts -->
    @if ($related->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4"><i class="fas fa-link"></i> Related Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($related as $relatedPost)
                    <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-lg transition-shadow">
                        <a href="{{ route('posts.show', ['type' => $relatedPost->type, 'post' => $relatedPost->slug]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            {{ $relatedPost->title }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection


<script>
// Handle external app opening for WebView
function openExternalApp(app, data) {
    // Check if running in WebView
    var isWebView = /WebView|wv|\.0\.0\.0|Version\/[\d.]+(?!.*Safari)/.test(navigator.userAgent);
    
    if (isWebView) {
        // For WebView, use native app schemes
        var url = '';
        switch(app) {
            case 'whatsapp':
                url = 'whatsapp://send?text=' + data;
                break;
            case 'telegram':
                url = 'tg://msg?text=' + data;
                break;
            case 'facebook':
                url = 'fb://page/';
                break;
            case 'twitter':
                url = 'twitter://post?message=' + data;
                break;
        }
        
        if (url) {
            // Try to open native app
            window.location.href = url;
            
            // Fallback to web version after 1 second if app not installed
            setTimeout(function() {
                if (app === 'whatsapp') {
                    window.location.href = 'https://wa.me/?text=' + data;
                } else if (app === 'telegram') {
                    window.location.href = 'https://t.me/share/url?text=' + data;
                }
            }, 1000);
        }
    }
}
</script>
