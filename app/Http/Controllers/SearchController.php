<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');

        $posts = Post::published()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('short_description', 'like', "%{$query}%")
            ->with('category', 'state')
            ->latest()
            ->paginate(50);

        // Add noindex for empty results or deep pagination
        $noindex = $posts->isEmpty() || $posts->currentPage() > 3;

        return view('posts.search', compact('posts', 'query', 'noindex'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $posts = Post::published()
            ->where('title', 'like', "%{$query}%")
            ->select('id', 'title', 'slug', 'type')
            ->limit(8)
            ->get();

        return response()->json($posts);
    }

}
