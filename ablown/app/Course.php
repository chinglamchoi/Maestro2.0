<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    public $primaryKey = 'id';
    public $timestamps = true;
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function questions(){
        return $this->hasMany('App\Question');
    }
    public function submissions(){
        return $this->hasMany('App\Submission');
    }
}
