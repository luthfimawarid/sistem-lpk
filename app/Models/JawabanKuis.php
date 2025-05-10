<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanKuis extends Model
{
    use HasFactory;

    protected $table = 'jawaban_kuis';

    protected $fillable = [
        'tugas_id',
        'soal_kuis_id',
        'user_id',
        'jawaban',
    ];

    // Relasi ke tugas
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    // Relasi ke soal
    public function soal()
    {
        return $this->belongsTo(SoalKuis::class, 'soal_kuis_id');
    }

    // Relasi ke user (siswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
