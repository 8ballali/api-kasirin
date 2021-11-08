<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * @var string[]
     */
    protected $fillable = ['name', 'email', 'token', 'fcm_token', 'address', 'gender', 'avatar', 'phone', 'password', 'role_id'];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $appends = [
        'avatar_url',
        'role_name',
        'Subscribers',

    ];



    public function getAvatarUrlAttribute(){
        return url('storage/'. $this->avatar);
    }
    public function getRoleNameAttribute()
    {
        return $this->roles->name;
    }
    public function getSubscribersAttribute()
    {
        return $this->subscriber;
    }
    public function user_store()
    {
        return $this->hasMany(User_Store::class,'user_id', 'id');
    }
    public function subscriber()
    {
        return $this->hasOne(Subscriber::class,'user_id', 'id');
    }

    public function roles()
    {
        return $this->hasOne(Role::class,'id','role_id');
    }

    public function sendPasswordResetNotification($token)
    {

        $url = 'https://spa.test/reset-password?token=' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }


}
