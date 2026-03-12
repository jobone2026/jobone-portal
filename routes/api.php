<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\PostApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/admin/login', [AdminApiController::class, 'login']);

// API endpoints (with Bearer token authentication)
Route::get('/posts', [PostApiController::class, 'list']);
Route::get('/posts/{id}', [PostApiController::class, 'get']);
Route::post('/posts', [PostApiController::class, 'create']);
Route::put('/posts/{id}', [PostApiController::class, 'update']);
Route::delete('/posts/{id}', [PostApiController::class, 'delete']);

// Legacy endpoint (still supported)
Route::post('/posts/create', [PostApiController::class, 'create']);

// Categories & States
Route::get('/categories', [PostApiController::class, 'categories']);
Route::get('/states', [PostApiController::class, 'states']);

// Token management
Route::get('/token', [PostApiController::class, 'getToken']);
Route::post('/token/generate', [PostApiController::class, 'generateToken']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Admin routes
    Route::post('/admin/logout', [AdminApiController::class, 'logout']);
    
    // Posts
    Route::get('/posts', [AdminApiController::class, 'getPosts']);
    Route::get('/posts/{id}', [AdminApiController::class, 'getPost']);
    Route::post('/posts', [AdminApiController::class, 'createPost']);
    Route::put('/posts/{id}', [AdminApiController::class, 'updatePost']);
    Route::delete('/posts/{id}', [AdminApiController::class, 'deletePost']);
    
    // Categories & States
    Route::get('/categories', [AdminApiController::class, 'getCategories']);
    Route::get('/states', [AdminApiController::class, 'getStates']);
});
