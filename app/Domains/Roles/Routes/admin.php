<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Roles\Controllers\RoleEntityController;

Route::middleware(['web','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('roles', RoleEntityController::class);
});