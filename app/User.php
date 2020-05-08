<?php

namespace App;

use Str;
use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'rfc', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setUserPassword($psw)
    {
        $this->attributes['password'] = Hash::make($psw);
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtoupper($name);
    }

    public function setRFCAttribute($rfc)
    {
        $this->attributes['rfc'] = strtoupper($rfc);
    }

    public function shortName()
    {
        return Str::limit($this->attributes['name'], 13);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
