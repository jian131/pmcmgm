<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\ThuocController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\PhieuNhapController;
use App\Http\Controllers\BangLuongController;
use App\Http\Controllers\ChiTietLuongController;
use App\Http\Controllers\PhieuThuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and contained within the
| "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('khachhang', KhachHangController::class);
    Route::resource('nhanvien', NhanVienController::class);
    Route::resource('thuoc', ThuocController::class);
    Route::resource('hoadon', HoaDonController::class);
    Route::resource('phieunhap', PhieuNhapController::class);
    Route::resource('bangluong', BangLuongController::class);
    Route::resource('chitietluong', ChiTietLuongController::class);
    Route::resource('phieuthu', PhieuThuController::class);
});

require __DIR__.'/auth.php';
