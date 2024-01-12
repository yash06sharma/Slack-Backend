<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['chat_id', 'chat_thred_id', 'name', 'path', 'type', 'created_by'];


    public function chat() {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
