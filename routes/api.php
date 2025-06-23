<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('rate.limit:api')->group(function () {
    
    // Articles API
    Route::prefix('articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::get('/recent', [ArticleController::class, 'recent']);
        Route::get('/search', [ArticleController::class, 'search']);
        Route::get('/category/{categoryId}', [ArticleController::class, 'byCategory']);
        Route::get('/{article}', [ArticleController::class, 'show']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 