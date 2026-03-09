<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\State;
use App\Services\SeoService;

class StateController extends Controller
{
    public function show(State $state)
    {
        $posts = $state->posts()
            ->published()
            ->with('category')
            ->latest()
            ->get();

        $states = State::all();
        $categories = Category::all();

        // SEO
        $seoService = app(SeoService::class);
        $seo = $seoService->generateStateSeo($state);

        return view('states.show', compact('posts', 'state', 'states', 'categories', 'seo'));
    }
}
