<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth.admin'])->prefix('admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [App\Domains\Dashboards\Controllers\Admin\DashboardEntityController::class, 'index']);
    });
});