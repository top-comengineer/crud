<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/read', [UsersController::class, 'index']);
    Route::post('add', [UsersController::class, 'add']);
    Route::get('edit/{id}', [UsersController::class, 'edit']);
    Route::post('update/{id}', [UsersController::class, 'update']);
    Route::delete('delete/{id}', [UsersController::class, 'delete']);
    Route::post('/import', [UsersController::class, 'import']); // import route
    Route::get('/export', [UsersController::class, 'export']); // export route
});