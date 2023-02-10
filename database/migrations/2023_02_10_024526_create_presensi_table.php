<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nik');
            $table->foreign('nik')->references('nik')->on('employees');
            $table->date('presensi_date');
            $table->time('clock_in');
            $table->time('clock_out');
            $table->string('photo_in', 255);
            $table->string('photo_out', 255);
            $table->text('location');
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
        Schema::dropIfExists('presensi');
    }
};
