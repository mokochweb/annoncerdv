<?php

namespace App;

use App\Setting;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected static function booted(){

        static::created(function ($user) {
            Setting::create([
                'user_id' => $user->id,
            ]);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'firstname', 'address', 'city', 'zipcode', 'birthday', 'pseudo', 'phone', 'avatar' , 'sexe'
    ];

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

    public function getRouteKeyName()
    {
        return 'pseudo';
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function settings()
    {
        return $this->hasOne(Setting::class);
    }
}
