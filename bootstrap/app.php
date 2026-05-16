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
        
        // Apply TejasFoodie middleware first (before any other processing)
        $middleware->web(prepend: [
            \App\Http\Middleware\TejasFoodieMiddleware::class,
            \App\Http\Middleware\DomainStateFilter::class,
            \App\Http\Middleware\RedirectMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Redirect deleted/missing posts to homepage instead of 410
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 410) {
                // Redirect to homepage with message instead of showing 410 page
                return redirect('/')->with('info', 'This content is no longer available. Please check our latest updates.');
            }
        });
        
        // Handle ModelNotFoundException for missing posts - redirect instead of 404
        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            // Only handle post routes (job, result, admit_card, etc.)
            if ($request->is('job/*') || $request->is('result/*') || $request->is('admit_card/*') || 
                $request->is('answer_key/*') || $request->is('syllabus/*') || $request->is('blog/*')) {
                return redirect('/')->with('info', 'This post is no longer available. Please check our latest jobs.');
            }
        });
    })->create();
