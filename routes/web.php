<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleCallback']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function(){
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('/search', [SearchController::class, 'search'])->name('search');

        Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
        
        Route::get('/posts', [PostController::class, 'index'])->name('posts');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.create');
        Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
        Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
        Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comments.create');

        Route::post('/comments/{comment}/like', [CommentController::class, 'toggleLike'])->name('comments.like');

        Route::get('/profile/{user}', [UserController::class, 'index'])->name('users.show');
        Route::post('/profile/photo', [UserController::class, 'storeProfilePic'])->name('profile.upload');
        Route::post('/users/follow', [UserController::class, 'follow'])->name('users.follow');
        Route::post('/users/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');
    });
});

require __DIR__.'/auth.php';
