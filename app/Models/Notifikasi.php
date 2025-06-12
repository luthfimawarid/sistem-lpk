<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi'; // nama tabel yang benar di DB

    protected $fillable = ['user_id', 'judul', 'pesan', 'tipe', 'dibaca'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


