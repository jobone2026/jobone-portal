<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class FixBlogContent extends Command
{
    protected $signature = 'fix:blog-content';
    protected $description = 'Fix blog posts with full HTML document structure';

    public function handle()
    {
        $this->info('🔧 Fixing blog post content...');

        $blogPosts = Post::where('type', 'blog')
            ->where('content', 'like', '<!DOCTYPE%')
            ->orWhere('content', 'like', '<html%')
            ->get();

        if ($blogPosts->isEmpty()) {
            $this->info('✅ No blog posts need fixing');
            return 0;
        }

        $this->warn("Found {$blogPosts->count()} blog posts to fix");

        foreach ($blogPosts as $post) {
            $content = $post->content;

            // Extract content from body tag
            if (preg_match('/<body[^>]*>(.*)<\/body>/is', $content, $matches)) {
                $content = $matches[1];
                $this->line("  ✓ Extracted body content from: {$post->title}");
            }

            // Remove DOCTYPE and html/head tags
            $content = preg_replace('/<\?xml[^>]*\?>/i', '', $content);
            $content = preg_replace('/<!DOCTYPE[^>]*>/i', '', $content);
            $content = preg_replace('/<html[^>]*>/i', '', $content);
            $content = preg_replace('/<\/html>/i', '', $content);
            $content = preg_replace('/<head[^>]*>.*?<\/head>/is', '', $content);

            // Clean up extra whitespace
            $content = trim($content);

            // Update the post
            $post->update(['content' => $content]);
            $this->line("  ✅ Fixed: {$post->title}");
        }

        $this->info('✅ All blog posts fixed successfully!');
        return 0;
    }
}
