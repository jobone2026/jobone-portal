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
        $datePosted   = $post->created_at->toIso8601String();
        $dateModified = $post->updated_at->toIso8601String();

        // Get state name for location
        $stateName       = $post->state->name ?? 'All India';
        $addressLocality = $stateName !== 'All India' ? $stateName : 'New Delhi';

        // directApply: use structured field first, fallback to URL presence
        $applyUrl    = $post->apply_url ?? $post->online_form ?? '';
        $directApply = (bool)($post->direct_apply ?? !empty($applyUrl));

        // Employment type: stipend roles → OTHER
        $empType = 'FULL_TIME';
        if (($post->salary_type ?? 'salary') === 'stipend') $empType = 'OTHER';

        $schema = [
            '@context'           => 'https://schema.org',
            '@type'              => 'JobPosting',
            'title'              => $post->title,
            'description'        => $description,
            'datePosted'         => $datePosted,
            'dateModified'       => $dateModified,
            'employmentType'     => $empType,
            'directApply'        => $directApply,
            'hiringOrganization' => [
                '@type'  => 'Organization',
                'name'   => $post->organization ?: ($post->category->name ?? 'Government of India'),
                'sameAs' => url('/'),
            ],
            'jobLocation' => [
                '@type'   => 'Place',
                'address' => [
                    '@type'           => 'PostalAddress',
                    'addressLocality' => $addressLocality,
                    'addressRegion'   => $stateName,
                    'addressCountry'  => 'IN',
                ],
            ],
        ];

        // validThrough: use last_date, fallback to +90 days
        if ($post->last_date) {
            $schema['validThrough'] = $post->last_date->toIso8601String();
        } else {
            $schema['validThrough'] = now()->addDays(90)->toIso8601String();
        }

        // applicationDeadline (same as validThrough for Google)
        $schema['applicationDeadline'] = $schema['validThrough'];

        // Apply URL
        if (!empty($applyUrl)) {
            $schema['applicationContact'] = [
                '@type'       => 'ContactPoint',
                'contactType' => 'Apply Online',
                'url'         => $applyUrl,
            ];
        }

        // baseSalary: prefer numeric min/max, fallback to description string
        if ($post->salary) {
            $salaryValue = [];
            if ($post->salary_min && $post->salary_max) {
                $salaryValue = [
                    '@type'    => 'QuantitativeValue',
                    'minValue' => (int)$post->salary_min,
                    'maxValue' => (int)$post->salary_max,
                    'unitText' => 'MONTH',
                ];
            } else {
                $salaryValue = [
                    '@type'       => 'QuantitativeValue',
                    'description' => $post->salary,
                    'unitText'    => 'MONTH',
                ];
            }
            $schema['baseSalary'] = [
                '@type'    => 'MonetaryAmount',
                'currency' => 'INR',
                'value'    => $salaryValue,
            ];
        } else {
            // Default salary structure
            $schema['baseSalary'] = [
                '@type'    => 'MonetaryAmount',
                'currency' => 'INR',
                'value'    => ['@type' => 'QuantitativeValue', 'minValue' => 20000, 'maxValue' => 100000, 'unitText' => 'MONTH'],
            ];
        }

        // Optional fields
        if ($post->total_posts) {
            $schema['totalJobOpenings'] = (int)$post->total_posts;
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

    public function generateFAQ(string $content, ?array $faqJson = null): ?array
    {
        // Prefer structured FAQ JSON from DB column
        if (!empty($faqJson)) {
            $questions = [];
            foreach (array_slice($faqJson, 0, 10) as $item) {
                if (empty($item['question']) || empty($item['answer'])) continue;
                $questions[] = [
                    '@type' => 'Question',
                    'name'  => $item['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $item['answer'],
                    ],
                ];
            }
            if (!empty($questions)) {
                return [
                    '@context'   => 'https://schema.org',
                    '@type'      => 'FAQPage',
                    'mainEntity' => $questions,
                ];
            }
        }

        // Fallback: extract H3 + P pairs from HTML content
        $cleanContent = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $content);
        preg_match_all('/<h3[^>]*>(.*?)<\/h3>\s*<p[^>]*>(.*?)<\/p>/is', $cleanContent, $matches, PREG_SET_ORDER);

        if (count($matches) < 2) return null;

        $questions = [];
        foreach (array_slice($matches, 0, 10) as $match) {
            $questions[] = [
                '@type' => 'Question',
                'name'  => strip_tags($match[1]),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => strip_tags($match[2]),
                ],
            ];
        }

        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
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
            'job'        => 'posts.jobs',
            'admit_card' => 'posts.admit-cards',
            'result'     => 'posts.results',
            'answer_key' => 'posts.answer-keys',
            'syllabus'   => 'posts.syllabus',
            'blog'       => 'posts.blogs',
        ];

        $routeName  = $routeMap[$post->type] ?? 'home';
        // Use canonical slug URL instead of url()->current() to avoid CDN/cache issues
        $canonicalUrl = url('/' . $post->slug);

        $items = [
            ['label' => 'Home', 'url' => url('/')],
            ['label' => ucfirst(str_replace('_', ' ', $post->type)), 'url' => route($routeName)],
            ['label' => $post->title, 'url' => $canonicalUrl],
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
