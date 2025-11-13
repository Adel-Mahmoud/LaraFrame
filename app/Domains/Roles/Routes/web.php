<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('roles')->group(function () {
    Route::get('/', [App\Domains\Roles\Controllers\Web\RoleEntityController::class, 'index']);
});