<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhieunhapTable extends Migration
{
    public function up()
    {
        Schema::create('PhieuNhap', function (Blueprint $table) {
            $table->id('MaPhieuNhap');
            $table->date('NgayNhap');
            $table->unsignedBigInteger('MaThuoc');
            $table->string('TenThuoc', 100);
            $table->integer('SoLuong');
            $table->unsignedBigInteger('MaNhaCungCap');
            $table->foreign('MaThuoc')->references('MaThuoc')->on('Thuoc')->onDelete('cascade');
            $table->foreign('MaNhaCungCap')->references('MaNhaCungCap')->on('NhaCungCap')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('PhieuNhap');
    }
}
