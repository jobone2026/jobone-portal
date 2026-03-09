<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\State;
use App\Models\Admin;
use App\Services\CacheInvalidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class AdminApiController extends Controller
{
    protected $cacheInvalidation;

    public function __construct(CacheInvalidationService $cacheInvalidation)
    {
        $this->cacheInvalidation = $cacheInvalidation;
    }
    /**
     * Login and get API token
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Generate API token
        $token = $admin->createToken('admin-api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'admin' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                ],
                'token' => $token
            ]
        ]);
    }

    /**
     * Get all posts
     */
    public function getPosts(Request $request)
    {
        $posts = Post::with(['category', 'state', 'admin'])
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->state_id, fn($q) => $q->where('state_id', $request->state_id))
            ->when($request->is_published !== null, fn($q) => $q->where('is_published', $request->is_published))
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    /**
     * Get single post
     */
    public function getPost($id)
    {
        $post = Post::with(['category', 'state', 'admin'])->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    /**
     * Create new post
     */
    public function createPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|in:job,admit_card,result,answer_key,syllabus,blog',
            'category_id' => 'required|exists:categories,id',
            'state_id' => 'nullable|exists:states,id',
            'short_description' => 'required|string',
            'content' => 'required|string',
            'notification_date' => 'nullable|date',
            'last_date' => 'nullable|date',
            'total_posts' => 'nullable|integer',
            'important_links' => 'nullable|json',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title) . '-' . Str::random(13);
        $post->type = $request->type;
        $post->category_id = $request->category_id;
        $post->state_id = $request->state_id;
        $post->short_description = $request->short_description;
        $post->content = $request->content;
        $post->notification_date = $request->notification_date;
        $post->last_date = $request->last_date;
        $post->total_posts = $request->total_posts;
        $post->important_links = $request->important_links;
        $post->is_featured = $request->is_featured ?? false;
        $post->is_published = $request->is_published ?? true;
        $post->admin_id = $request->user()->id;
        
        // Auto-generate SEO fields
        $post->meta_title = Str::limit($request->title, 60);
        $post->meta_description = Str::limit($request->short_description, 160);

        $post->save();

        // Invalidate cache
        $this->cacheInvalidation->invalidatePostCache($post);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'data' => $post->load(['category', 'state', 'admin'])
        ], 201);
    }

    /**
     * Update post
     */
    public function updatePost(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'type' => 'in:job,admit_card,result,answer_key,syllabus,blog',
            'category_id' => 'exists:categories,id',
            'state_id' => 'nullable|exists:states,id',
            'short_description' => 'string',
            'content' => 'string',
            'notification_date' => 'nullable|date',
            'last_date' => 'nullable|date',
            'total_posts' => 'nullable|integer',
            'important_links' => 'nullable|json',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->has('title')) {
            $post->title = $request->title;
            $post->meta_title = Str::limit($request->title, 60);
        }
        if ($request->has('type')) $post->type = $request->type;
        if ($request->has('category_id')) $post->category_id = $request->category_id;
        if ($request->has('state_id')) $post->state_id = $request->state_id;
        if ($request->has('short_description')) {
            $post->short_description = $request->short_description;
            $post->meta_description = Str::limit($request->short_description, 160);
        }
        if ($request->has('content')) $post->content = $request->content;
        if ($request->has('notification_date')) $post->notification_date = $request->notification_date;
        if ($request->has('last_date')) $post->last_date = $request->last_date;
        if ($request->has('total_posts')) $post->total_posts = $request->total_posts;
        if ($request->has('important_links')) $post->important_links = $request->important_links;
        if ($request->has('is_featured')) $post->is_featured = $request->is_featured;
        if ($request->has('is_published')) $post->is_published = $request->is_published;

        $post->save();

        // Invalidate cache
        $this->cacheInvalidation->invalidatePostCache($post);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => $post->load(['category', 'state', 'admin'])
        ]);
    }

    /**
     * Delete post
     */
    public function deletePost($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        // Invalidate cache before deleting
        $this->cacheInvalidation->invalidatePostCache($post);

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }

    /**
     * Get all categories
     */
    public function getCategories()
    {
        $categories = Category::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get all states
     */
    public function getStates()
    {
        $states = State::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $states
        ]);
    }

    /**
     * Logout (revoke token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
