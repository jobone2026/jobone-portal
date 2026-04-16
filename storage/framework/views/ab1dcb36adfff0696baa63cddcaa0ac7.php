<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['seo' => null, 'schema' => null, 'noindex' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['seo' => null, 'schema' => null, 'noindex' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
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
?>

<!-- Primary Meta Tags -->
<title><?php echo e($seo['title']); ?></title>
<meta name="title" content="<?php echo e($seo['title']); ?>">
<meta name="description" content="<?php echo e($seo['description']); ?>">
<meta name="keywords" content="<?php echo e($seo['keywords']); ?>">
<link rel="canonical" href="<?php echo e($seo['canonical']); ?>">

<!-- Robots Meta Tag -->
<?php if($noindex): ?>
<meta name="robots" content="noindex, follow">
<?php else: ?>
<meta name="robots" content="index, follow">
<?php endif; ?>
<meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="JobOne.in">
<meta property="og:title" content="<?php echo e($seo['og_title']); ?>">
<meta property="og:description" content="<?php echo e($seo['og_description']); ?>">
<meta property="og:image" content="<?php echo e($seo['og_image']); ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="<?php echo e($seo['og_title']); ?>">
<meta property="og:url" content="<?php echo e($seo['og_url']); ?>">
<meta property="og:locale" content="en_IN">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@JobOneIn">
<meta name="twitter:title" content="<?php echo e($seo['og_title']); ?>">
<meta name="twitter:description" content="<?php echo e($seo['og_description']); ?>">
<meta name="twitter:image" content="<?php echo e($seo['og_image']); ?>">
<meta name="twitter:image:alt" content="<?php echo e($seo['og_title']); ?>">

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
<link rel="alternate" hreflang="en-in" href="<?php echo e($seo['canonical']); ?>">
<link rel="alternate" hreflang="x-default" href="<?php echo e($seo['canonical']); ?>">

<!-- Structured Data (JSON-LD) -->
<?php if($schema): ?>
    <?php $__currentLoopData = $schema; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schemaItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script type="application/ld+json"><?php echo json_encode($schemaItem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\job\govt-job-portal-new\resources\views/components/seo-head.blade.php ENDPATH**/ ?>