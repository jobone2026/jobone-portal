<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use App\Models\State;
use Illuminate\Support\Str;

class SchemaService
{
    public function generateJobPosting(Post $post): array
    {
        // Remove style tags and their content before stripping other tags
        $cleanContent = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $post->content);
        $cleanContent = strip_tags($cleanContent);
        // Limit description to 5000 characters for schema
        $description = Str::limit($cleanContent, 5000);

        // datePosted must always be ISO8601 - use created_at which is always set
        $datePosted = $post->created_at->toIso8601String();

        $schema = [
            '@context'           => 'https://schema.org',
            '@type'              => 'JobPosting',
            'title'              => $post->title,
            'description'        => $description,
            'datePosted'         => $datePosted,
            'hiringOrganization' => [
                '@type'  => 'Organization',
                'name'   => $post->organization ?: ($post->category->name ?? 'Government of India'),
                'sameAs' => url('/'),
            ],
            'jobLocation' => [
                '@type'   => 'Place',
                'address' => [
                    '@type'         => 'PostalAddress',
                    'addressCountry' => 'IN',
                    'addressRegion'  => $post->state->name ?? 'India',
                ],
            ],
            'employmentType' => 'FULL_TIME',
        ];

        // Only add optional fields if they have values (avoid null in schema)
        if ($post->last_date) {
            $schema['validThrough']          = $post->last_date->toIso8601String();
            $schema['applicationDeadline']   = $post->last_date->toIso8601String();
        }
        if ($post->total_posts) {
            $schema['totalJobOpenings'] = $post->total_posts;
        }
        if ($post->online_form) {
            $schema['directApply'] = true;
        }
        if ($post->salary) {
            $schema['baseSalary'] = [
                '@type'    => 'MonetaryAmount',
                'currency' => 'INR',
                'value'    => [
                    '@type'    => 'QuantitativeValue',
                    'value'    => $post->salary,
                    'unitText' => 'MONTH',
                ],
            ];
        }

        return $schema;
    }

    public function generateArticle(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $post->short_description,
            'datePublished' => $post->created_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => 'JobOne.in',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'JobOne.in',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/jobone-logo.png'),
                ],
            ],
        ];
    }

    public function generateBreadcrumb(array $items): array
    {
        $listItems = [];
        foreach ($items as $index => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['label'],
                'item' => $item['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }

    public function generateWebSite(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'JobOne.in',
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/search?q={search_term_string}'),
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    public function generateOrganization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'JobOne.in',
            'url' => url('/'),
            'logo' => asset('images/jobone-logo.png'),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'email' => 'jobone2026@gmail.com',
                'contactType' => 'Customer Service',
            ],
            'sameAs' => [
                config('services.facebook_url'),
                config('services.twitter_url'),
                config('services.telegram_url'),
            ],
        ];
    }

    public function generateFAQ(string $content): ?array
    {
        // Remove style tags and their content first
        $cleanContent = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $content);
        
        // Extract H3 + P pairs as FAQ
        preg_match_all('/<h3[^>]*>(.*?)<\/h3>\s*<p[^>]*>(.*?)<\/p>/is', $cleanContent, $matches, PREG_SET_ORDER);
        
        if (count($matches) < 2) {
            return null;
        }

        $questions = [];
        foreach (array_slice($matches, 0, 10) as $match) {
            $questions[] = [
                '@type' => 'Question',
                'name' => strip_tags($match[1]),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($match[2]),
                ],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $questions,
        ];
    }

    // Alias methods for consistency
    public function generateJobPostingSchema(Post $post): array
    {
        return $this->generateJobPosting($post);
    }

    public function generateArticleSchema(Post $post): array
    {
        return $this->generateArticle($post);
    }

    public function generateBreadcrumbSchema(Post $post): array
    {
        // Map post types to their route names
        $routeMap = [
            'job' => 'posts.jobs',
            'admit_card' => 'posts.admit-cards',
            'result' => 'posts.results',
            'answer_key' => 'posts.answer-keys',
            'syllabus' => 'posts.syllabus',
            'blog' => 'posts.blogs',
        ];
        
        $routeName = $routeMap[$post->type] ?? 'home';
        
        $items = [
            ['label' => 'Home', 'url' => url('/')],
            ['label' => ucfirst(str_replace('_', ' ', $post->type)), 'url' => route($routeName)],
            ['label' => $post->title, 'url' => url()->current()],
        ];
        
        return $this->generateBreadcrumb($items);
    }

    public function generateWebSiteSchema(): array
    {
        return $this->generateWebSite();
    }

    public function generateOrganizationSchema(): array
    {
        return $this->generateOrganization();
    }

    public function generateFAQSchema(string $content): ?array
    {
        return $this->generateFAQ($content);
    }
}
