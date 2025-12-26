<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

    public function cities()
    {
        return $this->hasMany(City::class)->withTrashed();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->withTimestamps();
    }

    public function friendsWith(User $user)
    {
        return !is_null($this->friends()->find($user->id));
    }

    public function addFriend(User $user)
    {
        if ($this->id === $user->id) {
            return false;
        }

        if ($this->friendsWith($user)) {
            return false;
        }

        $this->friends()->attach($user->id);
        $user->friends()->attach($this->id);

        return true;
    }

    public function removeFriend(User $user)
    {
        $this->friends()->detach($user->id);
        $user->friends()->detach($this->id);

        return true;
    }
}
