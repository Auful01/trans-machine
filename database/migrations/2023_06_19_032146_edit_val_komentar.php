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
        //
        Schema::table('penugasan_mahasiswa_jawaban', function (Blueprint $table) {
            $table->text('komentar')->nullable()->change();
            $table->unsignedBigInteger('penugasan_mahasiswa_id')->change();
            $table->foreign('penugasan_mahasiswa_id')->references('id')->on('penugasan_mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
