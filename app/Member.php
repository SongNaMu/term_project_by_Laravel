<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    public $timestamps = false;

    public $incrementing = false;

    public function board(){
      return $this->hasMany('App\Board');
    }

    public function comment(){
      return $this->hasMany('App\Comment');
    }
}
