<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\ContentSanitizerService;
use App\Services\SeoService;
use App\Services\SchemaService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index($type = null)
    {
        // Check if domain is filtered to a specific state
        $stateId = config('app.domain_state_id');
        
        // If type is 'all', get separate collections for each post type for 6-column layout
        if ($type === 'all') {
            $queryBuilder = function($postType) use ($stateId) {
                $q = Post::published()->ofType($postType);
                if ($stateId) {
                    $q->where('state_id', $stateId);
                }
                return $q->with('category', 'state')->latest()->limit(10)->get();
            };
            
            $jobs = $queryBuilder('job');
            $results = $queryBuilder('result');
            $admitCards = $queryBuilder('admit_card');
            $answerKeys = $queryBuilder('answer_key');
            $syllabus = $queryBuilder('syllabus');
            $blogs = $queryBuilder('blog');
            
            // Create a merged collection for pagination info
            $allPosts = collect()
                ->merge($jobs)
                ->merge($results)
                ->merge($admitCards)
                ->merge($answerKeys)
                ->merge($syllabus)
                ->merge($blogs)
                ->sortByDesc('created_at');
            
            // Create fake pagination object for consistency
            $posts = new \Illuminate\Pagination\LengthAwarePaginator(
                $allPosts,
                $allPosts->count(),
                50,
                1,
                ['path' => request()->url()]
            );
            
            // Pass individual collections to view
            $sections = [
                'jobs' => $jobs,
                'results' => $results,
                'admit_cards' => $admitCards,
                'answer_keys' => $answerKeys,
                'syllabus' => $syllabus,
                'blogs' => $blogs
            ];
        } else {
            // For specific types, use normal pagination
            $query = Post::published()->with('category', 'state');
            
            if ($type) {
                $query->ofType($type);
            }
            
            if ($stateId) {
                $query->where('state_id', $stateId);
            }
            
            $posts = $query->latest()->paginate(50);
            $sections = null;
        }

        // SEO
        $seoService = app(SeoService::class);
        $seo = $seoService->generateListingSeo($type ?? 'all');

        return view('posts.index', compact('posts', 'type', 'seo', 'sections'));
    }

    public function show($type, Post $post)
    {
        if (!$post->is_published && !auth('admin')->check()) {
            abort(404);
        }

        // Increment view count
        $post->increment('view_count');

        $related = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->with('category', 'state')
            ->limit(4)
            ->get();

        // SEO
        $seoService = app(SeoService::class);
        $schemaService = app(SchemaService::class);
        
        $seo = $seoService->generatePostSeo($post);
        $schema = [];
        
        if ($post->type === 'job') {
            $schema[] = $schemaService->generateJobPostingSchema($post);
        } else {
            $schema[] = $schemaService->generateArticleSchema($post);
        }
        
        $schema[] = $schemaService->generateBreadcrumbSchema($post);
        $faqSchema = $schemaService->generateFAQSchema($post->content);
        if ($faqSchema) {
            $schema[] = $faqSchema;
        }

        $renderedContent = app(ContentSanitizerService::class)->sanitize($post->content);
        $seoSupportContent = $this->buildSeoSupportContent($post);

        return view('posts.show', compact('post', 'related', 'seo', 'schema', 'renderedContent', 'seoSupportContent'));
    }

    public function loadMore(Request $request, $type)
    {
        $page = $request->input('page', 2);
        $stateId = config('app.domain_state_id');
        
        $query = Post::published()->ofType($type)->with('category', 'state');
        
        if ($stateId) {
            $query->where('state_id', $stateId);
        }
        
        $posts = $query->latest()->simplePaginate(50, ['*'], 'page', $page);

        return view('posts.load-more', compact('posts'));
    }

    private function buildSeoSupportContent(Post $post): array
    {
        $language = $this->resolveSeoLanguage();
        $typeLabel = $this->localizedTypeLabel($post->type, $language);
        $regionText = $this->localizedRegionText($post, $language);
        $year = $post->notification_date?->format('Y') ?? $post->created_at->format('Y');

        if ($language === 'kn') {
            return match ($post->type) {
                'job' => [
                    'title' => "{$typeLabel} {$year} - ಅರ್ಹತೆ, ದಿನಾಂಕಗಳು ಮತ್ತು ಅರ್ಜಿ ಮಾರ್ಗದರ್ಶಿ",
                    'paragraphs' => [
                        "{$post->title} ಗೆ ಸಂಬಂಧಿಸಿದ ಅರ್ಹತೆ, ಅರ್ಜಿ ದಿನಾಂಕಗಳು, ಶುಲ್ಕ ವಿವರಗಳು ಮತ್ತು ನೇರ ಲಿಂಕ್‌ಗಳನ್ನು ಈ ಪುಟದಲ್ಲಿ ನೋಡಿ.",
                        "ಈ ನೇಮಕಾತಿ ಅಪ್‌ಡೇಟ್ {$regionText}. ಅರ್ಜಿ ಸಲ್ಲಿಸುವ ಮೊದಲು ಅಗತ್ಯ ದಾಖಲೆಗಳು ಮತ್ತು ವಯೋಮಿತಿ ನಿಯಮಗಳನ್ನು ದೃಢಪಡಿಸಿ.",
                    ],
                ],
                'admit_card' => [
                    'title' => "{$typeLabel} {$year} - ಡೌನ್‌ಲೋಡ್ ವಿಧಾನ ಮತ್ತು ಪರೀಕ್ಷಾ ದಿನದ ಚೆಕ್‌ಲಿಸ್ಟ್",
                    'paragraphs' => [
                        "{$post->title} ಅಡ್ಮಿಟ್ ಕಾರ್ಡ್ ಅನ್ನು ಸರಿಯಾದ ಲಾಗಿನ್ ವಿವರಗಳೊಂದಿಗೆ ವೇಗವಾಗಿ ಡೌನ್‌ಲೋಡ್ ಮಾಡಲು ಈ ವಿಭಾಗ ಸಹಾಯ ಮಾಡುತ್ತದೆ.",
                        "ಪರೀಕ್ಷೆಗೆ ಮೊದಲು ವರದಿ ಸಮಯ, ಪರೀಕ್ಷಾ ಕೇಂದ್ರ ಮತ್ತು ಕಡ್ಡಾಯ ದಾಖಲೆಗಳನ್ನು ಖಚಿತಪಡಿಸಿಕೊಳ್ಳಿ.",
                    ],
                ],
                'result' => [
                    'title' => "{$typeLabel} {$year} - ಮೆರಿಟ್ ಲಿಸ್ಟ್ ಮತ್ತು ಮುಂದಿನ ಹಂತಗಳು",
                    'paragraphs' => [
                        "{$post->title} ಫಲಿತಾಂಶ, ಅಂಕಗಳ ಉಲ್ಲೇಖ ಮತ್ತು ಕಟ್‌ಆಫ್ ಅಪ್‌ಡೇಟ್‌ಗಳನ್ನು ಇಲ್ಲಿ ಪರಿಶೀಲಿಸಿ.",
                        "ಶಾರ್ಟ್‌ಲಿಸ್ಟ್ ಆದರೆ ದಾಖಲೆ ಪರಿಶೀಲನೆ ಅಥವಾ ಮುಂದಿನ ಪ್ರಕ್ರಿಯೆಗೆ ಬೇಕಾದ ಸೂಚನೆಗಳನ್ನು ಅನುಸರಿಸಿ.",
                    ],
                ],
                default => [
                    'title' => "{$typeLabel} {$year} - ಮುಖ್ಯ ಸಾರಾಂಶ ಮತ್ತು ಅಧಿಕೃತ ಮಾಹಿತಿ",
                    'paragraphs' => [
                        "{$post->title} ಗೆ ಸಂಬಂಧಿಸಿದ ಪ್ರಮುಖ ಅಪ್‌ಡೇಟ್‌ಗಳು ಮತ್ತು ಲಿಂಕ್‌ಗಳನ್ನು ಈ ಪುಟ ಸಂಕ್ಷಿಪ್ತವಾಗಿ ನೀಡುತ್ತದೆ.",
                        "ಯಾವುದೇ ಕ್ರಮ ಕೈಗೊಳ್ಳುವ ಮೊದಲು ಅಧಿಕೃತ ಪ್ರಕಟಣೆಯಲ್ಲಿರುವ ಅಂತಿಮ ಸೂಚನೆಗಳನ್ನು ಪರಿಶೀಲಿಸಿ.",
                    ],
                ],
            };
        }

        if ($language === 'hi') {
            return match ($post->type) {
                'job' => [
                    'title' => "{$typeLabel} {$year} - पात्रता, तिथियां और आवेदन गाइड",
                    'paragraphs' => [
                        "{$post->title} की पात्रता, आवेदन तिथि, शुल्क विवरण और सीधे लिंक इस पेज पर देखें।",
                        "यह भर्ती अपडेट {$regionText} उपयोगी है। आवेदन से पहले दस्तावेज और आयु सीमा की पुष्टि करें।",
                    ],
                ],
                'admit_card' => [
                    'title' => "{$typeLabel} {$year} - डाउनलोड प्रक्रिया और परीक्षा दिवस चेकलिस्ट",
                    'paragraphs' => [
                        "{$post->title} एडमिट कार्ड सही लॉगिन विवरण के साथ जल्दी डाउनलोड करने में यह सेक्शन मदद करता है।",
                        "परीक्षा से पहले रिपोर्टिंग टाइम, सेंटर एड्रेस और जरूरी दस्तावेज जरूर जांचें।",
                    ],
                ],
                'result' => [
                    'title' => "{$typeLabel} {$year} - मेरिट लिस्ट और अगला चरण गाइड",
                    'paragraphs' => [
                        "{$post->title} रिजल्ट स्टेटस, स्कोर रेफरेंस और कटऑफ अपडेट यहां देखें।",
                        "शॉर्टलिस्ट होने पर डॉक्यूमेंट वेरिफिकेशन या अगले चरण की प्रक्रिया फॉलो करें।",
                    ],
                ],
                default => [
                    'title' => "{$typeLabel} {$year} - त्वरित सारांश और आधिकारिक जानकारी",
                    'paragraphs' => [
                        "{$post->title} से जुड़ी मुख्य अपडेट और महत्वपूर्ण लिंक इस पेज पर संक्षेप में मिलते हैं।",
                        "किसी भी कार्रवाई से पहले आधिकारिक नोटिफिकेशन की अंतिम निर्देश अवश्य सत्यापित करें।",
                    ],
                ],
            };
        }

        return match ($post->type) {
            'job' => [
                'title' => "{$typeLabel} {$year} - Eligibility, Dates and Apply Steps",
                'paragraphs' => [
                    "Use this page to check {$post->title} eligibility, application dates, fee details, and direct apply links.",
                    "This recruitment update is useful {$regionText}. Verify documents, age criteria, and category-wise instructions before form submission.",
                ],
            ],
            'admit_card' => [
                'title' => "{$typeLabel} {$year} - Download Process and Exam Day Checklist",
                'paragraphs' => [
                    "This section helps you download {$post->title} admit card quickly with the correct login details.",
                    "Before exam day, confirm reporting time, center address, and mandatory documents to avoid last-minute issues.",
                ],
            ],
            'result' => [
                'title' => "{$typeLabel} {$year} - Merit List and Next Stage Guide",
                'paragraphs' => [
                    "Check {$post->title} result status, score reference, and cutoff-related updates from this page.",
                    "If shortlisted, review the next process such as document verification, interview rounds, or joining formalities.",
                ],
            ],
            'answer_key' => [
                'title' => "{$typeLabel} {$year} - Objection Window and Score Estimate",
                'paragraphs' => [
                    "Find {$post->title} answer key links and response-check steps in one place.",
                    "Use the objection timeline and official instructions to challenge incorrect answers within deadline.",
                ],
            ],
            'syllabus' => [
                'title' => "{$typeLabel} {$year} - Topic Breakdown and Preparation Plan",
                'paragraphs' => [
                    "Get {$post->title} syllabus overview, exam pattern, and topic priority list for effective preparation.",
                    "Build a study plan based on high-weightage sections and practice schedule for better score improvement.",
                ],
            ],
            default => [
                'title' => "{$typeLabel} {$year} - Quick Summary and Official Reference",
                'paragraphs' => [
                    "This page summarizes {$post->title} with key updates, important links, and verified notification details.",
                    "Always cross-check final instructions on the official source before taking action.",
                ],
            ],
        };
    }

    private function resolveSeoLanguage(): string
    {
        if (config('app.domain_state_slug') === 'karnataka') {
            return 'kn';
        }

        $preferred = request()->getPreferredLanguage(['en', 'hi', 'kn']);
        return in_array($preferred, ['hi', 'kn'], true) ? $preferred : 'en';
    }

    private function localizedTypeLabel(string $type, string $language): string
    {
        $map = [
            'en' => [
                'job' => 'Job',
                'admit_card' => 'Admit Card',
                'result' => 'Result',
                'answer_key' => 'Answer Key',
                'syllabus' => 'Syllabus',
                'blog' => 'Blog',
            ],
            'hi' => [
                'job' => 'जॉब',
                'admit_card' => 'एडमिट कार्ड',
                'result' => 'रिजल्ट',
                'answer_key' => 'आंसर की',
                'syllabus' => 'सिलेबस',
                'blog' => 'ब्लॉग',
            ],
            'kn' => [
                'job' => 'ಉದ್ಯೋಗ',
                'admit_card' => 'ಅಡ್ಮಿಟ್ ಕಾರ್ಡ್',
                'result' => 'ಫಲಿತಾಂಶ',
                'answer_key' => 'ಉತ್ತರ ಕೀ',
                'syllabus' => 'ಸಿಲಬಸ್',
                'blog' => 'ಬ್ಲಾಗ್',
            ],
        ];

        return $map[$language][$type] ?? ucfirst(str_replace('_', ' ', $type));
    }

    private function localizedRegionText(Post $post, string $language): string
    {
        if ($language === 'kn') {
            return $post->state?->name ? "{$post->state->name} ಅಭ್ಯರ್ಥಿಗಳಿಗೆ" : 'ಆಲ್ ಇಂಡಿಯಾ ಅಭ್ಯರ್ಥಿಗಳಿಗೆ';
        }

        if ($language === 'hi') {
            return $post->state?->name ? "{$post->state->name} के उम्मीदवारों के लिए" : 'ऑल इंडिया उम्मीदवारों के लिए';
        }

        return $post->state?->name ? 'for ' . $post->state->name . ' candidates' : 'for all India candidates';
    }
}
