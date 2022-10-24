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

Route::get('/trends', [App\Http\Controllers\ContentRatingController::class, 'trends'])
    ->name('trends');

Route::get('/read-post/{post_id}/change-comment-status/{comment_id}/{is_deleted}', [App\Http\Controllers\ReadPostController::class, 'changeCommentStatus'])
    ->name('change-comment-status');

Route::post('/read-post/comment', [App\Http\Controllers\ReadPostController::class, 'createComment'])
    ->name('create-comment');

Route::get('/profile/subscribe/{author_id}', [App\Http\Controllers\UserProfileController::class, 'subscribe'])
    ->name('subscribe');

Route::get('/profile/unsubscribe/{author_id}', [App\Http\Controllers\UserProfileController::class, 'unSubscribe'])
    ->name('unsubscribe');

Route::get('/like-posе/{post_id}', [App\Http\Controllers\ContentRatingController::class, 'like'])
    ->name('like-post');

Route::get('/change-like-status/{post_id}', [App\Http\Controllers\ContentRatingController::class, 'changeLikeStatus'])
    ->name('change-like-status');

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

Route::get('/change-post-status/{post_id}/{is_deleted}', [App\Http\Controllers\PostRedactorController::class, 'changePostStatus'])
    ->name('change-post-status');

Route::post('/search/result', [App\Http\Controllers\MainController::class, 'search'])
    ->name('main-search');


require __DIR__ . '/auth.php';
