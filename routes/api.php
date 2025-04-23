<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/random', [ArticleController::class, 'random']);
Route::get('/articles/category', [ArticleController::class, 'byCategory']);
Route::get('/articles/source', [ArticleController::class, 'bySource']);

Route::get('/test/{service}', [TestController::class, 'test']);