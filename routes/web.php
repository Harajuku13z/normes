<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [HomeAdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/section/{key}', [HomeAdminController::class, 'edit'])->name('admin.section.edit');
        Route::put('/section/{key}', [HomeAdminController::class, 'update'])->name('admin.section.update');
        Route::post('/upload', [UploadController::class, 'store'])->name('admin.upload');
    });
});
