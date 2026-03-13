<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\SeoService;
use App\Services\SchemaService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index($type)
    {
        $posts = Post::published()->ofType($type)
            ->with('category', 'state')
            ->latest()
            ->paginate(50); // 50 posts per page

        // SEO
        $seoService = app(SeoService::class);
        $seo = $seoService->generateListingSeo($type);

        return view('posts.index', compact('posts', 'type', 'seo'));
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

        return view('posts.show', compact('post', 'related', 'seo', 'schema'));
    }

    public function loadMore(Request $request, $type)
    {
        $page = $request->input('page', 2);
        
        $posts = Post::published()->ofType($type)
            ->with('category', 'state')
            ->latest()
            ->simplePaginate(50, ['*'], 'page', $page);

        return view('posts.load-more', compact('posts'));
    }
}
