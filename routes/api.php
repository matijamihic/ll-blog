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

Route::apiResource('profile', ProfileController::class);

Route::get('/authors/{id}/posts', [AuthorController::class, 'posts']);
Route::apiResource('authors', AuthorController::class, [
    'only' => ['index', 'show', 'update']
]);

Route::get('/posts/tags/{tag}/any', [PostController::class, 'withAnyTags']);
Route::get('/posts/tags/{tag}', [PostController::class, 'withAllTags']);
Route::get('/posts/tags', [PostController::class, 'tags']);
Route::apiResource('posts', PostController::class);
