<?php

use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PengaturanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('nonaktif-kendaraan/{id}', [KendaraanController::class, 'nonaktif'])->name('kendaraans.nonaktif');
Route::get('aktif-kendaraan/{id}', [KendaraanController::class, 'aktif'])->name('kendaraans.aktif');


Route::resource('penggunas', PenggunaController::class);
Route::resource('monitorings', MonitoringController::class);
Route::resource('sewas', SewaController::class);
Route::resource('kendaraans', KendaraanController::class);
Route::resource('pengaturans', PengaturanController::class);

Route::get('test', function () {
    return view('layouts.main');
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});
