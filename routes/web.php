<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/manage/{any}', function () {
    return view('index');
})->where('any', '((?!api).)*');

Route::get('/manage', function () {
    return redirect('/manage/home');
});

Route::get('/admin/{any}', function () {
    return view('admin');
})->where('any', '((?!api).)*');

Route::get('/admin', function () {
    return redirect('/admin/home');
});

Route::get('/{any}', function () {
    return view('home');
})->where('any', '((?!api|manage|admin).)*');
