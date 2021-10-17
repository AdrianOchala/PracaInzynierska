<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function getUserMessages(){
        $userId = Auth::user()->id;
        $myMessages = Message::with(['receiver','sender'])->where('sender_id',$userId)->orWhere('receiver_id',$userId)->orderBy('created_at','desc')->get();

        return $myMessages;
    }
    public function updateMessageView(Request $request){
        \Log::info($request->id);
        return Message::where('id',$request->id)->update(['viewed' => true]);
    }
    public function deleteUserMessage(Request $request){
        return Message::where('id',$request->id)->delete();
    }
    public function archiveUserMessage(Request $request){

        return Message::where('id',$request->id)->update(['archive'=> true]);
    }
    public function sendUserMessage(Request $request){
        $userId = Auth::user()->id;
        return Message::create([
           'sender_id'=> $userId,
            'receiver_id'=>$request->userId,
            'title'=>$request->title,
            'content'=>$request->message,
        ]);
    }
    public function restoreUserMessage(Request $request){
        return Message::where('id',$request->id)->update(['archive'=>false]);
    }
}
