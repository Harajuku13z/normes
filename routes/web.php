<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminUserAuthController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\AdminHomepageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::get('/adminuser/login', [AdminUserAuthController::class, 'showLogin'])->name('admin.adminuser.login');
    Route::post('/adminuser/login', [AdminUserAuthController::class, 'login'])->name('admin.adminuser.login.post');
    Route::post('/adminuser/logout', [AdminUserAuthController::class, 'logout'])->name('admin.adminuser.logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [HomeAdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/section/{key}', [HomeAdminController::class, 'edit'])->name('admin.section.edit');
        Route::put('/section/{key}', [HomeAdminController::class, 'update'])->name('admin.section.update');
        Route::post('/upload', [UploadController::class, 'store'])->name('admin.upload');

        Route::get('/homepage', [AdminHomepageController::class, 'edit'])->name('admin.homepage.edit');
        Route::post('/homepage', [AdminHomepageController::class, 'update'])->name('admin.homepage.update');
    });

    Route::middleware('elizo_adminuser')->group(function () {
        Route::get('/adminuser', [AdminUserController::class, 'index'])->name('admin.adminuser.index');
        Route::post('/adminuser', [AdminUserController::class, 'store'])->name('admin.adminuser.store');
    });
});
