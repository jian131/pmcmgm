<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhachhangTable extends Migration
{
    public function up()
    {
        Schema::create('KhachHang', function (Blueprint $table) {
            $table->id('MaKhachHang');
            $table->string('TenKhachHang', 100);
            $table->string('SoDienThoai', 15)->nullable();
            $table->string('DiaChi', 255)->nullable();
            $table->integer('DiemTichLuy')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('KhachHang');
    }
}
