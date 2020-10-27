<?php

namespace App\Http\Controllers;

use App\Car;
use App\CarBrand;
use App\CarModel;
use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarsController extends Controller
{
    public function getCarsBrandAndModels(){
        $brands = CarBrand::orderBy('name')->get();
        $models = CarModel::orderBy('name')->get();
        return [$brands,$models];
    }
    public function saveCar(Request $request){
        $user_id = Auth::user()->id;
//        \Log::info($user_id);
//        return 'done';
       return Car::create([
            'user_id'=>$user_id,
            'carModel_id'=>$request->model,
            'type'=>$request->type,
            'production'=>$request->production,
            'plate'=>$request->plate,
            'fuel'=>$request->fuel,
            'engine'=>$request->engine,
            'VIN'=>$request->VIN,
           'mileage'=>$request->mileage,
           'transmission'=>$request->transmission,
           'service'=>$request->service,
        ]);
    }
    public function getUserCars(){
        $user_id = Auth::user()->id;
        return Car::with('user','model','model.brand')->where('user_id',$user_id)->get();
    }
    public function deleteUserCar(Request $request){
        return Car::where('id', $request->id)->delete();
    }
    public function editUserCar(Request $request){
        $user_id = Auth::user()->id;
//        \Log::info($user_id);
//        return 'done';
        return Car::where('id',  $request->carId)->update([
            'user_id'=>$user_id,
            'carModel_id'=>$request->model,
            'type'=>$request->type,
            'production'=>$request->production,
            'plate'=>$request->plate,
            'fuel'=>$request->fuel,
            'engine'=>$request->engine,
            'VIN'=>$request->VIN,
            'mileage'=>$request->mileage,
            'transmission'=>$request->transmission,
            'service'=>$request->service,
        ]);
    }
    public function addNote(Request $request){
        $user_id = Auth::user()->id;
        return Note::create([
            'user_id'=>$user_id,
            'car_id'=>$request->car,
            'description'=>$request->description,
            'date'=>$request->date,
        ]);
    }
    public function getUserNotes(){
        $user_id = Auth::user()->id;
        return Note::with('user','car.model','car.model.brand')->where('user_id',$user_id)->get();
    }
    public function editUserNote(Request $request){
        return Note::where('id',$request->id)->update([
            'car_id'=>$request->car,
            'date'=>$request->date,
            'description'=>$request->description
        ]);
    }
    public function deleteUserNote(Request $request){
        return Note::where('id',$request->id)->delete();
    }
}
