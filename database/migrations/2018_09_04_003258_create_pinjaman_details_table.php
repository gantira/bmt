<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinjamanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjaman_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pinjaman_id');
            $table->double('bayar_bulanan', 15,2);
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('pinjaman_id')->references('id')->on('pinjamans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pinjaman_details');
    }
}
