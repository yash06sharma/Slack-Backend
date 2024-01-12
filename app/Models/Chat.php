<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = ['channel_id', 'receiver_id', 'message', 'created_by'];


    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function sender() {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function attachments() {
        return $this->hasMany(ChatAttachment::class, 'chat_id');
    }

    public function threads() {
        return $this->hasMany(ChatThread::class, 'chat_id');
    }

   public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
