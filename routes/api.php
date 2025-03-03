<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EncryptionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function () {
    Route::apiResource('articles', ArticleController::class)
    ->middleware('article.owner')
    ->except(['index', 'store']);
    Route::post('/encrypt', [EncryptionController::class, 'encryptData']);
    Route::post('/decrypt', [EncryptionController::class, 'decryptData']);
});
