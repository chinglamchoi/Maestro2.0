<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    public $primaryKey = 'id';
    public $timestamps = true;
    public function submission(){
        return $this->belongsTo('App\Submission');
    }
    public function question(){
        return $this->belongsTo('App\Question');
    }
}
