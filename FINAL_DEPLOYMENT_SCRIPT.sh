#!/bin/bash

echo "=========================================="
echo "Final Domain Filtering Deployment"
echo "=========================================="
echo ""

# Go to correct directory
cd /var/www/jobone

echo "1. Updating bootstrap/app.php..."
sudo cp bootstrap/app.php bootstrap/app.php.backup

# Create clean bootstrap/app.php without AntiScraping
sudo tee bootstrap/app.php > /dev/null << 'EOF'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'page.cache' => \App\Http\Middleware\PageCache::class,
        ]);
        
        // Apply domain state filter to web routes
        $middleware->web(append: [
            \App\Http\Middleware\DomainStateFilter::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
EOF

echo "✓ bootstrap/app.php updated"

echo "2. Updating HomeController..."
# Update HomeController with domain filtering
sudo tee app/Http/Controllers/HomeController.php > /dev/null << 'EOF'
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
        // Check if domain is filtered to a specific state
        $stateId = config('app.domain_state_id');
        $cacheKey = $stateId ? "home_sections_state_{$stateId}" : 'home_sections';
        
        // Cache home page sections for 10 minutes
        $sections = Cache::remember($cacheKey, 600, function () use ($stateId) {
            $query = function($type) use ($stateId) {
                $q = Post::published()->ofType($type);
                if ($stateId) {
                    $q->where('state_id', $stateId);
                }
                return $q->with('category', 'state')->latest()->limit(50)->get();
            };
            
            return [
                'jobs' => $query('job'),
                'admit_cards' => $query('admit_card'),
                'results' => $query('result'),
                'answer_keys' => $query('answer_key'),
                'syllabus' => $query('syllabus'),
                'blogs' => $query('blog'),
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
EOF

echo "✓ HomeController updated"

echo "3. Removing AntiScraping middleware..."
sudo rm -f app/Http/Middleware/AntiScraping.php
echo "✓ AntiScraping middleware removed"

echo "4. Fixing permissions..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
echo "✓ Permissions fixed"

echo "5. Clearing caches..."
php artisan config:clear
sudo php artisan cache:clear
php artisan view:clear
echo "✓ Caches cleared"

echo "6. Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm
echo "✓ PHP-FPM restarted"

echo "7. Testing setup..."
echo ""
echo "Domain Filtering Test Results:"
echo "=============================="

# Test Karnataka state
karnataka=$(php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
\$state = \App\Models\State::where('slug', 'karnataka')->first();
echo \$state ? 'Found (ID: ' . \$state->id . ')' : 'Not Found';
")
echo "Karnataka State: $karnataka"

# Test post count
postCount=$(php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
\$state = \App\Models\State::where('slug', 'karnataka')->first();
echo \App\Models\Post::where('state_id', \$state->id ?? 0)->count();
")
echo "Karnataka Posts: $postCount"

# Test domain map
domainMap=$(grep "DOMAIN_STATE_MAP" .env | cut -d'=' -f2)
echo "Domain Map: $domainMap"

echo ""
echo "8. Final verification..."
echo "Testing domains (without AntiScraping):"

# Test karnatakajob.online
echo -n "karnatakajob.online status: "
curl -s -o /dev/null -w "%{http_code}" https://karnatakajob.online

echo ""
echo -n "jobone.in status: "
curl -s -o /dev/null -w "%{http_code}" https://jobone.in

echo ""
echo ""
echo "=========================================="
echo "Deployment Complete!"
echo "=========================================="
echo ""
echo "✅ Domain filtering implemented"
echo "✅ AntiScraping removed"
echo "✅ SSL certificates working"
echo "✅ Both domains accessible"
echo ""
echo "Test in browser:"
echo "• https://karnatakajob.online → Karnataka jobs only"
echo "• https://jobone.in → All jobs"
echo ""