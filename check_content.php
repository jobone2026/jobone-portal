<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$post = App\Models\Post::where('slug', 'latest-rssb-ayush-officer-result-cutoff-2026-out-jobs')->first();

if ($post) {
    // Check if content has <style> tags
    if (strpos($post->content, '<style>') !== false) {
        echo "✓ Content HAS <style> tags\n\n";
    } else {
        echo "✗ Content DOES NOT have <style> tags\n\n";
    }
    
    // Show first 800 characters
    echo "First 800 characters of content:\n";
    echo "=====================================\n";
    echo substr($post->content, 0, 800);
    echo "\n=====================================\n";
} else {
    echo "Post not found!\n";
}
