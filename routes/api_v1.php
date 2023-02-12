<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\api\AuthController::class, 'login']);
Route::middleware('jwt_auth')->get('/me', [\App\Http\Controllers\api\UserController::class, 'getMe']);
