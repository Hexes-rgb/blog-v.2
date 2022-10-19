<?php

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

// RESTFul

Route::get('/', [App\Http\Controllers\MainController::class, 'index'])
    ->name('main-index');

Route::get('/profile/subscribe/{author_id}', [App\Http\Controllers\UserProfileController::class, 'subscribe'])
    ->name('subscribe');

Route::get('/like-posе/{post_id}', [App\Http\Controllers\ContentRatingController::class, 'like'])
    ->name('like-post');

Route::get('/remove-like/{post_id}', [App\Http\Controllers\ContentRatingController::class, 'removeLike'])
    ->name('remove-like');

Route::get('/search/tag/{tag_id}', [App\Http\Controllers\MainController::class, 'filterByTag'])
    ->name('main-filter-by-tag');

Route::get('/read-post/{post_id}', [App\Http\Controllers\ReadPostController::class, 'readPost'])
    ->name('read-post');

Route::get('/create-post', [App\Http\Controllers\PostRedactorController::class, 'showCreatePostForm'])
    ->name('show-create-post');

Route::get('/my-profile', [App\Http\Controllers\UserProfileController::class, 'showUserProfile'])
    ->name('user-profile');

Route::get('/profile/{user_id}', [App\Http\Controllers\UserProfileController::class, 'showAnotherUserProfile'])
    ->name('another-user-profile');

Route::post('/create-post', [App\Http\Controllers\PostRedactorController::class, 'createPost'])
    ->name('create-post');

Route::get('/edit-post/{post_id}', [App\Http\Controllers\PostRedactorController::class, 'showUpdatePostForm'])
    ->name('edit-post');

Route::get('/edit-post/remove-tag/{post_id}/{tag_id}', [App\Http\Controllers\PostRedactorController::class, 'removeTag'])
    ->name('remove-tag');

Route::get('/api', [App\Http\Controllers\PostRedactorController::class, 'sendTagsJson'])
    ->name('send-tags-json');

Route::post('/edit-post/update', [App\Http\Controllers\PostRedactorController::class, 'updatePost'])
    ->name('update-post');

Route::post('/edit-post/add-tag', [App\Http\Controllers\PostRedactorController::class, 'addTag'])
    ->name('add-tag');

Route::get('/delete-post/{post_id}', [App\Http\Controllers\PostRedactorController::class, 'deletePost'])
    ->name('delete-post');

Route::post('/search/result', [App\Http\Controllers\MainController::class, 'search'])
    ->name('main-search');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
