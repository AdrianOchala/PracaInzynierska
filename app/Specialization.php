<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable=['name'];
    public $timestamps = false;

    public function companies(){
        return $this->belongsToMany('App\Company');
    }
}
