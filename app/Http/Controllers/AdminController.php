<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Company;
use App\Report;
use App\Specialization;
use App\User;
use Illuminate\Http\Request;
use App\Role;
class AdminController extends Controller
{
    public function getUsers(){
        return User::with(['role'])->get();
    }
    public function deleteUser(Request $request){
        return User::where('id',$request->id)->delete();
    }
    public function deactivateUser(Request $request){
        Company::where('user_id',$request->id)->update(['active'=>false]);
        return User::where('id',$request->id)->update(['active'=>false]);
    }
    public function getReports(){
        $comments = Report::with(['user'])->where('type','comment')->get();
        $companies = Report::with(['user'])->where('type','company')->get();
        return [$comments,$companies];
    }
    public function getSingleComment(Request $request){
        return Comment::with(['user','company'])->where('id',$request->id)->get();
    }
    public function deleteComment(Request $request){
        return Comment::where('id',$request->id)->delete();
    }
    public function deleteReport(Request $request){
        return Report::where('id',$request->id)->delete();
    }
}
