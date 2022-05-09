<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('v1')->group(function () {
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::middleware('auth:api')->group(function () {

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/category', 'index')->name('category.index');
            Route::post('/category', 'store')->name('category.store');
            Route::get('/category/{id}', 'show')->name('category.show');
            Route::put('/category/{id}', 'update')->name('category.update');
            Route::delete('/category/{id}', 'delete')->name('category.delete');
        });

        Route::controller(PostController::class)->group(function () {
            Route::get('/posts', 'index')->name('post.index');
            Route::post('/posts', 'store')->name('post.store');
            Route::get('/posts/{id}', 'show')->name('post.show');
            Route::put('/posts/{id}', 'update')->name('post.update');
            Route::delete('/posts/{id}', 'delete')->name('post.delete');
        });
    });
});
