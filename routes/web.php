<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\UserPreferences;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserFollowsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Posts;

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
    $user = Auth::user();

    $users = [];
    if ($user) {
        $users = User::where('id', '<>', $user->id)
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    } else {
        $users = User::all();
    }

    $posts = [];
    $additional_posts = [];

    if(Auth::user()) {
        $posts = Posts::where('created_by', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        $additional_posts = Posts::where('created_by', '<>', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(5);
    } else {
        $posts = Posts::latest()->get();
    }

    return view('welcome', ['users' => $users, 'posts' => $posts, 'additional_posts' => $additional_posts]);
})->name('welcome');


// Google auth
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callbackGoogle']);

// // Settings
// Route::get('/settings', [UserPreferences::class, 'onUserSettings'])->name('settings');
// Route::get('/settings/{id}', [UserPreferences::class, 'onEditProfile'])->name('settings.edit');

// Follow
// Route::get('/follow/{id}', [UserFollowsController::class, 'onFollow'])->name('user.follow');
// Route::get('/followings', [UserFollowsController::class, 'onUserFollowing'])->name('user.followings');
// Route::get('/followers', [UserFollowsController::class, 'onUserFollowers'])->name('user.followers');

Route::middleware(['auth'])->group(function () {
    // Settings
    Route::get('/settings', [UserPreferences::class, 'onUserSettings'])->name('settings');
    Route::get('/settings/{id}', [UserPreferences::class, 'onEditProfile'])->name('settings.edit');

    // Follow
    Route::get('/follow/{id}', [UserFollowsController::class, 'onFollow'])->name('user.follow');
    Route::get('/followings', [UserFollowsController::class, 'onUserFollowing'])->name('user.followings');
    Route::get('/followers', [UserFollowsController::class, 'onUserFollowers'])->name('user.followers');
    
    // Liked
    Route::get('/liked', [UserController::class, 'onUserLikedPosts'])->name('users.liked');

    // Add Post
    Route::get('/add/post', [UserController::class, 'onAddPost'])->name('user.add.post');
    Route::post('/add/post', [UserController::class, 'onAddedPost'])->name('user.added.post');

    // Comment + Like
    Route::get('/comments/{id}', [UserController::class, 'onComments'])->name('post.comments');
    Route::get('/add/like/{id}', [UserController::class, 'onAddLike'])->name('user.add.like');
    Route::post('/add/comment/{id}', [UserController::class, 'onAddComment'])->name('user.add.comment');

});

// // Liked
// Route::get('/liked', [UserController::class, 'onUserLikedPosts'])->name('users.liked');

// // Add Post
// Route::get('/add/post', [UserController::class, 'onAddPost'])->name('user.add.post');
// Route::post('/add/post', [UserController::class, 'onAddedPost'])->name('user.added.post');

// // Comment + Like
// Route::get('/comments/{id}', [UserController::class, 'onComments'])->name('post.comments');
// Route::get('/add/like/{id}', [UserController::class, 'onAddLike'])->name('user.add.like');
// Route::post('/add/comment/{id}', [UserController::class, 'onAddComment'])->name('user.add.comment');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
