<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submissions';
    public $primaryKey = 'id';
    public $timestamps = true;
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function course(){
        return $this->belongsTo('App\Course');
    }
    public function answers(){
        return $this->hasMany('App\Answer');
    }
}
