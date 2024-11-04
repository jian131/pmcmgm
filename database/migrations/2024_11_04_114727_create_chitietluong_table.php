<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChitietluongTable extends Migration
{
    public function up()
    {
        Schema::create('ChiTietLuong', function (Blueprint $table) {
            $table->id('MaChiTiet');
            $table->unsignedBigInteger('MaBangLuong');
            $table->string('MoTa', 255)->nullable();
            $table->decimal('SoTien', 10, 2);
            $table->foreign('MaBangLuong')->references('MaBangLuong')->on('BangLuong')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ChiTietLuong');
    }
}
