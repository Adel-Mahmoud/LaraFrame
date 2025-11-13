<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Auth\Controllers\Admin\LoginEntityController;

Route::prefix('admin')->middleware('web')->group(function () {
    Route::get('login', [LoginEntityController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginEntityController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [LoginEntityController::class, 'logout'])->name('admin.logout');
    Route::get('register', [LoginEntityController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('register', [LoginEntityController::class, 'register'])->name('admin.register.submit');
});
