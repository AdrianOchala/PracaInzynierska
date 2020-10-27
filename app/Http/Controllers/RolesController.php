<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function addRole(Request $request){
        $this->validate($request,[
            'name'=>'required|min:3|max:20|unique:roles',
        ]);
        return  Role::create([
            'name' => $request->name
        ]);
    }
    public function getRole(){
        return Role::orderBy('id','desc')->get();
    }
    public function editRole(Request $request){
        $this->validate($request,[
            'name'=>'required|min:3|max:20',
        ]);
        return  Role::where('id',  $request->id)->update([
            'name'=>$request->name
        ]);
    }
    public function deleteRole(Request $request){
        return Role::where('id', $request->id)->delete();
    }
    public function assignPermissions(Request $request){
        $this->validate($request,[
            'permission'=>'required',
            'id' => 'required',
        ]);
        return  Role::where('id',$request->id)->update([
            'permission' => $request->permission
        ]);
    }
}
