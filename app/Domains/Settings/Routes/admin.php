<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Settings\Controllers\Admin\SettingEntityController;

Route::middleware(['web', 'auth.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingEntityController::class, 'index'])->name('index');
            Route::put('/', [SettingEntityController::class, 'update'])->name('update');
        });
    });
