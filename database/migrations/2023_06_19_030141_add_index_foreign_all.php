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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->change();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::table('penugasan_mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('mahasiswa_id')->change();
            $table->unsignedBigInteger('penugasan_kelas_id')->change();
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('penugasan_kelas_id')->references('id')->on('penugasan_kelas')->onDelete('cascade');
        });

        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('kelas_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
        });

        Schema::table('dosen', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Schema::table('penugasan', function (Blueprint $table) {
        //     $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        // });

        Schema::table('penugasan_kelas', function (Blueprint $table) {
            $table->unsignedBigInteger('penugasan_id')->change();
            $table->unsignedBigInteger('kelas_id')->change();
            $table->foreign('penugasan_id')->references('id')->on('penugasan')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
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
