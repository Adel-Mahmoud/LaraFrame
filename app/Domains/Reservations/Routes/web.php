<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('reservations')->group(function () {
    Route::get('/', [App\Domains\Reservations\Controllers\Web\ReservationEntityController::class, 'index']);
});