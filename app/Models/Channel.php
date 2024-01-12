<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    public function community() {
        return $this->belongsTo(Community::class, 'comunity_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members() {
        return $this->hasMany(ChannelMember::class, 'channel_id');
    }

    public function chats() {
        return $this->hasMany(Chat::class, 'channel_id');
    }
}