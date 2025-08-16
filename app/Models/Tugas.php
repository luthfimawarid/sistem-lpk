<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 
        'deskripsi', 
        'tipe', 
        'cover', 
        'deadline',
        'durasi_menit',
        'status',
        'bidang',
        'kelas',
        'jenis_ujian_akhir' // ✅ tambahkan ini
    ];


    public function soalKuis()
    {
        return $this->hasMany(SoalKuis::class);
    }

    public function TugasUser()
    {
        return $this->hasMany(TugasUser::class);
    }

    public function kelas()
    {
        return $this->belongsTo(User::class);
    }



}
