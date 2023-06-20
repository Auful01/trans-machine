<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanMahasiswaJawaban extends Model
{
    use HasFactory;

    protected $table = 'penugasan_mahasiswa_jawaban';

    protected $fillable = [
        'penugasan_mahasiswa_id',
        'soal_id',
        'jawaban',
        'nilai_ai',
        'nilai_dosen',
        'komentar'
    ];

    /**
     * Get the penugasan_mahasiswa a with the PenugasanMahasiswaJawaban
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function penugasan_mahasiswa()
    {
        return $this->hasOne(PenugasanMahasiswa::class, 'id', 'penugasan_mahasiswa_id');
    }
}
