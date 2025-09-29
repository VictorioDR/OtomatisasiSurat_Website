<?php

use App\Http\Controllers\DocumentController;

Route::middleware(['auth'])->group(function () {
    Route::get('/generate/{template}', [DocumentController::class, 'show'])->name('generate.show');
    Route::post('/generate/{template}', [DocumentController::class, 'generate'])->name('generate.run');
});
