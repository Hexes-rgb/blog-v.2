<?php

use App\Models\Tag;
// use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostSearchController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\SubscriptionController;

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

Route::controller(PostSearchController::class)->group(function () {
    Route::get('/tag/{tag_id}', 'filter')->name('post_search.filter');
    Route::get('/search', 'search')->name('post_search.search');
});

Route::middleware('auth')->group(function () {
    Route::controller(LikeController::class)->group(function () {
        Route::post('/post/{post_id}/like', 'store')->name('like.store');
        Route::delete('/post{post_id}/like', 'destroy')->name('like.delete');
        Route::post('/post/{post_id}/like/restore', 'restore')->name('like.restore');
    });

    Route::controller(CommentController::class)->group(function () {
        Route::post('/comment', 'store')->name('comment.store');
        Route::delete('/post/{post_id}/read/comment/{comment_id}', 'destroy')->name('comment.delete');
        Route::post('/post/{post_id}/read/comment/{comment_id}/restore', 'restore')->name('comment.restore');
    });

    Route::controller(SubscriptionController::class)->group(function () {
        Route::post('/profile/{author_id}/subscribtion', 'store')->name('subscription.store');
        Route::delete('/profile/{author_id}/subscribtion', 'destroy')->name('subscription.delete');
        Route::post('/profile/{author_id}/subscribtion/restore', 'restore')->name('subscription.restore');
    });

    Route::controller(PostTagController::class)->group(function () {
        Route::delete('/post/{post_id}/tag/{tag_id?}', 'destroy')->name('post_tag.delete');
        Route::post('/post/{post_id}/tag', 'store')->name('post_tag.store');
    });

    Route::controller(TagController::class)->group(function () {
        Route::post('/tag', 'store')->name('tag.store');
    });

    Route::controller(MailController::class)->group(function () {
        Route::get('/mail/create', 'create')->name('mail.create');
        Route::post('/mail', 'store')->name('mail.store');
    });
});

Route::controller(UserController::class)->group(function () {
    Route::get('/profile/{user_id}', 'index')->name('user.index');
});

Route::controller(PostController::class)->group(function () {
    Route::get('/post', 'index')->name('post.index');
    Route::get('/post/create', 'create')->middleware('auth')->name('post.create');
    Route::post('/post', 'store')->middleware('auth')->name('post.store');
    Route::get('/post/{post_id}', 'show')->name('post.show');
    Route::get('/post/{post_id}/edit', 'edit')->middleware('auth')->name('post.edit');
    Route::patch('/post/{post_id}', 'update')->middleware('auth')->name('post.update');
    Route::delete('/post/{post_id}', 'destroy')->middleware('auth')->name('post.delete');
    Route::post('/post/{post_id}/restore', 'restore')->middleware('auth')->name('post.restore');
});

// Route::get('/api', function () {
//     return new TagResource(Tag::all('name'));
// });
// Route::get('/api', [PostController::class, 'sendTagsJson'])->name('send.json.tags');
Route::get('/api', function () {
    return response()->json(Tag::all('name')->toJson());
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
