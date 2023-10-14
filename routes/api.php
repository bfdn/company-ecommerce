<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("auth")->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::apiResource('blog', BlogController::class);


// Route::get('orders', [OrderController::class, 'index']);
// Route::get('orders/{id}', [OrderController::class, 'show']);
// Route::post('orders', [OrderController::class, 'store']);
// Route::put('orders/{id}', [OrderController::class, 'update']);
// Route::delete('orders/{id}', [OrderController::class, 'delete']);

// Route::prefix("todo")->middleware('auth:api')->group(function () {
//     Route::get('list', [TodoController::class, 'index']);
//     Route::post('create', [TodoController::class, 'store']);
//     Route::get('/{id}/edit', [TodoController::class, 'edit']);
//     Route::put('/{id}/update', [TodoController::class, 'update']);
//     // Route::post('/{id}/update', [TodoController::class, 'update']);
// });
