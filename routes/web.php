<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () { return view('welcome'); });

// AUTHENTICATIE
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/check', [AuthController::class, 'loginCheck'])->name('login.check');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/save', [AuthController::class, 'registerSave'])->name('register.save');

Route::get('/dashboard/admin', function () {
    return view('dashboard.admin.index');
})->name('dashboard.admin.index');

Route::get('/dashboard/user', function () {
    return view('dashboard.user.index');
})->name('dashboard.user.index');
