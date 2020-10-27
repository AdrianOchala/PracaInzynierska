<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id','car_id', 'description','date'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function car(){
        return $this->belongsTo('App\Car');
    }
}
