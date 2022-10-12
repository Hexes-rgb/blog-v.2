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

Route::get('/post-redactor', [App\Http\Controllers\PostRedactorController::class, 'show'])
    ->name('post-redactor');

Route::post('/post-redactor', [App\Http\Controllers\PostRedactorController::class, 'create'])
    ->name('post-redactor');

Route::post('/', [App\Http\Controllers\MainController::class, 'search'])
    ->name('main');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
