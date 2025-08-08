<?php

use App\Http\Controllers\TraccarAuthController;
use App\Http\Controllers\MapDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.pages.dashboard');
});

Route::prefix('traccar')->group(function () {
    Route::get('/login', [TraccarAuthController::class, 'showLoginForm'])->name('traccar.login');
    Route::post('/login', [TraccarAuthController::class, 'login']);
    Route::post('/logout', [TraccarAuthController::class, 'logout'])->name('traccar.logout');
});

// API route for map data (no Livewire interference)
Route::get('/api/map-data', [MapDataController::class, 'getMapData'])->name('api.map-data');
