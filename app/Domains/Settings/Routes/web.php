<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('settings')->group(function () {
    Route::get('/', [App\Domains\Settings\Controllers\Web\SettingEntityController::class, 'index']);
});