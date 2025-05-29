<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = ['job_matching_id', 'user_id', 'status'];

    public function jobMatching()
    {
        return $this->belongsTo(JobMatching::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

