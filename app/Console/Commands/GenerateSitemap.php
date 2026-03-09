<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate and cache all sitemaps';

    public function handle()
    {
        $this->info('Generating sitemaps...');

        // Clear existing sitemap cache
        Cache::forget('sitemap:index');
        Cache::forget('sitemap:posts');
        Cache::forget('sitemap:categories');
        Cache::forget('sitemap:states');
        Cache::forget('sitemap:static');
        Cache::forget('sitemap:news');

        // Generate sitemaps by hitting the URLs
        $sitemaps = [
            '/sitemap.xml',
            '/sitemap-posts.xml',
            '/sitemap-categories.xml',
            '/sitemap-states.xml',
            '/sitemap-static.xml',
            '/sitemap-news.xml',
        ];

        foreach ($sitemaps as $sitemap) {
            $this->info("Generating {$sitemap}...");
            file_get_contents(url($sitemap));
        }

        $this->info('All sitemaps generated successfully!');
        return 0;
    }
}
