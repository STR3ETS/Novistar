<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PropertyController;

Route::get('/', function () { return view('welcome'); });
Route::get('/property/{property}', [PropertyController::class, 'show'])->name('property.show');


// AUTHENTICATIE
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/check', [AuthController::class, 'loginCheck'])->name('login.check');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/save', [AuthController::class, 'registerSave'])->name('register.save');


// ADMIN DASHBOARD
Route::get('/dashboard/admin', function () {
    return view('dashboard.admin.index');
})->middleware(['auth', 'role:admin'])->name('dashboard.admin.index');


// OWNER DASHBOARD
Route::get('/dashboard/owner', function () {
    return view('dashboard.owner.index');
})->middleware(['auth', 'role:owner'])->name('dashboard.owner.index');

Route::get('/dashboard/owner/properties', [OwnerController::class, 'properties'])->name('dashboard.owner.properties');
Route::get('/dashboard/owner/property/create', [OwnerController::class, 'propertyCreate'])->name('dashboard.owner.property.create');
Route::post('/dashboard/owner/properties', [OwnerController::class, 'propertyStore'])->name('dashboard.owner.properties.store');


// USER DASHBOARD
Route::get('/dashboard/user', function () {
    return view('dashboard.user.index');
})->middleware(['auth', 'role:user'])->name('dashboard.user.index');
