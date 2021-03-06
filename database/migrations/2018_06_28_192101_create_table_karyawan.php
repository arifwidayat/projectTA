<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('nama');
            $table->string('email');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->date('tanggal_masuk');
            $table->string('no_hp');
            $table->string('level');
            $table->string('username')->unique();
            $table->string('password');
            $table->text('photo');
            $table->rememberToken();

            $table->integer('divisi_id')->unsigned();
            $table->foreign('divisi_id')->references('id')->on('divisi')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('karyawan');
    }
}
