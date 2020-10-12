<?php

namespace App\Http\Controllers;
use App\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairsController extends Controller
{
    public function getUserRepairs(){
        $user = Auth::user()->id;
        return Repair::with('car.model','car.model.brand','user','company')->where('user_id',$user)->get();
    }
    public function addRepair(Request $request){
        $user = Auth::user()->id;
        return Repair::create([
            'user_id'=>$user,
            'company_id'=>$request->company,
            'car_id'=>$request->car,
            'category'=>$request->subCategory,
            'contact'=>$request->contact,
            'description'=>$request->description,
        ]);
    }
    public function getRepairDetails($id){
        return Repair::with(['user','car','car.model','car.model.brand','company'])->where('id',$id)->first();
    }
}
