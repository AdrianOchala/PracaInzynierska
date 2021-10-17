<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Company;
use App\CompanySpecialization;
use App\Repair;
use App\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MechanicsController extends Controller
{
    public function getCompanies(){
        return Company::with('user','specialization')->where('active',true)->get();
    }
    public function getSpecializations(){
        return Specialization::get();
    }
    public function getNewMechanics(){
        $company = Company::with(['user','specialization'])->where('active',true)->orderBy('id','desc')->take(4)->get();
        return $company;
    }
    public function getMechanicDetails($id){
        $company = Company::with(['user', 'specialization'])->where('id', $id)->first();
        $comment = Comment::where('company_id',$id)->get();
        $companyRating = 0;
        $commentLength = count($comment);
        if($commentLength > 0){
            for ($i = 0;$i<$commentLength;$i++){
                $companyRating = $companyRating + $comment[$i]->rating;
            }
            $companyRating = round($companyRating/$commentLength,2);
        }
        return [$company,$companyRating];
    }
    public function getOwnerCompany($id){
        $company = Company::with(['user', 'specialization'])->where('user_id', $id)->first();
        $newRepairs = Repair::with(['user','company','car.model','car.model.brand'])->where([['company_id',$company->id],['status','Oczekujące']])->get();
        $inProgressRepairs = Repair::with(['user','company','car.model','car.model.brand'])->where([['company_id',$company->id],['status','W trakcie']])->get();
        $finishedRepairs = Repair::with(['user','company','car.model','car.model.brand'])->where([['company_id',$company->id],['status','Zakończone']])->get();
        $comments = Comment::with(['user','company'])->where('company_id',$company->id)->get();
        return [$company,$newRepairs,$inProgressRepairs,$finishedRepairs,$comments];
    }
    public function updateCompany(Request $request){
        $user_id = Auth::user()->id;

        Company::where('user_id',$user_id)->update([
            'name'=>$request->companyName,
            'NIP'=>$request->NIP,
            'city'=>$request->city,
            'street' => $request->street,
            'zipCode' => $request->zipCode,
            'phones' => $request->companyConvertedPhones,
        ]);
        CompanySpecialization::where('company_id',$request->id)->delete();
        $specs = $request->selectedSpecs;
        $companyspecs=[];
        foreach ($specs as $s) {
            array_push($companyspecs,['company_id'=>$request->id,'specialization_id'=>$s]);
        }
        return CompanySpecialization::insert($companyspecs);
    }
}
