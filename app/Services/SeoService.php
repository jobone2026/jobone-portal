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
        $year = date('Y');
        $ny   = date('Y') + 1;
        return match($page) {
            'home'        => "Latest Government Jobs {$year} - Sarkari Naukri, SSC, UPSC, Railways, Banking | JobOne.in",
            'post'        => $this->generatePostTitle($data),
            'category'    => "Latest {$data->name} Jobs {$year} - Recruitment Notification | JobOne.in",
            'state'       => "{$data->name} Government Jobs {$year} - Sarkari Naukri | JobOne.in",
            'jobs'        => "Latest Government Jobs {$year}-{$ny} - Sarkari Naukri India | JobOne.in",
            'admit-cards' => "Admit Cards {$year} - Download Hall Ticket & Call Letter | JobOne.in",
            'results'     => "Sarkari Result {$year} - Latest Exam Results & Merit List | JobOne.in",
            'answer-keys' => "Answer Key {$year} - Download Solved Paper & Cut Off | JobOne.in",
            'syllabus'    => "Exam Syllabus {$year} - Download PDF & Exam Pattern | JobOne.in",
            'scholarship' => "Scholarships {$year} - Government Scholarship Schemes India | JobOne.in",
            'blogs'       => 'Sarkari Job Tips, Exam Preparation & Career Guidance | JobOne.in',
            'search'      => "Search: \"{$data}\" - Govt Jobs, Results, Admit Cards | JobOne.in",
            default       => 'JobOne.in - Sarkari Naukri Portal India'
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
        // Priority: meta_description > short_description > content excerpt
        if (!empty($post->meta_description)) {
            $description = $post->meta_description;
        } elseif (!empty($post->short_description)) {
            $description = $post->short_description;
        } else {
            // Extract text from content, remove HTML tags
            $description = strip_tags($post->content);
            // Remove extra whitespace
            $description = preg_replace('/\s+/', ' ', $description);
        }
        
        // Ensure description is not empty
        if (empty(trim($description))) {
            $description = "Latest {$post->category->name} notification for {$post->title}. Check details, eligibility, application process, and important dates.";
        }
        
        return Str::limit(trim($description), 155, '...');
    }

    public function generateKeywords($page, $data = null): string
    {
        $year = date('Y');
        $ny   = date('Y') + 1;
        $base = "government jobs, sarkari naukri, sarkari result, govt jobs {$year}, sarkari naukri {$year}, naukri {$year}, india jobs";

        return match($page) {
            'home'        => "{$base}, SSC, UPSC, Railways jobs, Banking jobs, State PSC, Defence jobs, Police recruitment, Teaching jobs, {$year} government jobs, free job alert, rojgar result",
            'post'        => $this->generatePostKeywords($data),
            'category'    => "{$data->name} jobs, {$data->name} recruitment {$year}, {$data->name} vacancy {$year}, {$base}",
            'state'       => "{$data->name} government jobs, {$data->name} sarkari naukri {$year}, {$data->name} jobs {$year}, {$data->name} recruitment, {$base}",
            'jobs'        => "government jobs {$year}, latest govt jobs, sarkari naukri {$year}-{$ny}, free job alert, freejobalert, {$base}",
            'admit-cards' => "admit card {$year}, hall ticket {$year}, call letter, exam admit card, download admit card, {$base}",
            'results'     => "sarkari result {$year}, exam result {$year}, merit list {$year}, cut off marks, result declared, {$base}",
            'answer-keys' => "answer key {$year}, solved paper, official answer key, cut off {$year}, {$base}",
            'syllabus'    => "exam syllabus {$year}, syllabus PDF, exam pattern {$year}, selection process, {$base}",
            'scholarship' => "scholarship {$year}, government scholarship, scholarship scheme india, scholarship for students {$year}, {$base}",
            'blogs'       => "exam tips, preparation strategy, government exam guide, sarkari exam, career guidance, {$base}",
            default       => $base
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
        // Use post image if available, otherwise default OG image
        $ogImage = asset('images/og-image.jpg');
        if ($page === 'post' && $data && !empty($data->image)) {
            $ogImage = $data->image;
        }
        
        return [
            'og:title' => $this->generateTitle($page, $data),
            'og:description' => $this->generateDescription($page, $data),
            'og:url' => $this->generateCanonical(url()->current()),
            'og:type' => $page === 'post' ? 'article' : 'website',
            'og:site_name' => 'JobOne.in',
            'og:locale' => 'en_IN',
            'og:image' => $ogImage,
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
        
        $year = date('Y');
        $ny   = date('Y') + 1;
        return [
            'title'          => "Latest Government Jobs {$year} - Sarkari Naukri, SSC, UPSC, Railways | JobOne.in",
            'description'    => "Find latest government jobs {$year}, sarkari naukri, SSC, UPSC, Railways, Banking, State PSC, Defence, Police recruitment notifications. Get admit cards, results, answer keys, syllabus free. JobOne.in - India's trusted govt job portal.",
            'keywords'       => $this->generateKeywords('home'),
            'canonical'      => url('/'),
            'og_title'       => "JobOne.in - Latest Government Jobs {$year} | Sarkari Naukri",
            'og_description' => "India's #1 government job portal. Latest {$year} sarkari naukri, SSC, UPSC, Railways, Banking jobs, admit cards & results.",
            'og_image'       => asset('images/og-image.jpg'),
            'og_url'         => url('/'),
        ];
    }

    public function generateListingSeo($type): array
    {
        $year = date('Y');
        $ny   = date('Y') + 1;
        $typeNames = [
            'job'         => 'Government Jobs',
            'admit_card'  => 'Admit Cards',
            'result'      => 'Sarkari Results',
            'answer_key'  => 'Answer Keys',
            'syllabus'    => 'Exam Syllabus',
            'blog'        => 'Career Blogs',
            'scholarship' => 'Scholarships',
        ];
        $typeDesc = [
            'job'         => "Browse latest government job notifications {$year}-{$ny}. SSC, UPSC, Railways, Banking, State PSC, Defence, Police recruitment. Free job alert India.",
            'admit_card'  => "Download admit cards & hall tickets {$year} for SSC, UPSC, Railways, Banking, State PSC, Defence exams. Get your call letter now.",
            'result'      => "Check latest sarkari result {$year}. SSC, UPSC, Railways, Banking exam results, merit list, cut off marks declared.",
            'answer_key'  => "Download official answer keys {$year} for SSC, UPSC, Railways, Banking exams. Check correct answers & expected cut off.",
            'syllabus'    => "Download exam syllabus PDF {$year} for SSC, UPSC, Railways, Banking, State PSC. Get full exam pattern & selection process.",
            'blog'        => 'Read career guidance, exam preparation tips, study material and government job updates for India.',
            'scholarship' => "Latest government scholarship schemes {$year} for students in India. Apply for central & state scholarship programmes.",
        ];

        $typeName = $typeNames[$type] ?? 'Posts';
        $desc     = $typeDesc[$type]  ?? "Latest {$typeName} {$year} on JobOne.in";

        return [
            'title'          => "Latest {$typeName} {$year} | JobOne.in",
            'description'    => $desc,
            'keywords'       => $this->generateKeywords($type === 'job' ? 'jobs' : str_replace('_', '-', $type)),
            'canonical'      => url()->current(),
            'og_title'       => "Latest {$typeName} {$year} | JobOne.in",
            'og_description' => $desc,
            'og_image'       => asset('images/og-image.jpg'),
            'og_url'         => url()->current(),
        ];
    }

    public function generatePostSeo(Post $post): array
    {
        // Ensure we have a valid OG image URL (absolute URL)
        $ogImage = asset('images/og-image.jpg');
        if (!empty($post->image)) {
            // If post image is relative, make it absolute
            $ogImage = str_starts_with($post->image, 'http') 
                ? $post->image 
                : asset($post->image);
        }
        
        return [
            'title' => $this->generatePostTitle($post),
            'description' => $this->generatePostDescription($post),
            'keywords' => $this->generatePostKeywords($post),
            'canonical' => url()->current(),
            'og_title' => $this->generatePostTitle($post),
            'og_description' => $this->generatePostDescription($post),
            'og_image' => $ogImage,
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
