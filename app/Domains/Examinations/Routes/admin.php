<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Examinations\Controllers\Admin\ExaminationEntityController;

Route::middleware(['web', 'auth.admin'])->prefix('admin')->group(function () {
    Route::prefix('examinations')->group(function () {
        Route::get('/{visit_id?}', [ExaminationEntityController::class, 'index']);
        Route::post('/store', [ExaminationEntityController::class, 'store'])
            ->name('admin.examinations.store');
        Route::get('/show/{id}', [ExaminationEntityController::class, 'show'])
            ->name('admin.examinations.show');
        Route::get('/print/{id}', [ExaminationEntityController::class, 'print'])
            ->name('admin.examinations.print');
    });
});
