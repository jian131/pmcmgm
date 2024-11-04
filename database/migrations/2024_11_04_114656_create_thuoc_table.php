<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThuocTable extends Migration
{
    public function up()
    {
        Schema::create('Thuoc', function (Blueprint $table) {
            $table->id('MaThuoc');
            $table->string('TenThuoc', 100);
            $table->string('NhomLoaiThuoc', 50)->nullable();
            $table->string('HangSanXuat', 100)->nullable();
            $table->date('HanSuDung')->nullable();
            $table->integer('SoLuong')->nullable();
            $table->decimal('Gia', 10, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Thuoc');
    }
}
