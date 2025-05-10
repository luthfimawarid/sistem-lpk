<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasUser extends Model
{
    use HasFactory;

    protected $table = 'tugas_user';

    protected $fillable = [
        'tugas_id',
        'user_id',
        'status',
    ];

    // Relasi ke model Tugas
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
