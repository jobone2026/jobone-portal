<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminApiController;

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
