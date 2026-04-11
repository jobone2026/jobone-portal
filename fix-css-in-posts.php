<?php
/**
 * Fix CSS showing as visible text in posts
 * This script removes inline <style> tags from post content
 * since we have fallback styles in the blade template
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Post;

echo "========================================\n";
echo "Fixing CSS in Posts\n";
echo "========================================\n\n";

// Get all posts that have style tags in content
$posts = Post::where('content', 'LIKE', '%<style>%')
    ->orWhere('content', 'LIKE', '%jobone-premium-ui%')
    ->get();

echo "Found " . $posts->count() . " posts with inline styles\n\n";

$fixed = 0;
$errors = 0;

foreach ($posts as $post) {
    try {
        $originalLength = strlen($post->content);
        
        // Remove <style> tags and their content
        $cleanContent = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $post->content);
        
        // Remove the wrapping div if it exists
        $cleanContent = preg_replace('/<div class="jobone-premium-ui">/i', '', $cleanContent);
        $cleanContent = preg_replace('/<\/div>\s*$/i', '', $cleanContent);
        
        $newLength = strlen($cleanContent);
        $removed = $originalLength - $newLength;
        
        if ($removed > 0) {
            $post->content = $cleanContent;
            $post->save();
            
            $fixed++;
            echo "✓ Fixed: {$post->title}\n";
            echo "  Removed {$removed} characters of CSS\n";
        } else {
            echo "- Skipped: {$post->title} (no changes needed)\n";
        }
        
    } catch (Exception $e) {
        $errors++;
        echo "✗ Error fixing {$post->title}: {$e->getMessage()}\n";
    }
}

echo "\n========================================\n";
echo "Summary:\n";
echo "  Total posts checked: " . $posts->count() . "\n";
echo "  Successfully fixed: {$fixed}\n";
echo "  Errors: {$errors}\n";
echo "========================================\n";
echo "\n✅ Done! The fallback CSS in show.blade.php will now style the content.\n";
