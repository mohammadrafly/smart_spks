<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisPelanggaranController;
use App\Http\Controllers\KriteriaPelanggaranController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SanksiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isAuthenticatedAs;

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::match(['GET', 'POST'], '/', 'login')->name('login');
        Route::match(['GET', 'POST'], 'register', 'register')->name('register');
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::match(['GET', 'POST'], '/', 'index')->name('dashboard');
            Route::match(['GET'], 'logout', 'logout')->name('dashboard.logout');
            Route::prefix('profile')->group(function () {
                Route::match(['GET', 'POST'], '/', 'updateProfile')->name('profile.update');
                Route::match(['POST'], 'password', 'updatePassword')->name('password.update');
            });
        });
        Route::middleware('isAuthenticatedAs:admin')->group(function() {
            Route::prefix('user')->group(function () {
                Route::controller(UserController::class)->group(function () {
                    Route::match(['GET'], '/', 'index')->name('user');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('user.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('user.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('user.delete');
                });
            });
        });        
        Route::prefix('sanksi')->group(function () {
            Route::controller(SanksiController::class)->group(function () {
                Route::match(['GET'], '/', 'index')->name('sanksi');
                Route::match(['GET', 'POST'], 'create', 'create')->name('sanksi.create');
                Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('sanksi.update');
                Route::match(['GET'], 'delete/{id}', 'delete')->name('sanksi.delete');
            });
        });
        Route::prefix('siswa')->group(function () {
            Route::controller(SiswaController::class)->group(function () {
                Route::match(['GET'], '/', 'index')->name('siswa');
                Route::match(['GET', 'POST'], 'create', 'create')->name('siswa.create');
                Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('siswa.update');
                Route::match(['GET'], 'delete/{id}', 'delete')->name('siswa.delete');
            });
        });
        Route::prefix('tindakan')->group(function () {
            Route::controller(TindakanController::class)->group(function () {
                Route::match(['GET'], '/', 'index')->name('tindakan');
                Route::match(['GET', 'POST'], 'create', 'create')->name('tindakan.create');
                Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('tindakan.update');
                Route::match(['GET'], 'delete/{id}', 'delete')->name('tindakan.delete');
            });
        });
        Route::prefix('pelanggaran')->group(function () {
            Route::controller(PelanggaranController::class)->group(function () {
                Route::match(['GET'], '/', 'index')->name('pelanggaran');
                Route::match(['GET', 'POST'], 'create', 'create')->name('pelanggaran.create');
                Route::match(['GET', 'POST'], 'detail/{id}', 'detail')->name('pelanggaran.detail');
                Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('pelanggaran.update');
                Route::match(['GET'], 'delete/{id}', 'delete')->name('pelanggaran.delete');
            });
        });
        Route::prefix('kriteriapelanggaran')->group(function () {
            Route::controller(KriteriaPelanggaranController::class)->group(function () {
                Route::match(['GET', 'POST'], 'create', 'create')->name('kriteriapelanggaran.create');
                Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('kriteriapelanggaran.update');
                Route::match(['GET'], 'delete/{id}', 'delete')->name('kriteriapelanggaran.delete');
            });
        });
        Route::prefix('jenispelanggaran')->group(function () {
            Route::controller(JenisPelanggaranController::class)->group(function () {
                Route::match(['GET'], '/', 'index')->name('jenispelanggaran');
                Route::match(['GET', 'POST'], 'create', 'create')->name('jenispelanggaran.create');
                Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('jenispelanggaran.update');
                Route::match(['GET'], 'delete/{id}', 'delete')->name('jenispelanggaran.delete');
            });
        });
    });
});