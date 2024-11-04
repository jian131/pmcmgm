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
            $table->string('HoTen', 100);
            $table->date('NgaySinh')->nullable();
            $table->string('DiaChi', 255)->nullable();
            $table->string('SoDienThoai', 15)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('NhanVien');
    }
}
