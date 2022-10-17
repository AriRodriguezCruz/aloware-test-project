<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('posts')->group(function () {
    Route::prefix('{postId?}')->group(function () {
        Route::get('/', [PostController::class, 'show']);
        Route::prefix('comments')->group(function () {
            Route::post('{parentId?}/create', [CommentController::class, 'store']);
            Route::prefix('{commentId}')->group(function () {
                Route::patch('update', [CommentController::class, 'update']);
                Route::delete('delete', [CommentController::class, 'destroy']);
            });
        });
    });
});
