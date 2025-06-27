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
        'durasi_menit', // <-- Tambahkan ini
        'status',
        'bidang'
    ];

    public function soalKuis()
    {
        return $this->hasMany(SoalKuis::class);
    }

    public function TugasUser()
    {
        return $this->hasMany(TugasUser::class);
    }


}
