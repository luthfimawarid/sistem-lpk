<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'nama_lengkap',
        'email',
        'password',
        'role',
        'kelas',
        'tanggal_lahir',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function TugasUser()
    {
        return $this->hasMany(TugasUser::class);
    }

    public function dokumen() {
        return $this->hasMany(DokumenSiswa::class);
    }

        public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'user_id');
    }

    public function chatRooms() {
        return $this->belongsToMany(ChatRoom::class, 'chat_room_user');
    }

}
