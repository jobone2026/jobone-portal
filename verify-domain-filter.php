#!/usr/bin/env php
<?php

/**
 * Domain State Filter Verification Script
 * Run this to verify your domain filtering setup
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n";
echo "===========================================\n";
echo "Domain State Filter Verification\n";
echo "===========================================\n\n";

// Check .env configuration
echo "1. Checking .env configuration...\n";
$domainMap = env('DOMAIN_STATE_MAP');
if (empty($domainMap)) {
    echo "   ❌ DOMAIN_STATE_MAP not found in .env\n";
    echo "   Please add: DOMAIN_STATE_MAP=karnatakajob.online:karnataka\n\n";
    exit(1);
}
echo "   ✓ DOMAIN_STATE_MAP found: $domainMap\n\n";

// Parse domain map
echo "2. Parsing domain mappings...\n";
$pairs = explode(',', $domainMap);
$mappings = [];
foreach ($pairs as $pair) {
    $parts = explode(':', trim($pair));
    if (count($parts) === 2) {
        $domain = trim($parts[0]);
        $stateSlug = trim($parts[1]);
        $mappings[$domain] = $stateSlug;
        echo "   ✓ $domain → $stateSlug\n";
    }
}
echo "\n";

// Check states exist in database
echo "3. Verifying states in database...\n";
foreach ($mappings as $domain => $stateSlug) {
    $state = \App\Models\State::where('slug', $stateSlug)->first();
    if ($state) {
        echo "   ✓ State '$stateSlug' found (ID: {$state->id}, Name: {$state->name})\n";
        
        // Count posts for this state
        $postCount = \App\Models\Post::where('state_id', $state->id)->count();
        $publishedCount = \App\Models\Post::where('state_id', $state->id)
            ->where('is_published', true)->count();
        echo "     Posts: $postCount total, $publishedCount published\n";
    } else {
        echo "   ❌ State '$stateSlug' NOT FOUND in database\n";
        echo "     Run: php artisan tinker\n";
        echo "     Then: \\App\\Models\\State::create(['name' => 'Karnataka', 'slug' => 'karnataka']);\n";
    }
}
echo "\n";

// Check middleware registration
echo "4. Checking middleware registration...\n";
$middlewareFile = __DIR__.'/bootstrap/app.php';
$content = file_get_contents($middlewareFile);
if (strpos($content, 'DomainStateFilter') !== false) {
    echo "   ✓ DomainStateFilter middleware registered\n";
} else {
    echo "   ❌ DomainStateFilter middleware NOT registered\n";
    echo "     Check bootstrap/app.php\n";
}
echo "\n";

// Check middleware file exists
echo "5. Checking middleware file...\n";
$middlewareClass = __DIR__.'/app/Http/Middleware/DomainStateFilter.php';
if (file_exists($middlewareClass)) {
    echo "   ✓ DomainStateFilter.php exists\n";
} else {
    echo "   ❌ DomainStateFilter.php NOT FOUND\n";
}
echo "\n";

// Summary
echo "===========================================\n";
echo "Verification Complete\n";
echo "===========================================\n\n";

echo "Next steps:\n";
echo "1. Clear cache: php artisan config:clear && php artisan cache:clear\n";
echo "2. Restart PHP-FPM: sudo systemctl restart php8.2-fpm\n";
echo "3. Configure DNS to point domain to this server\n";
echo "4. Test by visiting your domain\n\n";

echo "To test locally, add to /etc/hosts:\n";
foreach ($mappings as $domain => $stateSlug) {
    echo "   127.0.0.1 $domain\n";
}
echo "\n";
