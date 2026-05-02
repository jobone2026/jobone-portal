<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use App\Services\IndexNowService;
use Illuminate\Support\Facades\Artisan;

echo "Starting reindex process...\n";

// Generate fresh sitemaps
echo "Regenerating sitemaps...\n";
Artisan::call('sitemap:generate');
echo Artisan::output();

// Fetch active posts
$posts = Post::where('is_published', 1)->get();
echo "Found " . $posts->count() . " active posts.\n";

$urls = [];
foreach ($posts as $post) {
    // Generate URL using same logic as SubmitToIndexNow job
    $urls[] = route('posts.show', ['type' => $post->type, 'post' => $post]);
}

// Add important static URLs
$urls[] = url('/');
$urls[] = url('/sitemap.xml');

// Submit via IndexNow
$indexNow = app(IndexNowService::class);
$chunks = array_chunk($urls, 10000);

foreach ($chunks as $chunk) {
    $result = $indexNow->submitUrls($chunk);
    if ($result) {
        echo "Successfully submitted " . count($chunk) . " URLs to IndexNow.\n";
    } else {
        echo "Failed to submit URLs to IndexNow.\n";
    }
}

// Ping Google
$sitemapUrl = url('/sitemap.xml');
echo "Pinging Google with sitemap: {$sitemapUrl}\n";
try {
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'ignore_errors' => true
        ]
    ]);
    $googlePing = @file_get_contents("https://www.google.com/ping?sitemap=" . urlencode($sitemapUrl), false, $context);
    echo "Pinged Google. Response code: " . (isset($http_response_header) ? $http_response_header[0] : 'Unknown') . "\n";
} catch (\Exception $e) {
    echo "Error pinging Google: " . $e->getMessage() . "\n";
}

echo "Done.\n";
