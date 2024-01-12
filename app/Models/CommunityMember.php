<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityMember extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'community_id', 'role', 'status'];


    public function community() {
        return $this->belongsTo(Community::class, 'comunity_id');
    }
     public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
