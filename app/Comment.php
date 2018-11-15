<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public $timestamps = false;

    public function member(){
      return $this->belongsTo('App\Member');
    }

    public function board(){
      return $this->belongsTo('App\Board');
    }
}
