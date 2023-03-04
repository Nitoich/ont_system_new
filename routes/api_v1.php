<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\api\AuthController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\api\AuthController::class, 'logout']);

Route::middleware(['jwt_auth'])
    ->get('/me', [\App\Http\Controllers\api\UserController::class, 'getMe']);

Route::get('/session/refresh', [\App\Http\Controllers\api\SessionController::class, 'refresh']);

Route::middleware('jwt_auth')->group(function () {
    Route::middleware('permission:read_self_sessions')->get('/session', [\App\Http\Controllers\api\SessionController::class, 'getSessions']);

    Route::prefix('/user')->group(function () {
        Route::post('/', [\App\Http\Controllers\api\UserController::class, 'store']);
        Route::get('/{id}/role', [\App\Http\Controllers\api\UserController::class, 'getRoles']);
        Route::post('/{id}/role', [\App\Http\Controllers\api\UserController::class, 'setRoles']);
        Route::get('/{id}', [\App\Http\Controllers\api\UserController::class, 'getUser']);
        Route::get('/', [\App\Http\Controllers\api\UserController::class, 'index']);
        Route::patch('/{id}', [\App\Http\Controllers\api\UserController::class, 'update']);
    });

    Route::prefix('/role')->group(function () {
        Route::get('/', [\App\Http\Controllers\api\RoleController::class, 'index']);
    });

    Route::prefix('/group')->group(function() {
        Route::post('/', [\App\Http\Controllers\api\GroupController::class, 'create']);
        Route::get('/', [\App\Http\Controllers\api\GroupController::class, 'getAll']);
        Route::get('/{group_id}', [\App\Http\Controllers\api\GroupController::class, 'getOne']);
        Route::patch('/{group_id}', [\App\Http\Controllers\api\GroupController::class, 'update']);
        Route::delete('/{group_id}', [\App\Http\Controllers\api\GroupController::class, 'delete']);
    });

//    Route::resource('speciality', \App\Http\Controllers\api\SpecialityController::class);

    Route::prefix('/speciality')->group(function () {
        Route::get('/', [\App\Http\Controllers\api\SpecialityController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\api\SpecialityController::class, 'show']);
        Route::post('/', [\App\Http\Controllers\api\SpecialityController::class, 'store']);
        Route::patch('/{id}', [\App\Http\Controllers\api\SpecialityController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\api\SpecialityController::class, 'destroy']);
    });

//    Route::resource('discipline', \App\Http\Controllers\api\DisciplineController::class);

    Route::prefix('/discipline')->group(function () {
        Route::get('/', [\App\Http\Controllers\api\DisciplineController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\api\DisciplineController::class, 'show']);
        Route::post('/', [\App\Http\Controllers\api\DisciplineController::class, 'store']);
        Route::patch('/{id}', [\App\Http\Controllers\api\DisciplineController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\api\DisciplineController::class, 'destroy']);
    });

//    Route::resource('file', \App\Http\Controllers\api\FileController::class);

    Route::prefix('/file')->group(function() {
        Route::post('/', [\App\Http\Controllers\api\FileController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\api\FileController::class, 'show']);
    });

//    Route::resource('semester', \App\Http\Controllers\api\SemesterController::class);

    Route::prefix('/semester')->group(function () {
        Route::get('/', [\App\Http\Controllers\api\SemesterController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\api\SemesterController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\api\SemesterController::class, 'show']);
        Route::patch('/{id}', [\App\Http\Controllers\api\SemesterController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\api\SemesterController::class, 'destroy']);
    });

//    Route::resource('load', \App\Http\Controllers\api\LoadController::class);

    Route::prefix('/load')->group(function() {
        Route::get('/', [\App\Http\Controllers\api\LoadController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\api\LoadController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\api\LoadController::class, 'show']);
        Route::patch('/{id}', [\App\Http\Controllers\api\LoadController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\api\LoadController::class, 'destroy']);
    });
});
