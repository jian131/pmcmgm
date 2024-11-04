<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhanvienTable extends Migration
{
    public function up()
    {
        Schema::create('NhanVien', function (Blueprint $table) {
            $table->id('MaNhanVien');
            $table->string('HoTen');
            $table->date('NgaySinh');
            $table->string('DiaChi');
            $table->string('SoDienThoai')->unique();
            $table->timestamps(); // Ensure timestamps are included
        });
    }

    public function down()
    {
        Schema::dropIfExists('NhanVien');
    }
}
