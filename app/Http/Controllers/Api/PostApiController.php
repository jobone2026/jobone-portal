<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\State;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    /**
     * Create a new job post via API
     * 
     * POST /api/posts/create
     * 
     * Required headers:
     * - Authorization: Bearer YOUR_API_TOKEN
     * - Content-Type: application/json
     */
    public function create(Request request)
    {
        // Validate API token
        $token = $request->bearerToken();
        if ($token !== env('API_TOKEN')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:job,admit_card,result,answer_key,syllabus,blog',
            'short_description' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'state_id' => 'nullable|exists:states,id',
            'last_date' => 'nullable|date',
            'notification_date' => 'nullable|date',
            'total_posts' => 'nullable|integer',
            'important_links' => 'nullable|array',
            'is_featured' => 'nullable|boolean',
        ]);

        try {
            // Create post
            $post = Post::create([
                'title' => $validated['title'],
                'slug' => \Str::slug($validated['title']),
                'type' => $validated['type'],
                'short_description' => $validated['short_description'],
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'state_id' => $validated['state_id'] ?? null,
                'last_date' => $validated['last_date'] ?? null,
                'notification_date' => $validated['notification_date'] ?? null,
                'total_posts' => $validated['total_posts'] ?? null,
                'important_links' => $validated['important_links'] ?? [],
                'is_featured' => $validated['is_featured'] ?? false,
                'meta_title' => $validated['title'],
                'meta_description' => substr($validated['short_description'], 0, 160),
                'meta_keywords' => implode(',', explode(' ', $validated['title'])),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'post' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'url' => route('posts.show', [$post->type, $post->slug]),
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create post',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all categories
     * GET /api/categories
     */
    public function categories()
    {
        $categories = Category::all(['id', 'name']);
        return response()->json($categories);
    }

    /**
     * Get all states
     * GET /api/states
     */
    public function states()
    {
        $states = State::all(['id', 'name']);
        return response()->json($states);
    }
}
