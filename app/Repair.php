<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'company_id', 'car_id','user_id', 'status','price','description','companyReply','contact','category'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function company(){
        return $this->belongsTo('App\Company');
    }
    public function car(){
        return $this->belongsTo('App\Car');
    }
}
