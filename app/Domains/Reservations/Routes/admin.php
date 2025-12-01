<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth.admin'])->prefix('admin')->group(function () {
    Route::prefix('reservations')->group(function () {
        Route::get('/', [App\Domains\Reservations\Controllers\Admin\ReservationEntityController::class, 'index']);
    });
});