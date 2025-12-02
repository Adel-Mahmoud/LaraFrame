<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();


Route::get('/', function () {
    return view('index'); 
}); 

Route::get('/admin', function () {
    return view('welcome'); 
});


Route::get('/{page}', [AdminController::class, 'index']);