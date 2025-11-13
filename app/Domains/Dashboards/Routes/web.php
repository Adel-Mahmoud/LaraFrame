<?php

use Illuminate\Support\Facades\Route;

Route::prefix('dashboards')->group(function () {
    Route::get('/', [App\Domains\Dashboards\Controllers\Web\DashboardEntityController::class, 'index']);
});