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
        Schema::create('penugasan_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('penugasan_id');
            $table->string('kelas_id');
            $table->dateTime('tanggal_mulai')->default(now());
            $table->dateTime('tanggal_selesai');
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('penugasan_kelas');
    }
};
