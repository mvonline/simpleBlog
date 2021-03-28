<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Cors;
use App\Http\Middleware\is_admin;
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

//prefix('v1')
Route::group(['middleware' => [cors::class]], function () {

    Route::post('/login', [ApiAuthController::class,'login'])->name('login.api');
    Route::middleware('auth:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [ApiAuthController::class,'logout'])->name('logout.api');

        //Blogs Routes
        Route::get('/blogs', [BlogController::class, 'getAllBlogs']);
        Route::get('/blogs/{blog}', [BlogController::class, 'getBlog']);
        Route::post('/blogs', [BlogController::class, 'create'])->name('blogs.store');
        Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blogs/{blog}', [BlogController::class, 'delete'])->name('blogs.destroy');


    });
    Route::group(['middleware' => ['auth:api',is_admin::class]], function () {
        Route::get('/users', [UserController::class, 'getAllUsers']);
        Route::get('/users/{user}', [UserController::class, 'getUser']);
        Route::post('/users', [UserController::class, 'create'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'delete'])->name('users.destroy');
    });

});
