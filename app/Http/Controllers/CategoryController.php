<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\State;
use App\Services\SeoService;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $posts = $category->posts()
            ->published()
            ->with('state')
            ->latest()
            ->get();

        $states = State::all();
        $categories = Category::all();

        // SEO
        $seoService = app(SeoService::class);
        $seo = $seoService->generateCategorySeo($category);

        return view('categories.show', compact('posts', 'category', 'states', 'categories', 'seo'));
    }
}
