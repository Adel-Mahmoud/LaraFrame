<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Permissions\Controllers\PermissionEntityController;

Route::middleware(['web','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('permissions', PermissionEntityController::class);
});


