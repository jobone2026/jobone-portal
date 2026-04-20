<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Category;
use App\Models\State;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    /**
     * Verify API token
     */
    private function verifyToken($token)
    {
        return $token === config('api.token');
    }

    /**
     * List all posts with pagination
     * GET /api/posts
     */
    public function list(Request $request)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $page        = $request->get('page', 1);
        $limit       = $request->get('limit', 15);
        $type        = $request->get('type');
        $category_id = $request->get('category_id');
        $state_id    = $request->get('state_id');
        $is_upcoming = $request->get('is_upcoming');   // filter upcoming jobs
        $education   = $request->get('education');     // filter by education tag

        $query = Post::with(['category', 'state'])->published()->latest();

        if ($type)        $query->where('type', $type);
        if ($category_id) $query->where('category_id', $category_id);
        if ($state_id)    $query->where('state_id', $state_id);
        if ($is_upcoming !== null) $query->where('is_upcoming', (bool) $is_upcoming);
        if ($education)   $query->whereJsonContains('education', $education);

        $posts = $query->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => PostResource::collection($posts->items()),
            'meta' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
            ]
        ]);
    }

    /**
     * Search posts
     * GET /api/posts/search
     */
    public function search(Request $request)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = $request->get('q');
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 15);

        $posts = Post::with(['category', 'state'])
            ->where('title', 'like', "%{$query}%")
            ->orWhere('short_description', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => PostResource::collection($posts->items()),
            'meta' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
            ]
        ]);
    }

    /**
     * Get featured posts
     * GET /api/posts/featured
     */
    public function featured(Request $request)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $limit = $request->get('limit', 10);
        $posts = Post::with(['category', 'state'])
            ->featured()
            ->recent(30)
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => PostResource::collection($posts)
        ]);
    }

    /**
     * Get single post by ID
     * GET /api/posts/{id}
     */
    public function get(Request $request, $id)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $post = Post::with(['category', 'state'])->find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new PostResource($post)
        ]);
    }

    /**
     * Create a new job post
     * POST /api/posts
     */
    public function create(Request $request)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'type'              => 'required|in:job,admit_card,result,answer_key,syllabus,blog,scholarship',
            'short_description' => 'required|string',
            'content'           => 'required|string',
            'category_id'       => 'required|exists:categories,id',
            'state_id'          => 'nullable|exists:states,id',
            'organization'      => 'nullable|string|max:255',
            // Dates
            'notification_date' => 'nullable|date',
            'start_date'        => 'nullable|date',
            'end_date'          => 'nullable|date',
            'last_date'         => 'nullable|date',
            // Vacancy & Salary
            'total_posts'       => 'nullable|integer|min:1',
            'salary'            => 'nullable|string|max:255',
            // Links
            'online_form'       => 'nullable|url|max:500',
            'final_result'      => 'nullable|url|max:500',
            'important_links'   => 'nullable|array',
            // Classification
            'tags'              => 'nullable|array',
            'tags.*'            => 'string',
            'education'         => 'nullable|array',
            'education.*'       => 'string',
            // Flags
            'is_featured'       => 'nullable|boolean',
            'is_upcoming'       => 'nullable|boolean',
            'is_published'      => 'nullable|boolean',
            // SEO
            'meta_title'        => 'nullable|string|max:60',
            'meta_description'  => 'nullable|string|max:160',
            'meta_keywords'     => 'nullable|string|max:1000',
        ]);

        try {
            $post = Post::create([
                'title'             => $validated['title'],
                'slug'              => \Str::slug($validated['title']),
                'type'              => $validated['type'],
                'short_description' => $validated['short_description'],
                'content'           => $validated['content'],
                'category_id'       => $validated['category_id'],
                'state_id'          => $validated['state_id'] ?? null,
                'organization'      => $validated['organization'] ?? null,
                // Dates
                'notification_date' => $validated['notification_date'] ?? null,
                'start_date'        => $validated['start_date'] ?? null,
                'end_date'          => $validated['end_date'] ?? null,
                'last_date'         => $validated['last_date'] ?? null,
                // Vacancy & Salary
                'total_posts'       => $validated['total_posts'] ?? null,
                'salary'            => $validated['salary'] ?? null,
                // Links
                'online_form'       => $validated['online_form'] ?? null,
                'final_result'      => $validated['final_result'] ?? null,
                'important_links'   => $validated['important_links'] ?? [],
                // Classification
                'tags'              => $validated['tags'] ?? [],
                'education'         => $validated['education'] ?? [],
                // Flags
                'is_featured'       => $validated['is_featured'] ?? false,
                'is_upcoming'       => $validated['is_upcoming'] ?? false,
                'is_published'      => $validated['is_published'] ?? false,
                // SEO
                'meta_title'        => $validated['meta_title'] ?? $validated['title'],
                'meta_description'  => $validated['meta_description'] ?? substr($validated['short_description'], 0, 160),
                'meta_keywords'     => $validated['meta_keywords'] ?? implode(',', explode(' ', $validated['title'])),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => new PostResource($post)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create post',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a post
     * PUT /api/posts/{id}
     */
    public function update(Request $request, $id)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $post = Post::with(['category', 'state'])->find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $validated = $request->validate([
            'title'             => 'nullable|string|max:255',
            'type'              => 'nullable|in:job,admit_card,result,answer_key,syllabus,blog,scholarship',
            'short_description' => 'nullable|string',
            'content'           => 'nullable|string',
            'category_id'       => 'nullable|exists:categories,id',
            'state_id'          => 'nullable|exists:states,id',
            'organization'      => 'nullable|string|max:255',
            // Dates
            'notification_date' => 'nullable|date',
            'start_date'        => 'nullable|date',
            'end_date'          => 'nullable|date',
            'last_date'         => 'nullable|date',
            // Vacancy & Salary
            'total_posts'       => 'nullable|integer|min:1',
            'salary'            => 'nullable|string|max:255',
            // Links
            'online_form'       => 'nullable|url|max:500',
            'final_result'      => 'nullable|url|max:500',
            'important_links'   => 'nullable|array',
            // Classification
            'tags'              => 'nullable|array',
            'tags.*'            => 'string',
            'education'         => 'nullable|array',
            'education.*'       => 'string',
            // Flags
            'is_featured'       => 'nullable|boolean',
            'is_upcoming'       => 'nullable|boolean',
            'is_published'      => 'nullable|boolean',
            // SEO
            'meta_title'        => 'nullable|string|max:60',
            'meta_description'  => 'nullable|string|max:160',
            'meta_keywords'     => 'nullable|string|max:1000',
        ]);

        try {
            $post->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => new PostResource($post)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update post',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a post
     * DELETE /api/posts/{id}
     */
    public function delete(Request $request, $id)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $post = Post::with(['category', 'state'])->find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        try {
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete post',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all categories (public endpoint)
     * GET /api/categories
     */
    public function categories()
    {
        $categories = Category::withCount('posts')->orderBy('name', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'total' => $categories->count(),
            'data' => $categories
        ]);
    }

    /**
     * Get all states (public endpoint)
     * GET /api/states
     */
    public function states()
    {
        $states = State::withCount('posts')->orderBy('name', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'total' => $states->count(),
            'data' => $states
        ]);
    }

    /**
     * Generate new API token
     * POST /api/token/generate
     */
    public function generateToken(Request $request)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $newToken = 'jobone_sk_live_' . bin2hex(random_bytes(16));

        try {
            // Update .env file
            $envPath = base_path('.env');
            $envContent = file_get_contents($envPath);
            $envContent = preg_replace(
                '/API_TOKEN=.*/',
                'API_TOKEN=' . $newToken,
                $envContent
            );
            file_put_contents($envPath, $envContent);

            return response()->json([
                'success' => true,
                'message' => 'New API token generated',
                'token' => $newToken,
                'note' => 'Please restart PHP-FPM for changes to take effect'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate token',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current API token info
     * GET /api/token
     */
    public function getToken(Request $request)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => true,
            'token'   => $token,
            'status'  => 'active'
        ]);
    }

    /**
     * Get scholarships only
     * GET /api/posts/scholarships
     */
    public function scholarships(Request $request)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $page  = $request->get('page', 1);
        $limit = $request->get('limit', 15);
        $state_id    = $request->get('state_id');
        $category_id = $request->get('category_id');

        $query = Post::with(['category', 'state'])
            ->published()
            ->ofType('scholarship')
            ->latest();

        if ($state_id)    $query->where('state_id', $state_id);
        if ($category_id) $query->where('category_id', $category_id);

        $posts = $query->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data'    => PostResource::collection($posts->items()),
            'meta'    => [
                'total'        => $posts->total(),
                'per_page'     => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page'    => $posts->lastPage(),
            ]
        ]);
    }

    /**
     * Get home page sections (all types latest posts)
     * GET /api/home
     */
    public function home(Request $request)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $limit    = $request->get('limit', 10);
        $state_id = $request->get('state_id');

        $types = [
            'jobs'         => 'job',
            'admit_cards'  => 'admit_card',
            'results'      => 'result',
            'answer_keys'  => 'answer_key',
            'syllabus'     => 'syllabus',
            'blogs'        => 'blog',
            'scholarships' => 'scholarship',
        ];

        $sections = [];
        foreach ($types as $key => $type) {
            $q = Post::with(['category', 'state'])
                ->published()
                ->ofType($type)
                ->latest();
            if ($state_id) $q->where('state_id', $state_id);
            $sections[$key] = PostResource::collection($q->limit($limit)->get());
        }

        return response()->json([
            'success'  => true,
            'sections' => $sections,
        ]);
    }

    /**
     * Post counts by type (dashboard stats)
     * GET /api/stats
     */
    public function stats(Request $request)
    {
        $token = $request->bearerToken();
        if (!$this->verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $types = ['job', 'admit_card', 'result', 'answer_key', 'syllabus', 'blog', 'scholarship'];
        $stats = [];
        foreach ($types as $type) {
            $stats[$type] = Post::published()->ofType($type)->count();
        }
        $stats['total'] = Post::published()->count();

        return response()->json([
            'success' => true,
            'data'    => $stats,
        ]);
    }
}
