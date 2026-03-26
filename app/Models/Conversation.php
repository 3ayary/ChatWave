<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [];

    public function members()
    {
        return $this->belongsToMany(User::class)->withPivot('last_read_at');
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }
}
