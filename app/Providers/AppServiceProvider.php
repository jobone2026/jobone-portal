<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\State;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share categories and states globally to all views
        View::composer('*', function ($view) {
            $categories = Cache::remember('categories_list', 600, 
                fn() => Category::all()
            );
            $states = Cache::remember('states_list', 600, 
                fn() => State::all()
            );
            
            $view->with('categories', $categories)
                 ->with('states', $states);
        });
    }
}

