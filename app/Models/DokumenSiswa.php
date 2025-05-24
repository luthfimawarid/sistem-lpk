<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenSiswa extends Model
{
    protected $table = 'dokumen_siswa';

    protected $fillable = ['user_id', 'jenis_dokumen', 'file'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}


