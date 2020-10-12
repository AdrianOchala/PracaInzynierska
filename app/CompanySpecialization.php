<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanySpecialization extends Pivot
{
    public $incrementing = true;
    public $timestamps = false;
}
