<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    public function members() {
        return $this->hasMany(CommunityMember::class, 'comunity_id');
    }

    public function channels() {
        return $this->hasMany(Channel::class, 'comunity_id');
    }

      public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
