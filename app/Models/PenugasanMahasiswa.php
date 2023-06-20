<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'penugasan_mahasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'penugasan_kelas_id',
        'status',
        'total_nilai',
        'waktu_mulai',
        'waktu_selesai'
    ];


    /**
     * Get the mahasiswa associated with the PenugasanMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id', 'mahasiswa_id');
    }


    /**
     * Get the penugasan associated with the PenugasanMahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function penugasan_kelas()
    {
        return $this->hasOne(PenugasanKelas::class, 'id', 'penugasan_kelas_id');
    }
}
