<?php

/**
 * Remove Telegram Links from Posts
 * This script removes all Telegram links from post content in the database
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "==============================================\n";
echo "Remove Telegram Links from Posts\n";
echo "==============================================\n\n";

// Get all posts
$posts = DB::table('posts')->get();

echo "Found " . $posts->count() . " posts to check.\n\n";

$updatedCount = 0;
$telegramPatternsFound = 0;

foreach ($posts as $post) {
    $originalContent = $post->content;
    $modified = false;
    
    // Remove Telegram links and related content
    $patterns = [
        // Telegram links (t.me, telegram.me)
        '/<a[^>]*href=["\']https?:\/\/(t\.me|telegram\.me)[^"\']*["\'][^>]*>.*?<\/a>/i',
        
        // Telegram channel/group mentions (@username)
        '/<a[^>]*href=["\']https?:\/\/(t\.me|telegram\.me)\/[^"\']*["\'][^>]*>@[^<]*<\/a>/i',
        
        // Plain Telegram URLs
        '/https?:\/\/(t\.me|telegram\.me)\/[^\s<>"]+/i',
        
        // Telegram join links
        '/<a[^>]*>.*?(Join|Follow).*?Telegram.*?<\/a>/i',
        
        // Telegram buttons/badges
        '/<[^>]*class=["\'][^"\']*telegram[^"\']*["\'][^>]*>.*?<\/[^>]+>/i',
        
        // Telegram icons/images
        '/<img[^>]*telegram[^>]*>/i',
        
        // Text mentions of Telegram channels
        '/Telegram\s*Channel\s*:?\s*@?[a-zA-Z0-9_]+/i',
        '/Join\s+our\s+Telegram\s+Channel/i',
        '/Follow\s+us\s+on\s+Telegram/i',
        
        // Telegram divs/sections
        '/<div[^>]*telegram[^>]*>.*?<\/div>/is',
        '/<p[^>]*>.*?telegram.*?<\/p>/is',
        
        // Promotional text patterns
        '/Download Mobile Apps for the Latest Updates/i',
        '/How to [A-Z]+ OTR Registration \(Video Hindi\)/i',
        '/Download Date Extended Notice/i',
        '/Marital Bio Data Maker/i',
        '/Join Channel/i',
        '/Full Notification Before/i',
        
        // Generic promotional patterns
        '/<a[^>]*>Download Mobile Apps.*?<\/a>/i',
        '/<a[^>]*>Join Channel.*?<\/a>/i',
        '/<a[^>]*>.*?Bio Data Maker.*?<\/a>/i',
        
        // Remove standalone promotional text
        '/Download\s+Mobile\s+Apps\s+for\s+the\s+Latest\s+Updates/i',
        '/Marital\s+Bio\s+Data\s+Maker/i',
        '/Join\s+Channel\s*/i',
    ];
    
    $newContent = $originalContent;
    
    foreach ($patterns as $pattern) {
        $before = $newContent;
        $newContent = preg_replace($pattern, '', $newContent);
        if ($before !== $newContent) {
            $modified = true;
            $telegramPatternsFound++;
        }
    }
    
    // Clean up extra whitespace and empty tags
    $newContent = preg_replace('/<p>\s*<\/p>/i', '', $newContent);
    $newContent = preg_replace('/<div>\s*<\/div>/i', '', $newContent);
    $newContent = preg_replace('/\n\s*\n\s*\n/', "\n\n", $newContent);
    $newContent = trim($newContent);
    
    if ($modified && $newContent !== $originalContent) {
        // Update the post
        DB::table('posts')
            ->where('id', $post->id)
            ->update([
                'content' => $newContent,
                'updated_at' => now()
            ]);
        
        $updatedCount++;
        echo "✓ Updated Post ID: {$post->id} - {$post->title}\n";
    }
}

echo "\n==============================================\n";
echo "Summary:\n";
echo "==============================================\n";
echo "Total posts checked: " . $posts->count() . "\n";
echo "Posts updated: {$updatedCount}\n";
echo "Telegram patterns found: {$telegramPatternsFound}\n";
echo "\n✓ Done!\n";
echo "\nNote: Please clear cache after running this script:\n";
echo "php artisan cache:clear\n";
echo "php artisan view:clear\n";
