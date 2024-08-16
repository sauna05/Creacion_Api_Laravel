<?php
// routes/api.php
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::apiResource('posts', PostController::class);

Route::post('posts', [PostController::class, 'store']);

Route::get('posts', [PostController::class, 'index']);

Route::get('posts/{id}', [PostController::class, 'show']);

Route::put('posts/{id}', [PostController::class, 'update']);

Route::patch('posts/{id}', [PostController::class, 'update']);

Route::delete('posts/{id}', [PostController::class, 'destroy']);


