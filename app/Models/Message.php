<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $guarded = false;

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }
}
