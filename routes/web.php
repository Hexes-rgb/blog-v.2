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

Route::get('/', [App\Http\Controllers\MainController::class, 'index'])
    ->name('main');

Route::get('/read', [App\Http\Controllers\ReadPostController::class, 'show'])
    ->name('read-post');

Route::get('/create-post', [App\Http\Controllers\PostRedactorController::class, 'show_create_post_form'])
    ->name('create-post');

Route::post('/create-post', [App\Http\Controllers\PostRedactorController::class, 'create_post'])
    ->name('create-post');

Route::get('/edit-post', [App\Http\Controllers\PostRedactorController::class, 'show_update_post_form'])
    ->name('edit-post');

Route::post('/edit-post', [App\Http\Controllers\PostRedactorController::class, 'update_post'])
    ->name('edit-post');

Route::get('/delete-post', [App\Http\Controllers\PostRedactorController::class, 'delete_post'])
    ->name('delete-post');

Route::post('/', [App\Http\Controllers\MainController::class, 'search'])
    ->name('main');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
