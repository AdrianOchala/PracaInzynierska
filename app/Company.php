<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'user_id', 'name', 'NIP','location','city','street','zipCode','phones','description','hours','active'
    ];
    public $timestamps = false;
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function specialization(){
        return $this->belongsToMany('App\Specialization','company_specialization');
    }
}
