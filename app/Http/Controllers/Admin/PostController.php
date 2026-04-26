<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SubmitToIndexNow;
use App\Models\Category;
use App\Models\Post;
use App\Models\State;
use App\Services\CacheInvalidationService;
use App\Services\NotificationService;
use App\Services\OgImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category', 'state');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published' ? 1 : 0);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by state
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(50)->withQueryString();
        $categories = Category::all();
        $states = State::all();

        return view('admin.posts.index', compact('posts', 'categories', 'states'));
    }

    public function create()
    {
        $categories = Category::all();
        $states = State::all();

        return view('admin.posts.create', compact('categories', 'states'));
    }

    public function store(Request $request)
    {
        $rules = [
            'title'              => 'required|string|max:255',
            'type'               => 'required|in:job,admit_card,syllabus,result,answer_key,blog,scholarship',
            'category_id'        => 'required|exists:categories,id',
            'state_id'           => 'nullable|exists:states,id',
            'content'            => 'required|string',
            'organization'       => 'nullable|string|max:255',
            'total_posts'        => 'nullable|integer|min:1',
            'salary'             => 'nullable|string|max:255',
            'last_date'          => 'nullable|date',
            'notification_date'  => 'nullable|date',
            'start_date'         => 'nullable|date',
            'end_date'           => 'nullable|date|after_or_equal:start_date',
            'online_form'        => 'nullable|url|max:500',
            'final_result'       => 'nullable|url|max:500',
            'meta_title'         => 'nullable|string|max:60',
            'meta_description'   => 'nullable|string|max:160',
            'meta_keywords'      => 'nullable|string|max:1000',
            'tags'               => 'nullable|array',
            'tags.*'             => 'string',
            'education'          => 'nullable|array',
            'education.*'        => 'string',
            'is_featured'        => 'boolean',
            'is_upcoming'        => 'boolean',
            'is_published'       => 'boolean',
            // New SEO structured fields
            'age_min'            => 'nullable|integer|min:0',
            'age_max_gen'        => 'required|integer|min:0', // requested to be required
            'age_as_on_date'     => 'nullable|date',
            'age_relaxation_note'=> 'nullable|string|max:500',
            'salary_min'         => 'nullable|integer|min:0',
            'salary_max'         => 'nullable|integer|min:0',
            'salary_type'        => 'required|in:salary,stipend,consolidated,pay_scale', // requested to be required
            'pay_scale_level'    => 'nullable|string|max:255',
            'fee_general'        => 'required|integer|min:0', // requested to be required
            'fee_obc'            => 'nullable|integer|min:0',
            'fee_sc_st'          => 'nullable|integer|min:0',
            'fee_women'          => 'nullable|integer|min:0',
            'fee_ph'             => 'nullable|integer|min:0',
            'fee_payment_mode'   => 'nullable|string|max:255',
            'recruitment_year'   => 'nullable|integer|min:1900|max:2100',
        ];

        // Custom Education & Notification Date validation
        if ($request->input('is_published')) {
            $content = $request->input('content', '') . ' ' . $request->input('qualifications', '');
            $content = strip_tags(strtolower($content));
            
            $educationChips = array_map('strtolower', $request->input('education', []));
            $educationLevel = strtolower($request->input('education_level', ''));
            $chipsText = implode(' ', $educationChips) . ' ' . $educationLevel;

            $keywords = ['masters', 'm.sc', 'm.com', 'mba', 'pgdm', 'phd', 'llb', 'b.tech', 'diploma', 'iti', '12th', '10th'];
            $missingChips = [];
            foreach ($keywords as $kw) {
                if (strpos($content, $kw) !== false && strpos($chipsText, $kw) === false) {
                    // Try to approximate
                    $approx = $kw;
                    if (in_array($kw, ['masters', 'm.sc', 'm.com', 'mba', 'pgdm'])) $approx = 'post graduate';
                    if (in_array($kw, ['b.tech', 'llb'])) $approx = 'graduate';
                    
                    if (strpos($chipsText, $approx) === false) {
                        $missingChips[] = strtoupper($kw);
                    }
                }
            }

            if (count($missingChips) > 0) {
                return back()->withInput()->withErrors(['education' => 'Education mismatch. The body contains ' . implode(', ', $missingChips) . ' but the education chip is not set accordingly.']);
            }

            // Notification date validation
            $notificationDate = $request->input('notification_date');
            if ($notificationDate) {
                $daysDiff = \Carbon\Carbon::parse($notificationDate)->diffInDays(now(), false);
                if ($daysDiff > 90) {
                    return back()->withInput()->withErrors(['notification_date' => 'Notification date cannot be more than 90 days in the past from today.']);
                }
            }
        }

        // Duplicate detection check
        $orgSlug = \Illuminate\Support\Str::slug($request->input('organization'));
        $lastDateInput = $request->input('last_date');
        if ($orgSlug && $lastDateInput) {
            $duplicate = \App\Models\Post::where('organization_slug', $orgSlug)
                ->whereDate('last_date', $lastDateInput)
                ->first();
            
            if ($duplicate) {
                return redirect()->route('admin.posts.edit', $duplicate->id)
                    ->with('warning', 'A post for this organization and last date already exists. You have been redirected to edit it instead of creating a duplicate.');
            }
        }

        $validated = $request->validate($rules);

        // Salary type labeling validation
        if ($validated['salary_type'] === 'stipend' && (!isset($validated['salary_display_label']) || stripos($validated['salary_display_label'], 'salary') !== false)) {
            $validated['salary_display_label'] = 'Stipend during training';
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['admin_id'] = auth('admin')->id();
        $validated['short_description'] = '';
        $validated['important_links'] = null;
        $validated['tags'] = $request->has('tags') ? ($validated['tags'] ?? []) : [];
        $validated['education'] = $request->has('education') ? ($validated['education'] ?? []) : [];
        $validated['is_upcoming'] = $request->has('is_upcoming') ? 1 : 0;

        $post = Post::create($validated);
        
        // Generate OG image if not provided (only if GD extension is available)
        if (empty($post->image) && extension_loaded('gd')) {
            try {
                $ogImageService = app(OgImageService::class);
                $ogImageUrl = $ogImageService->generateImage($post->title, $post->slug);
                $post->update(['image' => $ogImageUrl]);
            } catch (\Exception $e) {
                // Log error but don't fail the post creation
                Log::warning('Failed to generate OG image: ' . $e->getMessage());
            }
        }
        
        // Invalidate cache
        try {
            app(CacheInvalidationService::class)->invalidatePostCache($post);
        } catch (\Exception $e) {
            // Log error but don't fail the post creation
            Log::warning('Failed to invalidate cache: ' . $e->getMessage());
        }
        
        // Submit to IndexNow if published
        if ($post->is_published) {
            try {
                $url = route('posts.show', ['type' => $post->type, 'post' => $post]);
                SubmitToIndexNow::dispatch($url)->delay(now()->addSeconds(30));
                
                // Send notifications (Telegram, WhatsApp, Web Push)
                app(NotificationService::class)->sendNewPostNotifications($post);
            } catch (\Exception $e) {
                // Log error but don't fail the post creation
                Log::warning('Failed to submit to IndexNow or send notifications: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $states = State::all();

        return view('admin.posts.edit', compact('post', 'categories', 'states'));
    }

    public function update(Request $request, Post $post)
    {
        $rules = [
            'title'              => 'required|string|max:255',
            'type'               => 'required|in:job,admit_card,syllabus,result,answer_key,blog,scholarship',
            'category_id'        => 'required|exists:categories,id',
            'state_id'           => 'nullable|exists:states,id',
            'content'            => 'required|string',
            'organization'       => 'nullable|string|max:255',
            'total_posts'        => 'nullable|integer|min:1',
            'salary'             => 'nullable|string|max:255',
            'last_date'          => 'nullable|date',
            'notification_date'  => 'nullable|date',
            'start_date'         => 'nullable|date',
            'end_date'           => 'nullable|date|after_or_equal:start_date',
            'online_form'        => 'nullable|url|max:500',
            'final_result'       => 'nullable|url|max:500',
            'meta_title'         => 'nullable|string|max:60',
            'meta_description'   => 'nullable|string|max:160',
            'meta_keywords'      => 'nullable|string|max:1000',
            'tags'               => 'nullable|array',
            'tags.*'             => 'string',
            'education'          => 'nullable|array',
            'education.*'        => 'string',
            'is_featured'        => 'boolean',
            'is_upcoming'        => 'boolean',
            'is_published'       => 'boolean',
            // New SEO structured fields
            'age_min'            => 'nullable|integer|min:0',
            'age_max_gen'        => 'required|integer|min:0',
            'age_as_on_date'     => 'nullable|date',
            'age_relaxation_note'=> 'nullable|string|max:500',
            'salary_min'         => 'nullable|integer|min:0',
            'salary_max'         => 'nullable|integer|min:0',
            'salary_type'        => 'required|in:salary,stipend,consolidated,pay_scale',
            'pay_scale_level'    => 'nullable|string|max:255',
            'fee_general'        => 'required|integer|min:0',
            'fee_obc'            => 'nullable|integer|min:0',
            'fee_sc_st'          => 'nullable|integer|min:0',
            'fee_women'          => 'nullable|integer|min:0',
            'fee_ph'             => 'nullable|integer|min:0',
            'fee_payment_mode'   => 'nullable|string|max:255',
            'recruitment_year'   => 'nullable|integer|min:1900|max:2100',
        ];

        // Custom Education & Notification Date validation
        if ($request->input('is_published')) {
            $content = $request->input('content', '') . ' ' . $request->input('qualifications', '');
            $content = strip_tags(strtolower($content));
            
            $educationChips = array_map('strtolower', $request->input('education', []));
            $educationLevel = strtolower($request->input('education_level', ''));
            $chipsText = implode(' ', $educationChips) . ' ' . $educationLevel;

            $keywords = ['masters', 'm.sc', 'm.com', 'mba', 'pgdm', 'phd', 'llb', 'b.tech', 'diploma', 'iti', '12th', '10th'];
            $missingChips = [];
            foreach ($keywords as $kw) {
                if (strpos($content, $kw) !== false && strpos($chipsText, $kw) === false) {
                    // Try to approximate
                    $approx = $kw;
                    if (in_array($kw, ['masters', 'm.sc', 'm.com', 'mba', 'pgdm'])) $approx = 'post graduate';
                    if (in_array($kw, ['b.tech', 'llb'])) $approx = 'graduate';
                    
                    if (strpos($chipsText, $approx) === false) {
                        $missingChips[] = strtoupper($kw);
                    }
                }
            }

            if (count($missingChips) > 0) {
                return back()->withInput()->withErrors(['education' => 'Education mismatch. The body contains ' . implode(', ', $missingChips) . ' but the education chip is not set accordingly.']);
            }

            // Notification date validation
            $notificationDate = $request->input('notification_date');
            if ($notificationDate) {
                // Determine if this is a newly created post or an old one.
                // We check if it's within 90 days of today. If it's already an old post, we might allow it.
                // The requirement: "cannot be more than 90 days in the past from today's date when a post is first created"
                // So for update, we skip this check or just allow the original date? Let's skip if the date hasn't changed.
                if ($post->notification_date != $notificationDate) {
                    $daysDiff = \Carbon\Carbon::parse($notificationDate)->diffInDays(now(), false);
                    if ($daysDiff > 90) {
                        return back()->withInput()->withErrors(['notification_date' => 'Notification date cannot be more than 90 days in the past from today.']);
                    }
                }
            }
        }

        $validated = $request->validate($rules);

        // Salary type labeling validation
        if ($validated['salary_type'] === 'stipend' && (!isset($validated['salary_display_label']) || stripos($validated['salary_display_label'], 'salary') !== false)) {
            $validated['salary_display_label'] = 'Stipend during training';
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['short_description'] = '';
        $validated['important_links'] = $post->important_links; // Keep existing value
        $validated['tags'] = $request->has('tags') ? ($validated['tags'] ?? []) : [];
        $validated['education'] = $request->has('education') ? ($validated['education'] ?? []) : [];
        $validated['is_upcoming'] = $request->has('is_upcoming') ? 1 : 0;

        $wasPublished = $post->is_published;
        
        $post->update($validated);
        
        // Regenerate OG image if title changed and no custom image (only if GD extension is available)
        if ($post->wasChanged('title') && empty($post->image) && extension_loaded('gd')) {
            try {
                $ogImageService = app(OgImageService::class);
                $ogImageService->deleteImage($post->slug);
                $ogImageUrl = $ogImageService->generateImage($post->title, $post->slug);
                $post->update(['image' => $ogImageUrl]);
            } catch (\Exception $e) {
                // Log error but don't fail the post update
                Log::warning('Failed to generate OG image: ' . $e->getMessage());
            }
        }
        
        // Invalidate cache
        try {
            app(CacheInvalidationService::class)->invalidatePostCache($post);
        } catch (\Exception $e) {
            // Log error but don't fail the post update
            Log::warning('Failed to invalidate cache: ' . $e->getMessage());
        }
        
        // Submit to IndexNow if published or status changed to published
        if ($post->is_published && (!$wasPublished || $post->wasChanged('title') || $post->wasChanged('content'))) {
            try {
                $url = route('posts.show', ['type' => $post->type, 'post' => $post]);
                SubmitToIndexNow::dispatch($url)->delay(now()->addSeconds(30));
                
                // Send notifications only if newly published
                if (!$wasPublished) {
                    app(NotificationService::class)->sendNewPostNotifications($post);
                }
            } catch (\Exception $e) {
                // Log error but don't fail the post update
                Log::warning('Failed to submit to IndexNow or send notifications: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        try {
            // Invalidate cache before deletion
            app(CacheInvalidationService::class)->invalidatePostCache($post);
        } catch (\Exception $e) {
            Log::warning('Failed to invalidate cache: ' . $e->getMessage());
        }
        
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully');
    }

    public function togglePublished(Post $post)
    {
        $wasPublished = $post->is_published;
        $post->update(['is_published' => !$post->is_published]);
        
        // Invalidate cache
        try {
            app(CacheInvalidationService::class)->invalidatePostCache($post);
        } catch (\Exception $e) {
            Log::warning('Failed to invalidate cache: ' . $e->getMessage());
        }
        
        // Submit to IndexNow if newly published
        if (!$wasPublished && $post->is_published) {
            try {
                $url = route('posts.show', ['type' => $post->type, 'post' => $post]);
                SubmitToIndexNow::dispatch($url)->delay(now()->addSeconds(30));
                
                // Send notifications
                app(NotificationService::class)->sendNewPostNotifications($post);
            } catch (\Exception $e) {
                // Log error but don't fail the toggle
                Log::warning('Failed to submit to IndexNow or send notifications: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true]);
    }

    public function toggleFeatured(Post $post)
    {
        $post->update(['is_featured' => !$post->is_featured]);
        
        // Invalidate cache
        try {
            app(CacheInvalidationService::class)->invalidatePostCache($post);
        } catch (\Exception $e) {
            Log::warning('Failed to invalidate cache: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:publish,unpublish,delete',
            'posts' => 'required|array|min:1',
            'posts.*' => 'exists:posts,id',
        ]);

        $posts = Post::whereIn('id', $validated['posts'])->get();

        foreach ($posts as $post) {
            if ($validated['action'] === 'publish') {
                $post->update(['is_published' => true]);
            } elseif ($validated['action'] === 'unpublish') {
                $post->update(['is_published' => false]);
            } elseif ($validated['action'] === 'delete') {
                $post->delete();
            }
            
            // Invalidate cache for each post
            try {
                app(CacheInvalidationService::class)->invalidatePostCache($post);
            } catch (\Exception $e) {
                Log::warning('Failed to invalidate cache: ' . $e->getMessage());
            }
        }

        $message = match($validated['action']) {
            'publish' => 'Posts published successfully',
            'unpublish' => 'Posts unpublished successfully',
            'delete' => 'Posts deleted successfully',
        };

        return redirect()->route('admin.posts.index')
            ->with('success', $message);
    }

    public function loadMore(Request $request)
    {
        $page = $request->input('page', 2);
        $query = Post::with('category', 'state');

        // Apply same filters as index
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published' ? 1 : 0);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(50, ['*'], 'page', $page);

        return view('admin.posts.load-more', compact('posts'));
    }
}