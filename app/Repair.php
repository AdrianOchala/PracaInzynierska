<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'company_id', 'car_id', 'status','price','description'
    ];
}
