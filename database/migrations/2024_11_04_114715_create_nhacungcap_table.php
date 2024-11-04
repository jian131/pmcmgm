<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhacungcapTable extends Migration
{
    public function up()
    {
        Schema::create('NhaCungCap', function (Blueprint $table) {
            $table->id('MaNhaCungCap');
            $table->string('TenNhaCungCap', 100);
            $table->string('DiaChi', 255)->nullable();
            $table->string('SoDienThoai', 15)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('NhaCungCap');
    }
}
