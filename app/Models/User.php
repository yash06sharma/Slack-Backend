<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function communities() {
        return $this->hasMany(Community::class, 'created_by');
    }

    public function communityMembers() {
        return $this->hasMany(CommunityMember::class, 'user_id');
    }

    public function channels() {
        return $this->hasMany(Channel::class, 'created_by');
    }

    public function channelMembers() {
        return $this->hasMany(ChannelMember::class, 'user_id');
    }

    public function chats() {
        return $this->hasMany(Chat::class, 'created_by');
    }

    public function chatAttachments() {
        return $this->hasMany(ChatAttachment::class, 'created_by');
    }

      public function chatThread() {
        return $this->hasMany(ChatThread::class, 'created_by');
    }

}
