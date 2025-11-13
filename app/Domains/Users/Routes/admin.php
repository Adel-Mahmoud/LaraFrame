<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Users\Controllers\Admin\UserEntityController;

Route::middleware(['web','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserEntityController::class);
});