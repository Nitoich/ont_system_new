<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\api\AuthController::class, 'login']);


Route::middleware(['jwt_auth'])
    ->get('/me', [\App\Http\Controllers\api\UserController::class, 'getMe']);

Route::middleware('jwt_auth')->group(function () {
    Route::middleware('permission:read_self_sessions')->get('/session', [\App\Http\Controllers\api\SessionController::class, 'getSessions']);

    Route::prefix('/group')->group(function() {
        Route::post('/', [\App\Http\Controllers\api\GroupController::class, 'create']);
        Route::get('/', [\App\Http\Controllers\api\GroupController::class, 'getAll']);
        Route::get('/{group_id}', [\App\Http\Controllers\api\GroupController::class, 'getOne']);
        Route::patch('/{group_id}', [\App\Http\Controllers\api\GroupController::class, 'update']);
        Route::delete('/{group_id}', [\App\Http\Controllers\api\GroupController::class, 'delete']);
    });

    Route::resource('speciality', \App\Http\Controllers\api\SpecialityController::class);
});
