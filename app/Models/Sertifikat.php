<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';
    protected $fillable = ['user_id', 'judul', 'tipe', 'deskripsi', 'file'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
