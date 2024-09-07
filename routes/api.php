<?php

// routes/api.php

use App\Http\Controllers\ComentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Route::post("login", [UserController::class, "login"]);
Route::post("register", [UserController::class, 'register']);

Route::get('users', [UserController::class,'users']);

Route::delete('logout', [UserController::class,'logout']);

// Rutas protegidas por autenticación
//implementacion de sanctum para el manejo de generacion de token
Route::middleware(['auth:sanctum'])->group(function () {
    //rutas para controlar el registro de comentarios
    Route::post('posts/{post}/comments', [ComentController::class, 'store']);
    Route::delete('posts/{post}/comments', [ComentController::class,'destroy']);
    Route::get('posts/{post}/comments', [ComentController::class,'index']);

   //rutas para manejar el registro de post
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::patch('posts/{id}', [PostController::class, 'update']);
    
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
    

});


