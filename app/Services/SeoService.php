<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use App\Models\State;
use Illuminate\Support\Str;

class SeoService
{
    public function generateTitle($page, $data = null): string
    {
        return match($page) {
            'home' => 'Latest Government Jobs 2026 - SSC, UPSC, Railways, Banking | JobOne.in',
            'post' => $this->generatePostTitle($data),
            'category' => "Latest {$data->name} Jobs 2026 | JobOne.in",
            'state' => "{$data->name} Government Jobs 2026 | JobOne.in",
            'jobs' => 'Latest Government Jobs 2026 | JobOne.in',
            'admit-cards' => 'Admit Cards 2026 - Download Hall Tickets | JobOne.in',
            'results' => 'Latest Results 2026 - Check Exam Results | JobOne.in',
            'answer-keys' => 'Answer Keys 2026 - Download Solutions | JobOne.in',
            'syllabus' => 'Exam Syllabus 2026 - Download PDF | JobOne.in',
            'blogs' => 'Career Guidance & Tips | JobOne.in',
            'search' => "Search Results for \"{$data}\" | JobOne.in",
            default => 'JobOne.in - Government Jobs Portal'
        };
    }

    private function generatePostTitle($post): string
    {
        // Use custom meta title if set
        if ($post->meta_title) {
            return Str::limit($post->meta_title, 57, '') . ' | JobOne.in';
        }

        // Extract components from title using regex
        $title = $post->title;
        $year = $this->extractYear($title);
        $org = $this->extractOrganization($title);
        $role = $this->extractRole($title);
        $total = $this->extractTotalPosts($title);

        // Generate smart title based on post type
        $smartTitle = match($post->type) {
            'job' => $this->generateJobTitle($org, $role, $year, $total),
            'admit_card' => $this->generateAdmitCardTitle($org, $role, $year),
            'result' => $this->generateResultTitle($org, $role, $year),
            'syllabus' => $this->generateSyllabusTitle($org, $role, $year),
            'answer_key' => $this->generateAnswerKeyTitle($org, $role, $year),
            'blog' => Str::limit($title, 50, ''),
            default => Str::limit($title, 50, '')
        };

        return $smartTitle . ' | JobOne.in';
    }

    private function extractYear($title): string
    {
        if (preg_match('/\b(20\d{2})\b/', $title, $matches)) {
            return $matches[1];
        }
        return date('Y');
    }

