<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatThread extends Model
{
    use HasFactory;
    protected $fillable = ['chat_id', 'message', 'created_by'];


    public function chat() {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
