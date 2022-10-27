<?php

use App\Http\Controllers\ContentRatingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostRedactorController;
use App\Http\Controllers\ReadPostController;
use App\Http\Controllers\UserProfileController;

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

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('main-index');
    Route::get('/search/tag/{tag_id}', 'filterByTag')->name('main-filter-by-tag');
    Route::post('/search/result', 'search')->name('main-search');
});

Route::controller(ReadPostController::class)->group(function () {
    Route::get('/read-post/{post_id}', 'readPost')->name('read-post');
    Route::get('/create-like/{post_id}', 'createLike')->name('create-like');
    Route::get('/delete-like/{post_id}', 'deleteLike')->name('delete-like');
    Route::get('/restore-like/{post_id}', 'restoreLike')->name('restore-like');
    Route::get('/read-post/{post_id}/delete-comment/{comment_id}', 'deleteComment')->name('delete-comment');
    Route::get('/read-post/{post_id}/restore-comment/{comment_id}', 'restoreComment')->name('restore-comment');
    Route::post('/read-post/comment', 'createComment')->name('create-comment');
});

Route::controller(UserProfileController::class)->group(function () {
    Route::get('/my-profile', 'showUserProfile')->name('user-profile');
    Route::get('/profile/{user_id}', 'showAnotherUserProfile')->name('another-user-profile');
    Route::get('/profile/{author_id}/subscribtion/create', 'createSubscription')->name('create-subscription');
    Route::get('/profile/{author_id}/subscribtion/delete', 'deleteSubscription')->name('delete-subscription');
    Route::get('/profile/{author_id}/subscribtion/restore', 'restoreSubscription')->name('restore-subscription');
});

Route::controller(ContentRatingController::class)->group(function () {
    Route::get('/trends', 'trends')->name('trends');
    Route::post('/trends/search/result', 'search')->name('trends-search');
});

Route::controller(PostRedactorController::class)->group(function () {
    Route::get('/create-post', 'showCreatePostForm')->name('show-create-post');
    Route::get('/edit-post/{post_id}', 'showUpdatePostForm')->name('edit-post');
    Route::get('/edit-post/remove-tag/{post_id}/{tag_id}', 'removeTag')->name('remove-tag');
    Route::get('/api', 'sendTagsJson')->name('send-tags-json');
    Route::get('/delete-post/{post_id}', 'deletePost')->name('delete-post');
    Route::get('/restore-post/{post_id}', 'restorePost')->name('restore-post');
    Route::post('/create-post', 'createPost')->name('create-post');
    Route::post('/edit-post/update', 'updatePost')->name('update-post');
    Route::post('/edit-post/add-tag', 'addTag')->name('add-tag');
});

require __DIR__ . '/auth.php';

// Route::get('/', [App\Http\Controllers\MainController::class, 'index'])
//     ->name('main-index');

// Route::get('/trends', [App\Http\Controllers\ContentRatingController::class, 'trends'])
//     ->name('trends');

// Route::post('/trends/search/result', [App\Http\Controllers\ContentRatingController::class, 'search'])
//     ->name('trends-search');

// Route::get('/read-post/{post_id}/change-comment-status/{comment_id}/{is_deleted}', [App\Http\Controllers\ReadPostController::class, 'changeCommentStatus'])
//     ->name('change-comment-status');

// Route::post('/read-post/comment', [App\Http\Controllers\ReadPostController::class, 'createComment'])
//     ->name('create-comment');

// Route::get('/profile/subscribe/{author_id}', [App\Http\Controllers\UserProfileController::class, 'subscribe'])
//     ->name('subscribe');

// Route::get('/profile/unsubscribe/{author_id}', [App\Http\Controllers\UserProfileController::class, 'unSubscribe'])
//     ->name('unsubscribe');

// Route::get('/like-posе/{post_id}', [App\Http\Controllers\ContentRatingController::class, 'like'])
//     ->name('like-post');

// Route::get('/change-like-status/{post_id}', [App\Http\Controllers\ContentRatingController::class, 'changeLikeStatus'])
//     ->name('change-like-status');

// Route::get('/search/tag/{tag_id}', [App\Http\Controllers\MainController::class, 'filterByTag'])
//     ->name('main-filter-by-tag');

// Route::get('/read-post/{post_id}', [App\Http\Controllers\ReadPostController::class, 'readPost'])
//     ->name('read-post');

// Route::get('/create-post', [App\Http\Controllers\PostRedactorController::class, 'showCreatePostForm'])
//     ->name('show-create-post');

// Route::get('/my-profile', [App\Http\Controllers\UserProfileController::class, 'showUserProfile'])
//     ->name('user-profile');

// Route::get('/profile/{user_id}', [App\Http\Controllers\UserProfileController::class, 'showAnotherUserProfile'])
//     ->name('another-user-profile');

// Route::post('/create-post', [App\Http\Controllers\PostRedactorController::class, 'createPost'])
//     ->name('create-post');

// Route::get('/edit-post/{post_id}', [App\Http\Controllers\PostRedactorController::class, 'showUpdatePostForm'])
//     ->name('edit-post');

// Route::get('/edit-post/remove-tag/{post_id}/{tag_id}', [App\Http\Controllers\PostRedactorController::class, 'removeTag'])
//     ->name('remove-tag');

// Route::get('/api', [App\Http\Controllers\PostRedactorController::class, 'sendTagsJson'])
//     ->name('send-tags-json');

// Route::post('/edit-post/update', [App\Http\Controllers\PostRedactorController::class, 'updatePost'])
//     ->name('update-post');

// Route::post('/edit-post/add-tag', [App\Http\Controllers\PostRedactorController::class, 'addTag'])
//     ->name('add-tag');

// Route::get('/change-post-status/{post_id}/{is_deleted}', [App\Http\Controllers\PostRedactorController::class, 'changePostStatus'])
//     ->name('change-post-status');

// Route::post('/search/result', [App\Http\Controllers\MainController::class, 'search'])
//     ->name('main-search');
