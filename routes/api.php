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
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:jwt')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::get('/authors/{id}/posts', [AuthorController::class, 'posts']);
Route::resource('authors', AuthorController::class, [
    'only' => ['index', 'show']
]);

Route::get('/posts/tags/{tag}/any', [PostController::class, 'withAnyTags']);
Route::get('/posts/tags/{tag}', [PostController::class, 'withAllTags']);
Route::get('/posts/tags', [PostController::class, 'tags']);
Route::resource('posts', PostController::class, [
    'except' => ['edit', 'create']
]);
