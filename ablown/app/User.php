<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'link', 'about', 'cars', 'food', 'math', 'animals', 'books',
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

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function topics(){
        return $this->hasMany('App\Topic');
    }

    public function replies(){
        return $this->hasMany('App\Reply');
    }

    public function link(){
        return $this->belongsTo('App\User');
    }

    public function links(){
        return $this->hasMany('App\User');
    }

    public function courses(){
        return $this->hasMany('App\Course');
    }

    public function submissions(){
        return $this->hasMany('App\Submission');
    }
}
