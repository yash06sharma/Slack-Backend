<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAttachment extends Model
{
    use HasFactory;
    public function chat() {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}