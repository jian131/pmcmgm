<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChitiethoadonTable extends Migration
{
    public function up()
    {
        Schema::create('ChiTietHoaDon', function (Blueprint $table) {
            $table->unsignedBigInteger('MaHoaDon');
            $table->unsignedBigInteger('MaThuoc');
            $table->integer('SoLuong');
            $table->decimal('ThanhTien', 10, 2);
            $table->primary(['MaHoaDon', 'MaThuoc']);
            $table->foreign('MaHoaDon')->references('MaHoaDon')->on('HoaDon')->onDelete('cascade');
            $table->foreign('MaThuoc')->references('MaThuoc')->on('Thuoc')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ChiTietHoaDon');
    }
}
