<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('page.cache:600');

// Post type listings
Route::get('/jobs', [PostController::class, 'index'])->defaults('type', 'job')->name('posts.jobs');
Route::get('/jobs/load-more', [PostController::class, 'loadMore'])->defaults('type', 'job')->name('posts.jobs.load-more');
Route::get('/admit-cards', [PostController::class, 'index'])->defaults('type', 'admit_card')->name('posts.admit-cards');
Route::get('/admit-cards/load-more', [PostController::class, 'loadMore'])->defaults('type', 'admit_card')->name('posts.admit-cards.load-more');
Route::get('/results', [PostController::class, 'index'])->defaults('type', 'result')->name('posts.results');
Route::get('/results/load-more', [PostController::class, 'loadMore'])->defaults('type', 'result')->name('posts.results.load-more');
Route::get('/answer-keys', [PostController::class, 'index'])->defaults('type', 'answer_key')->name('posts.answer-keys');
Route::get('/answer-keys/load-more', [PostController::class, 'loadMore'])->defaults('type', 'answer_key')->name('posts.answer-keys.load-more');
Route::get('/syllabus', [PostController::class, 'index'])->defaults('type', 'syllabus')->name('posts.syllabus');
Route::get('/syllabus/load-more', [PostController::class, 'loadMore'])->defaults('type', 'syllabus')->name('posts.syllabus.load-more');
Route::get('/blogs', [PostController::class, 'index'])->defaults('type', 'blog')->name('posts.blogs');
Route::get('/blogs/load-more', [PostController::class, 'loadMore'])->defaults('type', 'blog')->name('posts.blogs.load-more');

// Static pages
Route::get('/about', [StaticPageController::class, 'about'])->name('pages.about')->middleware('page.cache:3600');
Route::get('/contact', [StaticPageController::class, 'contact'])->name('pages.contact')->middleware('page.cache:3600');
Route::get('/privacy-policy', [StaticPageController::class, 'privacy'])->name('pages.privacy')->middleware('page.cache:3600');
Route::get('/disclaimer', [StaticPageController::class, 'disclaimer'])->name('pages.disclaimer')->middleware('page.cache:3600');

// Admin routes (must come before catch-all routes)
require __DIR__.'/admin.php';

// Category and state filtering
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show')->middleware('page.cache:1800');
Route::get('/state/{state:slug}', [StateController::class, 'show'])->name('states.show')->middleware('page.cache:1800');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap-posts.xml', [SitemapController::class, 'posts'])->name('sitemap.posts');
Route::get('/sitemap-categories.xml', [SitemapController::class, 'categories'])->name('sitemap.categories');
Route::get('/sitemap-states.xml', [SitemapController::class, 'states'])->name('sitemap.states');
Route::get('/sitemap-static.xml', [SitemapController::class, 'static'])->name('sitemap.static');
Route::get('/sitemap-news.xml', [SitemapController::class, 'news'])->name('sitemap.news');

// Single post view (catch-all route - must be last)
Route::get('/{type}/{post:slug}', [PostController::class, 'show'])->name('posts.show')->middleware('page.cache:3600');

