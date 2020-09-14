<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySpec extends Model
{
    public $timestamps = false;
    protected $fillable = [
    'company_id', 'specialization_id'
];
}
