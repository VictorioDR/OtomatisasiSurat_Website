<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Mengarahkan halaman utama ke /admin
Route::get('/', function () {
    return redirect('/admin');
});

// Rute untuk generate dokumen
Route::middleware(['auth'])->group(function () {
    Route::get('/generate/{template}', [DocumentController::class, 'show'])->name('generate.show');
    Route::post('/generate/{template}', [DocumentController::class, 'generate'])->name('generate.run');
});