    private function extractOrganization($title): string
    {
        // Common organization patterns
        $patterns = [
            '/^([A-Z]{2,6})\s/',  // SSC, UPSC, IBPS, etc.
            '/^([A-Z][a-z]+\s[A-Z][a-z]+)\s/',  // Indian Army, State Bank, etc.
            '/^([A-Z][a-z]+)\s/',  // Railway, Banking, etc.
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $title, $matches)) {
                return trim($matches[1]);
            }
        }

        // Fallback: first 2-3 words
        $words = explode(' ', $title);
        return implode(' ', array_slice($words, 0, min(2, count($words))));
    }

    private function extractRole($title): string
    {
        // Common role patterns
        $roles = [
            'Constable', 'SI', 'Inspector', 'Officer', 'Clerk', 'PO', 'SO',
            'Assistant', 'Manager', 'Engineer', 'Teacher', 'Professor',
            'Group D', 'Group C', 'Group B', 'Group A', 'NTPC', 'ALP',
            'Technician', 'Stenographer', 'MTS', 'LDC', 'UDC', 'DEO'
        ];

        foreach ($roles as $role) {
            if (stripos($title, $role) !== false) {
                return $role;
            }
        }

        return 'Posts';
    }

    private function extractTotalPosts($title): ?string
    {
        // Match patterns like "150 Posts", "1000 Vacancies", etc.
        if (preg_match('/\b(\d+)\s*(Posts?|Vacancies|Vacancy)\b/i', $title, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function generateJobTitle($org, $role, $year, $total): string
    {
        if ($total) {
            $title = "{$org} Recruitment {$year} – {$total} Posts";
        } else {
            $title = "{$org} {$role} Recruitment {$year}";
        }
        return Str::limit($title, 50, '');
    }

    private function generateAdmitCardTitle($org, $role, $year): string
    {
        $title = "{$org} Admit Card {$year} – {$role} Hall Ticket";
        return Str::limit($title, 50, '');
    }

    private function generateResultTitle($org, $role, $year): string
    {
        $title = "{$org} {$role} Result {$year} – Merit List";
        return Str::limit($title, 50, '');
    }

    private function generateSyllabusTitle($org, $role, $year): string
    {
        $title = "{$org} {$role} Syllabus {$year} – Exam Pattern";
        return Str::limit($title, 50, '');
    }

    private function generateAnswerKeyTitle($org, $role, $year): string
    {
        $title = "{$org} {$role} Answer Key {$year} – Download";
        return Str::limit($title, 50, '');
    }

    public function generateDescription($page, $data = null): string
    {
        return match($page) {
            'home' => 'Find latest government jobs, admit cards, results, answer keys, and syllabus for SSC, UPSC, Railways, Banking, State PSC, Defence, Police, and Teaching exams in India.',
            'post' => $this->generatePostDescription($data),
            'category' => "Browse latest {$data->name} job notifications, admit cards, results, and exam updates. Apply for government jobs in {$data->name} sector.",
            'state' => "Latest government job notifications in {$data->name}. Find SSC, UPSC, Railways, Banking, and State PSC jobs in {$data->name}.",
            'jobs' => 'Browse latest government job notifications across India. Find SSC, UPSC, Railways, Banking, State PSC, Defence, Police, and Teaching jobs.',
            'admit-cards' => 'Download admit cards and hall tickets for government exams. Get SSC, UPSC, Railways, Banking, and State PSC admit cards.',
            'results' => 'Check latest government exam results. Find SSC, UPSC, Railways, Banking, State PSC, and other exam results.',
            'answer-keys' => 'Download answer keys for government exams. Get SSC, UPSC, Railways, Banking, and State PSC answer keys and solutions.',
            'syllabus' => 'Download exam syllabus PDF for government exams. Get detailed syllabus for SSC, UPSC, Railways, Banking, and State PSC exams.',
            'blogs' => 'Read career guidance, exam tips, and preparation strategies for government job exams in India.',
            'search' => "Search results for government jobs, admit cards, results, and exam updates matching \"{$data}\".",
            default => 'JobOne.in - Your trusted source for government job information in India.'
        };
    }

    private function generatePostDescription($post): string
    {
        $description = $post->meta_description ?? $post->short_description ?? strip_tags($post->content);
        return Str::limit($description, 155, '...');
    }

    public function generateKeywords($page, $data = null): string
    {
        $baseKeywords = 'government jobs, sarkari naukri, govt jobs 2026, india';
        
        return match($page) {
            'home' => "{$baseKeywords}, SSC, UPSC, Railways, Banking, State PSC, Defence, Police, Teaching",
            'post' => $this->generatePostKeywords($data),
            'category' => "{$data->name} jobs, {$data->name} recruitment, {$baseKeywords}",
            'state' => "{$data->name} jobs, {$data->name} government jobs, {$baseKeywords}",
            'jobs' => "government jobs, latest jobs, {$baseKeywords}",
            'admit-cards' => "admit card, hall ticket, exam admit card, {$baseKeywords}",
            'results' => "exam results, government exam results, {$baseKeywords}",
            'answer-keys' => "answer key, exam solutions, {$baseKeywords}",
            'syllabus' => "exam syllabus, government exam syllabus, {$baseKeywords}",
            'blogs' => "career guidance, exam tips, preparation, {$baseKeywords}",
            default => $baseKeywords
        };
    }

    private function generatePostKeywords($post): string
    {
        $keywords = $post->meta_keywords ?? '';
        if (empty($keywords)) {
            $keywords = implode(', ', [
                $post->category->name ?? '',
                $post->state->name ?? '',
                $post->type,
                'government jobs',
                '2026'
            ]);
        }
        return $keywords;
    }

    public function generateCanonical($url): string
    {
        return rtrim($url, '/');
    }

    public function generateOgTags($page, $data = null): array
    {
        return [
            'og:title' => $this->generateTitle($page, $data),
            'og:description' => $this->generateDescription($page, $data),
            'og:url' => $this->generateCanonical(url()->current()),
            'og:type' => $page === 'post' ? 'article' : 'website',
            'og:site_name' => 'JobOne.in',
            'og:locale' => 'en_IN',
            'og:image' => asset('images/og-image.jpg'),
        ];
    }

    public function generateTwitterTags($page, $data = null): array
    {
        return [
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $this->generateTitle($page, $data),
            'twitter:description' => $this->generateDescription($page, $data),
            'twitter:image' => asset('images/og-image.jpg'),
        ];
    }

    // Convenience methods for controllers
    public function generateHomeSeo(): array
    {
        // Check if domain is filtered to Karnataka
        $isKarnatakaDomain = config('app.domain_state_slug') === 'karnataka';
        
        if ($isKarnatakaDomain) {
            return [
                'title' => 'Karnataka Government Jobs 2026 - Latest Govt Jobs in Karnataka | KarnatakaJob.Online',
                'description' => 'Find latest Karnataka government jobs 2026, Karnataka govt jobs, Karnataka job alerts, Karnataka sarkari naukri, govt jobs in Karnataka for freshers, Karnataka recruitment 2026. Your trusted Karnataka job portal.',
                'keywords' => 'karnataka government jobs, karnataka govt jobs 2026, latest govt jobs in karnataka, karnataka job alerts, karnataka sarkari naukri, govt jobs in karnataka for freshers, karnataka recruitment 2026, karnataka job portal, karnataka sarkari result, karnataka job vacancy',
                'canonical' => url('/'),
                'og_title' => 'Karnataka Government Jobs 2026 - Latest Govt Jobs in Karnataka',
                'og_description' => 'Find latest Karnataka government jobs 2026, Karnataka govt jobs, Karnataka job alerts, Karnataka sarkari naukri, govt jobs in Karnataka for freshers.',
                'og_image' => asset('images/og-image.jpg'),
                'og_url' => url('/'),
            ];
        }
        
        return [
            'title' => 'Latest Government Jobs 2026 - SSC, UPSC, Railways, Banking | JobOne.in',
            'description' => $this->generateDescription('home'),
            'keywords' => $this->generateKeywords('home'),
            'canonical' => url('/'),
            'og_title' => 'JobOne.in - Latest Government Jobs 2026',
            'og_description' => $this->generateDescription('home'),
            'og_image' => asset('images/og-image.jpg'),
            'og_url' => url('/'),
        ];
    }

    public function generateListingSeo($type): array
    {
        $typeNames = [
            'job' => 'Jobs',
            'admit_card' => 'Admit Cards',
            'result' => 'Results',
            'answer_key' => 'Answer Keys',
            'syllabus' => 'Syllabus',
            'blog' => 'Blogs',
        ];

        $typeName = $typeNames[$type] ?? 'Posts';
        
        return [
            'title' => "Latest {$typeName} 2026 | JobOne.in",
            'description' => $this->generateDescription($type === 'job' ? 'jobs' : str_replace('_', '-', $type) . 's'),
            'keywords' => $this->generateKeywords($type === 'job' ? 'jobs' : str_replace('_', '-', $type) . 's'),
            'canonical' => url()->current(),
            'og_title' => "Latest {$typeName} 2026 | JobOne.in",
            'og_description' => $this->generateDescription($type === 'job' ? 'jobs' : str_replace('_', '-', $type) . 's'),
            'og_image' => asset('images/og-image.jpg'),
            'og_url' => url()->current(),
        ];
    }

    public function generatePostSeo(Post $post): array
    {
        return [
            'title' => $this->generatePostTitle($post),
            'description' => $this->generatePostDescription($post),
            'keywords' => $this->generatePostKeywords($post),
            'canonical' => url()->current(),
            'og_title' => $this->generatePostTitle($post),
            'og_description' => $this->generatePostDescription($post),
            'og_image' => $post->image ?? asset('images/og-image.jpg'),
            'og_url' => url()->current(),
        ];
    }

    public function generateCategorySeo(Category $category): array
    {
        return [
            'title' => "Latest {$category->name} Jobs 2026 | JobOne.in",
            'description' => "Browse latest {$category->name} job notifications, admit cards, results, and exam updates. Apply for government jobs in {$category->name} sector.",
            'keywords' => "{$category->name} jobs, {$category->name} recruitment, government jobs, sarkari naukri 2026",
            'canonical' => url()->current(),
            'og_title' => "Latest {$category->name} Jobs 2026 | JobOne.in",
            'og_description' => "Browse latest {$category->name} job notifications and exam updates.",
            'og_image' => asset('images/og-image.jpg'),
            'og_url' => url()->current(),
        ];
    }

    public function generateStateSeo(State $state): array
    {
        return [
            'title' => "{$state->name} Government Jobs 2026 | JobOne.in",
            'description' => "Latest government job notifications in {$state->name}. Find SSC, UPSC, Railways, Banking, and State PSC jobs in {$state->name}.",
            'keywords' => "{$state->name} jobs, {$state->name} government jobs, {$state->name} sarkari naukri 2026",
            'canonical' => url()->current(),
            'og_title' => "{$state->name} Government Jobs 2026 | JobOne.in",
            'og_description' => "Latest government job notifications in {$state->name}.",
            'og_image' => asset('images/og-image.jpg'),
            'og_url' => url()->current(),
        ];
    }
}
