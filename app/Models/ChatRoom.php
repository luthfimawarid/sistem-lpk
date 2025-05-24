<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model {
    protected $fillable = ['name', 'type'];

    public function users() {
        return $this->belongsToMany(User::class, 'chat_room_user');
    }

    public function messages() {
        return $this->hasMany(ChatMessage::class);
    }
}
