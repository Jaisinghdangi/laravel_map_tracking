<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::apiResource('posts', PostController::class);  // url http://127.0.0.1:8000/api/posts


// Route::middleware('auth:sanctum')->apiResource('posts', PostController::class);

Route::post('login', [PostController::class, 'login']);
// Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('posts', PostController::class);
// });

// Route::middleware('auth:sanctum')->post('logout', [PostController::class, 'logout']);


Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [PostController::class, 'logout']);

    Route::controller(PostController::class)->group(function() {
        // Route::get('/products', 'index');
        Route::get('/posts', 'index');
        Route::get('/posts/{id}', 'show');

        Route::post('/posts', 'store');
        Route::post('/posts/{id}', 'update');
        Route::delete('/posts/{id}', 'destroy');
    });
});