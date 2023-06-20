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
        Schema::table('penugasan_mahasiswa_jawaban', function (Blueprint $table) {
            $table->tinyInteger('is_review')->default(0)->after('nilai');
        });

        Schema::table('penugasan_mahasiswa', function (Blueprint $table) {
            $table->tinyInteger('is_review')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
