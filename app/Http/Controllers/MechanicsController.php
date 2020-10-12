<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanySpecialization;
use App\Specialization;
use Illuminate\Http\Request;

class MechanicsController extends Controller
{
    public function getNewMechanics(){
        $company = Company::with(['user','specialization'])->orderBy('id','desc')->take(5)->get();
        return $company;
    }
    public function getMechanicDetails($id){
        $company = Company::with(['user', 'specialization'])->where('id', $id)->first();
        return $company;
    }
}
