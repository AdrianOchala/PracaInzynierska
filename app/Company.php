<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'owner_id', 'name', 'NIP','location','city','street','zip-code','phones'
    ];
    public $timestamps = false;
    public function specialization(){
        return $this->belongsToMany('App\Specialization', 'company_specs');
    }
}
