<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalKuis extends Model
{
    protected $table = 'soal_kuis';
    protected $fillable = ['tugas_id', 'pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'jawaban'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    // Tambahkan relasi ke jawaban kuis
    public function jawabanKuis()
    {
        return $this->hasMany(JawabanKuis::class, 'soal_kuis_id');
    }
}