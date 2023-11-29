<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\LanguageController;
use App\Http\Controllers\API\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route Auth user permission
Route::prefix('{language}')->middleware(['auth:api'])->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('create-post', [PostController::class, 'store']);
    Route::put('post-update/{id}', [PostController::class, 'update']);
    Route::post('post/{id}/comment', [CommentController::class, 'store']);
    Route::put('update-comment/{id}', [CommentController::class, 'update']);
});



// Route moderator permission
Route::prefix('{language}')->middleware(['api', 'auth', 'moderator', 'admin'])->group(function() {
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
});

// Route Admin permission
Route::middleware(['api', 'auth', 'blocked', 'admin'])->group(function () {
    Route::get('/blocked', [AdminController::class, 'blocked']);
    Route::post('user-status/{id}', [AdminController::class, 'checkUser']);
});

// all users route
Route::group(['prefix' => '{language}'], function () {
    Route::get('posts', [PostController::class, 'getAllPost']);
    Route::get('show-posts/{id}', [PostController::class, 'edit']);
    Route::get('comment/{id}', [CommentController::class, 'index']);
    Route::get('edit-comment/{id}', [CommentController::class, 'edit']);


});

//change language Route
Route::post('/change-language/{lang}', [LanguageController::class, 'changeLanguage']);
