<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SubmitToIndexNow;
use App\Models\Category;
use App\Models\Post;
use App\Models\State;
use App\Services\CacheInvalidationService;
use App\Services\ContentSanitizerService;
use App\Services\NotificationService;
use App\Services\OgImageService;
use Illuminate\Http\JsonResponse;
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:job,admit_card,syllabus,result,answer_key,blog',
            'category_id' => 'required|exists:categories,id',
            'state_id' => 'nullable|exists:states,id',
            'content' => 'required|string',
            'organization' => 'nullable|string|max:255',
            'total_posts' => 'nullable|integer|min:1',
            'last_date' => 'nullable|date',
            'notification_date' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:1000',
            'tags' => 'nullable|array',
            'tags.*' => 'string|in:cutoff,merit_list,selection_list,final_result,provisional_result,revised_result,scorecard,marks',
            'education' => 'nullable|array',
            'education.*' => 'string|in:10th_pass,12th_pass,graduate,post_graduate,diploma,iti,btech,mtech,bsc,msc,bcom,mcom,ba,ma,bba,mba,ca,cs,cma,llb,llm,mbbs,bds,bpharm,mpharm,nursing,bed,med,phd,any_qualification',
            'is_featured' => 'boolean',
            'is_published' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['admin_id'] = auth('admin')->id();
        $validated['short_description'] = '';
        $validated['important_links'] = null;
        $validated['tags'] = $request->has('tags') ? ($validated['tags'] ?? []) : [];
        $validated['education'] = $request->has('education') ? ($validated['education'] ?? []) : [];

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:job,admit_card,syllabus,result,answer_key,blog',
            'category_id' => 'required|exists:categories,id',
            'state_id' => 'nullable|exists:states,id',
            'content' => 'required|string',
            'organization' => 'nullable|string|max:255',
            'total_posts' => 'nullable|integer|min:1',
            'last_date' => 'nullable|date',
            'notification_date' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:1000',
            'tags' => 'nullable|array',
            'tags.*' => 'string|in:cutoff,merit_list,selection_list,final_result,provisional_result,revised_result,scorecard,marks',
            'education' => 'nullable|array',
            'education.*' => 'string|in:10th_pass,12th_pass,graduate,post_graduate,diploma,iti,btech,mtech,bsc,msc,bcom,mcom,ba,ma,bba,mba,ca,cs,cma,llb,llm,mbbs,bds,bpharm,mpharm,nursing,bed,med,phd,any_qualification',
            'is_featured' => 'boolean',
            'is_published' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['short_description'] = '';
        $validated['important_links'] = $post->important_links; // Keep existing value
        $validated['tags'] = $request->has('tags') ? ($validated['tags'] ?? []) : [];
        $validated['education'] = $request->has('education') ? ($validated['education'] ?? []) : [];

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

    public function previewSanitized(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        $rawContent = $validated['content'] ?? '';
        $sanitizedContent = app(ContentSanitizerService::class)->sanitize($validated['content'] ?? '');
        $diffSummary = $this->buildDiffSummary($rawContent, $sanitizedContent);

        return response()->json([
            'title' => $validated['title'] ?? 'Preview Title',
            'content' => $sanitizedContent,
            'diff' => $diffSummary,
        ]);
    }

    private function buildDiffSummary(string $raw, string $sanitized): array
    {
        $rawLines = preg_split('/\R/', $raw) ?: [];
        $sanitizedLines = preg_split('/\R/', $sanitized) ?: [];

        $normalizedRaw = array_values(array_filter(array_map('trim', $rawLines), fn ($line) => $line !== ''));
        $normalizedSanitized = array_values(array_filter(array_map('trim', $sanitizedLines), fn ($line) => $line !== ''));
        $sanitizedFrequency = [];
        foreach ($normalizedSanitized as $line) {
            $sanitizedFrequency[$line] = ($sanitizedFrequency[$line] ?? 0) + 1;
        }
        $removed = [];

        foreach ($normalizedRaw as $line) {
            if (($sanitizedFrequency[$line] ?? 0) > 0) {
                $sanitizedFrequency[$line]--;
            } else {
                $removed[] = $line;
            }
        }

        return [
            'raw_length' => strlen($raw),
            'sanitized_length' => strlen($sanitized),
            'removed_line_count' => count($removed),
            'removed_lines' => array_slice($removed, 0, 25),
        ];
    }
}