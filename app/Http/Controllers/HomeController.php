<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\State;
use App\Services\SeoService;
use App\Services\SchemaService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache home page sections for 10 minutes
        $sections = Cache::remember('home_sections', 600, function () {
            return [
                'jobs' => Post::published()->ofType('job')
                    ->with('category', 'state')->latest()->limit(50)->get(),
                'admit_cards' => Post::published()->ofType('admit_card')
                    ->with('category', 'state')->latest()->limit(50)->get(),
                'results' => Post::published()->ofType('result')
                    ->with('category', 'state')->latest()->limit(50)->get(),
                'answer_keys' => Post::published()->ofType('answer_key')
                    ->with('category', 'state')->latest()->limit(50)->get(),
                'syllabus' => Post::published()->ofType('syllabus')
                    ->with('category', 'state')->latest()->limit(50)->get(),
                'blogs' => Post::published()->ofType('blog')
                    ->with('category', 'state')->latest()->limit(50)->get(),
            ];
        });

        $categories = Cache::remember('categories_list', 600, 
            fn() => Category::all()
        );
        $states = Cache::remember('states_list', 600, 
            fn() => State::all()
        );

        // SEO
        $seoService = app(SeoService::class);
        $schemaService = app(SchemaService::class);
        
        $seo = $seoService->generateHomeSeo();
        $schema = [
            $schemaService->generateWebSiteSchema(),
            $schemaService->generateOrganizationSchema(),
        ];

        return view('home', compact('sections', 'categories', 'states', 'seo', 'schema'));
    }
}
