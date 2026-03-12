<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Category;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeFreeJobAlert extends Command
{
    protected $signature = 'scrape:freejobalert {--limit=50}';
    protected $description = 'Scrape government jobs from freejobalert.com';

    public function handle()
    {
        $this->info('Starting scrape from freejobalert.com...');
        
        $client = new Client([
            'timeout' => 30,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]);

        try {
            $response = $client->get('https://www.freejobalert.com/government-jobs/');
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $limit = $this->option('limit');
            $count = 0;

            // Find all job posts
            $crawler->filter('article, .post, .job-item, .entry')->each(function (Crawler $node) use (&$count, $limit, $client) {
                if ($count >= $limit) {
                    return;
                }

                try {
                    // Extract title
                    $titleNode = $node->filter('h2, h3, .title, .post-title')->first();
                    if (!$titleNode->count()) {
                        return;
                    }
                    
                    $title = trim($titleNode->text());
                    if (strlen($title) < 5) {
                        return;
                    }

                    // Check if post already exists
                    $slug = Str::slug($title);
                    if (Post::where('slug', $slug)->exists()) {
                        $this->line("⏭️  Skipping (exists): $title");
                        return;
                    }

                    // Extract link
                    $linkNode = $node->filter('a')->first();
                    $link = $linkNode->count() ? $linkNode->attr('href') : null;

                    // Extract description
                    $descNode = $node->filter('p, .excerpt, .description')->first();
                    $description = $descNode->count() ? trim($descNode->text()) : '';
                    $description = substr($description, 0, 500);

                    // Extract content (fetch from link if available)
                    $content = $description;
                    if ($link) {
                        try {
                            $postResponse = $client->get($link);
                            $postHtml = (string) $postResponse->getBody();
                            $postCrawler = new Crawler($postHtml);
                            
                            $contentNode = $postCrawler->filter('article, .post-content, .entry-content')->first();
                            if ($contentNode->count()) {
                                $content = $contentNode->html();
                            }
                        } catch (\Exception $e) {
                            // Use description as fallback
                        }
                    }

                    // Determine category based on title keywords
                    $categoryId = $this->determineCategoryId($title);
                    
                    // Determine state (default to All India)
                    $stateId = 37; // All India

                    // Create post
                    $post = Post::create([
                        'title' => $title,
                        'slug' => $slug,
                        'type' => 'job',
                        'short_description' => $description,
                        'content' => $content ?: '<p>' . htmlspecialchars($description) . '</p>',
                        'category_id' => $categoryId,
                        'state_id' => $stateId,
                        'admin_id' => 1,
                        'is_published' => true,
                        'is_featured' => false,
                        'meta_title' => substr($title, 0, 60),
                        'meta_description' => substr($description, 0, 160),
                        'meta_keywords' => implode(',', array_slice(explode(' ', $title), 0, 5))
                    ]);

                    $count++;
                    $this->line("✅ Created: $title");

                } catch (\Exception $e) {
                    $this->error("Error processing post: " . $e->getMessage());
                }
            });

            $this->info("\n✅ Scraping complete! Created $count new posts.");

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }

    private function determineCategoryId($title)
    {
        $title = strtolower($title);
        
        $categories = [
            1 => ['bank', 'sbi', 'ibps', 'clerk', 'po'],
            2 => ['railway', 'rrb', 'ntpc'],
            3 => ['ssc', 'cgl', 'chsl'],
            4 => ['upsc', 'ias', 'ips', 'civil service'],
            5 => ['defence', 'army', 'navy', 'air force'],
            6 => ['police', 'constable', 'si'],
            7 => ['teacher', 'teaching', 'lecturer', 'professor'],
            8 => ['psu', 'ntpc', 'bhel', 'iocl'],
            9 => ['state', 'psc'],
            10 => ['central', 'government'],
            12 => ['medical', 'neet', 'doctor', 'nurse'],
            13 => ['engineering', 'gate'],
        ];

        foreach ($categories as $categoryId => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($title, $keyword) !== false) {
                    return $categoryId;
                }
            }
        }

        return 9; // Default to State Govt
    }
}
