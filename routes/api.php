<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
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

Route::middleware('auth:sanctum')->group(function (){

    // Route::resource('tasks', TaskController::class);

    //log out 
    Route::post('logout',[AuthController::class, 'logout']);

    Route::get('tasks',[TaskController::class, 'index']);
    Route::post('tasks',[TaskController::class, 'store']);
    Route::get('tasks/{id}',[TaskController::class, 'show']);
    Route::get('tasks/{id}/edit',[TaskController::class, 'edit']);
    Route::put('tasks/{id}',[TaskController::class, 'update']);
    Route::delete('tasks/{id}', [TaskController::class, 'destory']);
});

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);

