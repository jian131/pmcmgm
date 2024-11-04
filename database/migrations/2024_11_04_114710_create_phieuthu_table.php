<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhieuthuTable extends Migration
{
    public function up()
    {
        Schema::create('PhieuThu', function (Blueprint $table) {
            $table->id('MaPhieuThu');
            $table->unsignedBigInteger('MaHoaDon');
            $table->date('NgayLap');
            $table->string('NguoiLap', 100)->nullable();
            $table->decimal('SoTien', 10, 2);
            $table->foreign('MaHoaDon')->references('MaHoaDon')->on('HoaDon')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('PhieuThu');
    }
}
