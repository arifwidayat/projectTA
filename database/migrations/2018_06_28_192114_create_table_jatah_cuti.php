<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJatahCuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jatah_cuti', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tahun');
            $table->string('jumlah_cuti');
            
            $table->integer('karyawan_id')->unsigned();
            $table->foreign('karyawan_id')->references('id')->on('karyawan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jatah_cuti');
    }
}
