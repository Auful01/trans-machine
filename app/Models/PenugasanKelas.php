<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanKelas extends Model
{
    use HasFactory;

    protected $table = 'penugasan_kelas';
    protected $fillable = [
        'penugasan_id',
        'kelas_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'created_by',
    ];

    /**
     * Get the penugasan associated with the PenugasanKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function penugasan()
    {
        return $this->hasOne(Penugasan::class, 'id', 'penugasan_id');
    }

    /**
     * Get the kelas associated with the PenugasanKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }
}
