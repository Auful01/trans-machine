<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;

    protected $table = 'penugasan';

    protected $fillable = [
        'file_asal',
        'file_hasil',
        'judul',
        'deskripsi',
        'soal',
        'jawaban_ai',
        'jawaban'
    ];
}
