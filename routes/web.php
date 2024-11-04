<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\ThuocController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\BangLuongController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // General user routes
    Route::resource('khachhang', KhachHangController::class);
    Route::resource('thuoc', ThuocController::class);
    Route::resource('hoadon', HoaDonController::class);

    // Admin only routes
    Route::middleware(['role:quản lý'])->group(function () {
        Route::resource('nhanvien', NhanVienController::class);
        Route::resource('nhacungcap', NhaCungCapController::class);
        Route::resource('bangluong', BangLuongController::class);
    });
});

require __DIR__.'/auth.php';
