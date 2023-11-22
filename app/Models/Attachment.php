<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';
    protected $guarded = '';

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }
}
