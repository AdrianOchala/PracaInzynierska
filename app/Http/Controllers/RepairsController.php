<?php

namespace App\Http\Controllers;
use App\ChatMessage;
use App\Message;
use App\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairsController extends Controller
{
    public function getUserRepairs(){
        $user = Auth::user()->id;
        $waiting = Repair::with('car.model','car.model.brand','user','company')->where([['user_id',$user],['status','Oczekujące']])->get();
        $waitingCommentDate = [];
        if(isset($waiting[0])){
            $commentWaitingLength = count($waiting);
            for ($i = 0;$i<$commentWaitingLength;$i++){
                $waitingCommentDate[$i] = $waiting[$i]->created_at->format('Y/m/d H:m:s');
            }
        }

        $inProgress = Repair::with('car.model','car.model.brand','user','company')->where([['user_id',$user],['status','W trakcie']])->get();
        $inProgressCommentDate = [];
        if(isset($inProgress[0])){
            $commentInProgressLength = count($inProgress);
            for ($i = 0;$i<$commentInProgressLength;$i++){
                $inProgressCommentDate[$i] = $inProgress[$i]->created_at->format('Y/m/d H:m:s');
            }
        }

        $finished = Repair::with('car.model','car.model.brand','user','company')->where([['user_id',$user],['status','Zakończone']])->get();
        $finishedCommentDate = [];
        if(isset($finished[0])){
            $commentFinishedLength = count($waiting);
            for ($i = 0;$i<$commentFinishedLength;$i++){
                $finishedCommentDate[$i] = $finished[$i]->updated_at->format('Y/m/d H:m:s');
            }
        }
        return [$waiting,$waitingCommentDate,$inProgress,$inProgressCommentDate,$finished,$finishedCommentDate];
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
        return Repair::with(['user','car','car.model','car.model.brand','company','company.user'])->where('id',$id)->first();
    }
    public function getRepairMessages($id){
        return ChatMessage::where('repairId',$id)->get();
    }
    public function acceptRepair(Request $request){
        return Repair::where('id',$request->id)->update([
            'companyReply'=>$request->companyReply,
            'price'=>$request->price,
            'status'=>'W trakcie',
        ]);
    }
    public function rejectRepair(Request $request){
        return Repair::where('id',$request->id)->update([
            'companyReply'=>$request->companyReply,
            'price'=>$request->price,
            'status'=>'Zakończone',
        ]);
    }
    public function addMessage(Request $request)
    {
        return ChatMessage::create([
            'participantId'=>$request->participantId,
            'repairId'=>$request->repairId,
            'type'=>'text',
            'content'=>$request->message,
            'timestamp'=>$request->timestamp,
            'uploaded'=>true,
            'viewed'=>false,
        ]);
    }
}
