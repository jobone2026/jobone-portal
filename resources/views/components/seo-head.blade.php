@props(['seo' => null, 'schema' => null, 'noindex' => false])

@php
    $defaultSeo = [
        'title' => 'JobOne.in - Latest Government Jobs, Admit Cards, Results & More',
        'description' => 'Find latest government job notifications, admit cards, results, answer keys, and syllabus for SSC, UPSC, Railways, Banking, State PSC, Defence, Police, and Teaching jobs across India.',
        'keywords' => 'government jobs, sarkari naukri, admit card, result, answer key, syllabus, SSC, UPSC, Railways, Banking',
        'canonical' => url()->current(),
        'og_title' => 'JobOne.in - Latest Government Jobs Portal',
        'og_description' => 'Your trusted source for government job notifications and exam updates',
        'og_image' => asset('images/og-image.jpg'),
        'og_url' => url()->current(),
    ];
    
    $seo = array_merge($defaultSeo, $seo ?? []);
@endphp

<!-- Primary Meta Tags -->
<title>{{ $seo['title'] }}</title>
<meta name="title" content="{{ $seo['title'] }}">
<meta name="description" content="{{ $seo['description'] }}">
<meta name="keywords" content="{{ $seo['keywords'] }}">
<link rel="canonical" href="{{ $seo['canonical'] }}">

<!-- Robots Meta Tag -->
@if($noindex)
<meta name="robots" content="noindex, follow">
@else
<meta name="robots" content="index, follow">
@endif
<meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="JobOne.in">
<meta property="og:title" content="{{ $seo['og_title'] }}">
<meta property="og:description" content="{{ $seo['og_description'] }}">
<meta property="og:image" content="{{ $seo['og_image'] }}">
<meta property="og:url" content="{{ $seo['og_url'] }}">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo['og_title'] }}">
<meta name="twitter:description" content="{{ $seo['og_description'] }}">
<meta name="twitter:image" content="{{ $seo['og_image'] }}">

<!-- Preconnect -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://www.google-analytics.com">
<link rel="preconnect" href="https://cdnjs.cloudflare.com">

<!-- DNS Prefetch -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//www.google-analytics.com">
<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

<!-- Hreflang -->
<link rel="alternate" hreflang="en-in" href="{{ $seo['canonical'] }}">
<link rel="alternate" hreflang="x-default" href="{{ $seo['canonical'] }}">

<!-- Structured Data (JSON-LD) -->
@if($schema)
    @foreach($schema as $schemaItem)
        <script type="application/ld+json">{!! json_encode($schemaItem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endforeach
@endif
