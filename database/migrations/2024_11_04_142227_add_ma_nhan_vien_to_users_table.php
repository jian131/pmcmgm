<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaNhanVienToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('MaNhanVien')->nullable()->after('id');
            $table->foreign('MaNhanVien')->references('MaNhanVien')->on('NhanVien')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['MaNhanVien']);
            $table->dropColumn('MaNhanVien');
        });
    }
}
