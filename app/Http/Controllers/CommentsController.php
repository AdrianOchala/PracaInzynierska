<?php

namespace App\Http\Controllers;

use App\Comment;
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
    public function getMechanicComments($id){
        $comment = Comment::with(['user','company'])->where('company_id',$id)->get();

        $commentDate = [];
        $companyRating = 0;
        $commentLength = count($comment);
        for ($i = 0;$i<$commentLength;$i++){
            $commentDate[$i] = $comment[$i]->created_at->format('Y/m/d');
            $companyRating = $companyRating + $comment[$i]->rating;
        }
        $companyRating = round($companyRating/$commentLength,2);
        return [$comment,$commentDate,$companyRating];
    }
    public function reportComment(Request $request){
        $user_id = Auth::user()->id;
        $isReported = Report::where([
            ['user_id',$user_id],
            ['type','comment'],
            ['target_id',$request->comment_id],
        ])->get();
        \Log::info($isReported);
        $howMany = count($isReported);
        if($howMany > 0){
            return response()->json([
                'msg' => 'Już zgłosiłeś ten komentarz!',
            ], 401);
        }else{
            return Report::create([
                'user_id' =>$user_id,
                'type'=>'comment',
                'target_id'=>$request->comment_id,
            ]);
        }
    }
}
