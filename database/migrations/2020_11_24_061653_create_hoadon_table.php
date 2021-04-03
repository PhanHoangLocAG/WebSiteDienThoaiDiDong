<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoadonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoadon', function (Blueprint $table) {
            $table->increments('mahoadon');
            $table->string('makhachhang');
            $table->string('tenkhachhang');
            $table->string('manhanvien');
            $table->string('diachi');
            $table->string('sodienthoai');
            $table->string('email');
            $table->tinyInteger('thanhtoan');
            $table->tinyInteger('phuongthucgiaohang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoadon');
    }
}
