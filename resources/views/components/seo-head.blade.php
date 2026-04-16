@props(['seo' => null, 'schema' => null, 'noindex' => false])

@php
    $defaultSeo = [
        'title'          => 'JobOne.in - Latest Government Jobs, Sarkari Naukri, Admit Cards & Results',
        'description'    => 'Find latest government jobs, sarkari naukri, admit cards, results, answer keys, syllabus for SSC, UPSC, Railways, Banking, State PSC, Defence, Police across India.',
        'keywords'       => 'government jobs, sarkari naukri, sarkari result, admit card, SSC, UPSC, Railways, Banking, free job alert',
        'canonical'      => url()->current(),
        'og_title'       => 'JobOne.in - Sarkari Naukri Portal',
        'og_description' => 'Your trusted source for government job notifications and exam updates across India.',
        'og_image'       => asset('images/og-image.jpg'),
        'og_url'         => url()->current(),
    ];
    $seo = array_merge($defaultSeo, $seo ?? []);
    $isHome = request()->is('/');
@endphp

<!-- Primary Meta Tags -->
<title>{{ $seo['title'] }}</title>
<meta name="title" content="{{ $seo['title'] }}">
<meta name="description" content="{{ $seo['description'] }}">
<meta name="keywords" content="{{ $seo['keywords'] }}">
<meta name="author" content="JobOne.in">
<meta name="publisher" content="JobOne.in">
<meta name="copyright" content="JobOne.in">
<meta name="language" content="English">
<meta name="revisit-after" content="1 day">
<link rel="canonical" href="{{ $seo['canonical'] }}">

<!-- Geo Tags (India targeting) -->
<meta name="geo.region" content="IN">
<meta name="geo.placename" content="India">
<meta name="ICBM" content="20.5937, 78.9629">

<!-- Mobile Web App -->
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="JobOne">
<meta name="application-name" content="JobOne.in">
<meta name="theme-color" content="#2563eb">

<!-- Robots Meta Tag -->
@if($noindex)
<meta name="robots" content="noindex, follow">
@else
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
@endif
<meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="JobOne.in">
<meta property="og:title" content="{{ $seo['og_title'] }}">
<meta property="og:description" content="{{ $seo['og_description'] }}">
<meta property="og:image" content="{{ $seo['og_image'] }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $seo['og_title'] }}">
<meta property="og:url" content="{{ $seo['og_url'] }}">
<meta property="og:locale" content="en_IN">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@JobOneIn">
<meta name="twitter:title" content="{{ $seo['og_title'] }}">
<meta name="twitter:description" content="{{ $seo['og_description'] }}">
<meta name="twitter:image" content="{{ $seo['og_image'] }}">
<meta name="twitter:image:alt" content="{{ $seo['og_title'] }}">

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

<!-- WebSite Schema (enables Google Sitelinks Searchbox) -->
@if($isHome)
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "JobOne.in",
  "alternateName": ["JobOne", "Sarkari Naukri JobOne"],
  "url": "https://jobone.in",
  "description": "India's trusted government job portal for SSC, UPSC, Railways, Banking, State PSC recruitment notifications, admit cards, results and syllabus.",
  "potentialAction": {
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "https://jobone.in/search?q={search_term_string}"
    },
    "query-input": "required name=search_term_string"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "JobOne.in",
  "url": "https://jobone.in",
  "logo": "https://jobone.in/images/logo.png",
  "description": "India's trusted government job portal providing latest sarkari naukri, admit cards, exam results, answer keys and syllabus.",
  "foundingDate": "2024",
  "areaServed": "India",
  "knowsAbout": ["Government Jobs", "SSC", "UPSC", "Railways Recruitment", "Banking Jobs", "State PSC", "Admit Cards", "Exam Results"],
  "sameAs": [
    "https://www.facebook.com/jobone.in",
    "https://twitter.com/JobOneIn",
    "https://t.me/jobone_in"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "contactType": "customer support",
    "areaServed": "IN",
    "availableLanguage": ["English", "Hindi"]
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How to find latest government jobs in India?",
      "acceptedAnswer": {"@type": "Answer", "text": "Visit JobOne.in to find the latest government job notifications across India including SSC, UPSC, Railways, Banking, State PSC, Defence, Police and Teaching jobs. We update daily with new recruitment notifications."}
    },
    {
      "@type": "Question",
      "name": "How to download admit card for government exams?",
      "acceptedAnswer": {"@type": "Answer", "text": "Visit the Admit Cards section on JobOne.in, search for your exam name, and click the official link to download your hall ticket or call letter from the official website."}
    },
    {
      "@type": "Question",
      "name": "How to check sarkari result 2026?",
      "acceptedAnswer": {"@type": "Answer", "text": "Go to the Results section on JobOne.in to find the latest sarkari results for SSC, UPSC, Railways, Banking, State PSC, and other government exams. We provide direct links to official result pages."}
    },
    {
      "@type": "Question",
      "name": "What is the qualification for government jobs in India?",
      "acceptedAnswer": {"@type": "Answer", "text": "Government job qualifications vary by post. Many jobs are available for 10th/12th pass, graduates, and postgraduates. SSC CGL requires graduation, Railways Group D requires 10th pass, and UPSC IAS requires any graduation degree."}
    },
    {
      "@type": "Question",
      "name": "Is JobOne.in free to use?",
      "acceptedAnswer": {"@type": "Answer", "text": "Yes, JobOne.in is completely free. You can browse all government job notifications, admit cards, results, answer keys and syllabus without any registration or payment."}
    }
  ]
}
</script>
@endif
