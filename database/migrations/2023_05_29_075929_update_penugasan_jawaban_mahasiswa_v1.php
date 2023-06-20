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
            $table->text('komentar')->after('nilai')->nullabel();
            $table->double('nilai_dosen')->after('nilai')->nullabel();
            $table->renameColumn('nilai', 'nilai_ai');
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
