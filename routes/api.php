<?php

use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PengaturanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('proses_data', [PengaturanController::class, 'proses_data']);
Route::get('monitoring/{id}', [PengaturanController::class, 'apiShow']);
