<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentRatingController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostRedactorController;
use App\Http\Controllers\PostsTagsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TagController;
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

// RESTFul переписать по табличке

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('main.index');
    Route::get('/tag/{tag_id}', 'filter')->name('main.filter');
    Route::post('/search', 'search')->name('main.search');
});

Route::controller(LikeController::class)->group(function () {
    Route::get('/post/{post_id}/like/create', 'create')->name('like.create');
    Route::delete('/post/like/delete', 'destroy')->name('like.delete');
    Route::get('/post/{post_id}/like/restore', 'restore')->name('like.restore');
});

Route::controller(CommentController::class)->group(function () {
    Route::get('/post/{post_id}/read/comment/{comment_id}/delete', 'destroy')->name('comment.delete');
    Route::get('/post/{post_id}/read/comment/{comment_id}/restore', 'restore')->name('comment.restore');
    Route::post('/comment', 'store')->name('comment.store');
});

Route::controller(SubscriptionController::class)->group(function () {
    Route::get('/profile/{author_id}/subscribtion/create', 'create')->name('subscription.create');
    Route::get('/profile/{author_id}/subscribtion/delete', 'destroy')->name('subscription.delete');
    Route::get('/profile/{author_id}/subscribtion/restore', 'restore')->name('subscription.restore');
});

Route::controller(TagController::class)->group(function () {
    Route::post('/tag', 'store')->name('tag.store');
});

Route::controller(UserProfileController::class)->group(function () {
    Route::get('/profile/{user_id}', 'index')->name('user.index');
});

Route::controller(ContentRatingController::class)->group(function () {
    Route::get('/trends', 'index')->name('trends.index');
    Route::post('/trends/search', 'search')->name('trends.search');
});

Route::controller(PostsTagsController::class)->group(function () {
    Route::get('/post/{post_id}/tag/{tag_id}/delete', 'destroy')->name('posts_tags.delete');
});

Route::controller(PostRedactorController::class)->group(function () {
    Route::get('/post/{post_id}', 'show')->name('post.show');
    Route::get('/post/{post_id}/edit', 'edit')->name('post.edit');
    Route::get('/post/create', 'create')->name('post.create');
    Route::get('/post/{post_id}/delete', 'destroy')->name('post.delete');
    Route::get('/post/{post_id}/restore', 'restore')->name('post.restore');
    Route::post('/post', 'store')->name('post.store');
    Route::post('/post/{post_id}', 'update')->name('post.update');
    Route::get('/api', 'sendTagsJson')->name('send-tags-json');
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
//     ->name('user.index');

// Route::get('/profile/{user_id}', [App\Http\Controllers\UserProfileController::class, 'showAnotherUserProfile'])
//     ->name('user.index');

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
