<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ["Hits"];
    //protected $guarded = [];
    //블랙리스트 지정시 해당 컬럼 이외에 배열로 할당 가능

    public function member(){
      return $this->belongsTo('App\Member');
    }

    public function comment(){
      return $this->hasMany('App\Comment');
    }
}
