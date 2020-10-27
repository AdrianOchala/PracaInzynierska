<?php

namespace App\Http\Controllers;

use App\Company;
use App\Specialization;
use Illuminate\Http\Request;
use App\Role;
class TestController extends Controller
{



    public function getSpecializations(){
      return Specialization::get();
    }


}
