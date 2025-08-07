<?php

use App\Http\Controllers\TraccarAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.pages.dashboard');
});

Route::prefix('traccar')->group(function () {
    Route::get('/login', [TraccarAuthController::class, 'showLoginForm'])->name('traccar.login');
    Route::post('/login', [TraccarAuthController::class, 'login']);
    Route::post('/logout', [TraccarAuthController::class, 'logout'])->name('traccar.logout');
});
