<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    public $timestamps = false;
    public function model(){
        return $this->hasMany('App\CarModel');
    }
}
