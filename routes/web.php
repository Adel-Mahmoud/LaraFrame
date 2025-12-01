<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();


Route::get('/', function () {
    return Inertia::render('Home'); // resources/js/Pages/Home.tsx
});


Route::get('/{page}', [AdminController::class, 'index']);