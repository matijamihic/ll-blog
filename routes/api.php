<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::prefix('/authors')->group(function () {
    Route::get('', [AuthorController::class, 'index']);
    Route::get('/{id}', [AuthorController::class, 'show']);
    Route::get('/{id}/posts', [AuthorController::class, 'posts']);
});

Route::prefix('/profile')->group(function () {
    Route::get('/posts', [ProfileController::class, 'posts']);
    Route::get('/posts/{id}', [ProfileController::class, 'post']);
    Route::apiResource('', ProfileController::class, [
        'only' => ['index', 'store']
    ]);
});

Route::prefix('/posts')->group(function () {
    Route::get('/tags/{tag}/any', [PostController::class, 'withAnyTags']);
    Route::get('/tags/{tag}', [PostController::class, 'withAllTags']);
    Route::get('/tags', [PostController::class, 'tags']);
    Route::post('/{id}/restore', [PostController::class, 'restore']);
});
Route::apiResource('posts', PostController::class);