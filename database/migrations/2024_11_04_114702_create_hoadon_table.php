<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoaDonTable extends Migration
{
    public function up()
    {
        Schema::create('HoaDon', function (Blueprint $table) {
            $table->id('MaHoaDon');
            $table->date('NgayLap');
            $table->unsignedBigInteger('MaKhachHang')->nullable();
            $table->unsignedBigInteger('MaNhanVien')->nullable();
            $table->foreign('MaKhachHang')->references('MaKhachHang')->on('KhachHang')->onDelete('cascade');
            $table->foreign('MaNhanVien')->references('MaNhanVien')->on('NhanVien')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('HoaDon');
    }
}
