<?php

use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth')->group(function () {

    // Home controller
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');

    // get one page
    Route::get('/page/{id}', [App\Http\Controllers\PageController::class, 'getPage'])
        ->name('getPage');

    //pagination comment by load more
    Route::post('/comments/load-more-comments', [App\Http\Controllers\CommentContraller::class, 'CommentsLoadMore'])
        ->name('loadMoreComments');

    //add new comment
    Route::post('/comments/add', [App\Http\Controllers\CommentContraller::class, 'CommentsAdd'])
        ->name('CommentsAdd');

});

Auth::routes();
