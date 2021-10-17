<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Company;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function addComment(Request $request){

        Comment::create([
            'user_id' => $request->userId,
            'company_id' =>$request->companyId,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);
        return 'done';
    }
    public function getMechanicComments($id,Request $request){
        \Log::info($request);
        $comment = Comment::with(['user','company'])->where('company_id',$id)->orderBy('created_at','desc')->paginate($request->total);

        $commentDate = [];
        $commentLength = count($comment);
        if($commentLength > 0){
            for ($i = 0;$i<$commentLength;$i++){
                $commentDate[$i] = $comment[$i]->created_at->format('Y/m/d');
            }
        }
        return [$comment,$commentDate];
    }

    public function bestCompanies(){
        $companies = Company::all();
        $numberOfCompanies = count($companies);
        if($numberOfCompanies > 0){
            for($i = 0;$i<$numberOfCompanies;$i++){
                $id = $i + 1;
                $comments = Comment::with(['user','company'])->where('company_id',$id)->get();
                $commentLength = count($comments);
                $companyRating = 0;
                if($commentLength > 0) {
                    for ($k = 0; $k < $commentLength; $k++) {
                        $companyRating = $companyRating + $comments[$k]->rating;
                    }
                    $companyRating = round($companyRating / $commentLength, 2);
                    $companyRatings[$id]=$companyRating;
                }else{
                    $companyRatings[$id]=$companyRating;
                }
            }
        }
        arsort($companyRatings);
        $bestFiveCompanies = array_slice($companyRatings,0,4,true);
        $arrayKlucze = array_keys($bestFiveCompanies);
        $bestCompanies[0] = Company::with(['user','specialization'])->where('id',$arrayKlucze[0])->first();
        $bestCompanies[1] = Company::with(['user','specialization'])->where('id',$arrayKlucze[1])->first();
        $bestCompanies[2] = Company::with(['user','specialization'])->where('id',$arrayKlucze[2])->first();
        $bestCompanies[3] = Company::with(['user','specialization'])->where('id',$arrayKlucze[3])->first();
        return $bestCompanies;
    }
    public function reportComment(Request $request){
        $user_id = Auth::user()->id;
        $isReported = Report::where([
            ['user_id',$user_id],
            ['type','comment'],
            ['target_id',$request->index],
        ])->get();
        $howMany = count($isReported);
        if($howMany > 0){
            return response()->json([
                'msg' => 'Już zgłosiłeś ten komentarz!',
            ], 401);
        }else{
            return Report::create([
                'user_id' =>$user_id,
                'type'=>'comment',
                'target_id'=>$request->index,
                'reason'=>$request->reason,
            ]);
        }
    }
    public function reportCompany(Request $request){
        $user_id = Auth::user()->id;
        $isReported = Report::where([
            ['user_id',$user_id],
            ['type','company'],
            ['target_id',$request->index],
        ])->get();
        \Log::info($isReported);
        $howMany = count($isReported);
        if($howMany > 0){
            return response()->json([
                'msg' => 'Już zgłosiłeś ten warsztat!',
            ], 401);
        }else{
            return Report::create([
                'user_id' =>$user_id,
                'type'=>'company',
                'target_id'=>$request->index,
                'reason'=>$request->reason,
            ]);
        }
    }
    public function getLastComments(){
        $comments = Comment::with(['user','company'])->orderBy('created_at','desc')->take(4)->get();
        $commentDate = [];
        $commentLength = count($comments);
        if($commentLength > 0){
            for ($i = 0;$i<$commentLength;$i++){
                $commentDate[$i] = $comments[$i]->created_at->format('Y/m/d');
            }
        }
        return [$comments,$commentDate];
    }
};
