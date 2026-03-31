<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminUserAuthController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\AdminHomepageController;
use App\Http\Controllers\Admin\AdminContactSettingsController;
use App\Http\Controllers\Admin\AdminAvisSettingsController;
use App\Http\Controllers\Admin\AdminLayoutSettingsController;
use App\Http\Controllers\Admin\AdminServicePagesController;
use App\Http\Controllers\ServicePagesController;
use App\Http\Controllers\SimulateurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
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
        Route::get('/contact-settings', [AdminContactSettingsController::class, 'edit'])->name('admin.contact_settings.edit');
        Route::post('/contact-settings', [AdminContactSettingsController::class, 'update'])->name('admin.contact_settings.update');
        Route::get('/layout-settings', [AdminLayoutSettingsController::class, 'edit'])->name('admin.layout_settings.edit');
        Route::post('/layout-settings', [AdminLayoutSettingsController::class, 'update'])->name('admin.layout_settings.update');
        Route::get('/avis-settings', [AdminAvisSettingsController::class, 'edit'])->name('admin.avis_settings.edit');
        Route::post('/avis-settings', [AdminAvisSettingsController::class, 'update'])->name('admin.avis_settings.update');
        Route::post('/avis-settings/fetch-google', [AdminAvisSettingsController::class, 'fetchGoogle'])->name('admin.avis_settings.fetch_google');
    });

    Route::middleware('elizo_adminuser')->group(function () {
        Route::get('/adminuser', [AdminUserController::class, 'index'])->name('admin.adminuser.index');
        Route::post('/adminuser', [AdminUserController::class, 'store'])->name('admin.adminuser.store');
    });
});

// Pages publiques dédiées aux services
Route::get('/services/{slug}', [ServicePagesController::class, 'show'])->name('service.page');

// Page publique contact (formulaire)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.page');

// Simulateur de devis (multi-étapes)
Route::get('/simulateur', [SimulateurController::class, 'start'])->name('simulateur.start');
Route::get('/simulateur/etape-1', [SimulateurController::class, 'step1'])->name('simulateur.step1');
Route::post('/simulateur/etape-1', [SimulateurController::class, 'step1Store'])->name('simulateur.step1.store');
Route::get('/simulateur/etape-2', [SimulateurController::class, 'step2'])->name('simulateur.step2');
Route::post('/simulateur/etape-2', [SimulateurController::class, 'step2Store'])->name('simulateur.step2.store');
Route::get('/simulateur/etape-3', [SimulateurController::class, 'step3'])->name('simulateur.step3');
Route::post('/simulateur/etape-3', [SimulateurController::class, 'step3Store'])->name('simulateur.step3.store');
Route::get('/simulateur/etape-4', [SimulateurController::class, 'step4'])->name('simulateur.step4');
Route::post('/simulateur/etape-4', [SimulateurController::class, 'step4Store'])->name('simulateur.step4.store');
Route::get('/simulateur/etape-5', [SimulateurController::class, 'step5'])->name('simulateur.step5');
Route::post('/simulateur/finaliser', [SimulateurController::class, 'finish'])->name('simulateur.finish');
Route::get('/simulateur/ok', [SimulateurController::class, 'success'])->name('simulateur.success');

// Admin : pages dédiées aux services
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::prefix('services-pages')->name('admin.services_pages.')->group(function () {
        Route::get('/', [AdminServicePagesController::class, 'index'])->name('index');
        Route::get('/create', [AdminServicePagesController::class, 'create'])->name('create');
        Route::post('/', [AdminServicePagesController::class, 'store'])->name('store');
        Route::get('/{servicePage}/edit', [AdminServicePagesController::class, 'edit'])->name('edit');
        Route::put('/{servicePage}', [AdminServicePagesController::class, 'update'])->name('update');
    });
});
