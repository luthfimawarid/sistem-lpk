<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobMatching extends Model
{
    use HasFactory;

    protected $fillable = [
        'posisi',
        'nama_perusahaan',
        'lokasi',
        'deskripsi',
        'status',
        'bidang',
        'user_id',
        'butuh_sertifikat',

    ];


    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

}
