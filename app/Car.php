<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'user_id','carModel_id', 'type', 'production','plate','fuel','engine','VIN','transmission','mileage','service'
    ];
    public $timestamps=false;
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function model(){
        return $this->belongsTo('App\CarModel','carModel_id');
    }
}
