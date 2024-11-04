<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBangluongTable extends Migration
{
    public function up()
    {
        Schema::create('BangLuong', function (Blueprint $table) {
            $table->id('MaBangLuong');
            $table->unsignedBigInteger('MaNhanVien');
            $table->date('Thang');
            $table->decimal('LuongCoBan', 10, 2);
            $table->decimal('ThuongChuyenCan', 10, 2)->nullable();
            $table->decimal('ThuongKPI', 10, 2)->nullable();
            $table->integer('SoNgayNghi')->nullable();
            $table->decimal('TongLuong', 10, 2);
            $table->foreign('MaNhanVien')->references('MaNhanVien')->on('NhanVien')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('BangLuong');
    }
}
