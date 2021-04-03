<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhanvienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhanvien', function (Blueprint $table) {
            $table->string('manhanvien',200)->primary();
            $table->string('tennhanvien',100);
            $table->boolean('gioitinh');
            $table->string('diachi',200);
            $table->date('ngaysinh');
            $table->string('sodienthoai',15);
            $table->string('email',200);
            $table->string('chucvu',200);
            $table->date('ngayvaolam');
            $table->string('hinhanh',200);
            $table->string('maluong',200);
            $table->string('password',300);
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
        Schema::dropIfExists('nhanvien');
    }
}
