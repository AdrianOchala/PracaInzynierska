<?php

use App\ChatMessage;
use Illuminate\Database\Seeder;

class ChatMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatMessage::create(['participantId'=>1,'repairId'=>1,'type'=>'text','content'=>'Message 1','timestamp'=>'{"year": 2019, "month": 3, "day": 5, "hour": 20, "minute": 10, "second": 3, "millisecond": 123}','uploaded'=>true,'viewed'=>false]);
        ChatMessage::create(['participantId'=>1,'repairId'=>1,'type'=>'text','content'=>'Message 2','timestamp'=>'{"year": 2019, "month": 3, "day": 5, "hour": 21, "minute": 10, "second": 3, "millisecond": 123}','uploaded'=>true,'viewed'=>false]);
        ChatMessage::create(['participantId'=>9,'repairId'=>1,'type'=>'text','content'=>'Answear','timestamp'=>'{"year": 2019, "month": 3, "day": 5, "hour": 22, "minute": 10, "second": 3, "millisecond": 123}','uploaded'=>true,'viewed'=>false]);
        ChatMessage::create(['participantId'=>1,'repairId'=>1,'type'=>'text','content'=>'Nomanie?','timestamp'=>'{"year": 2019, "month": 3, "day": 5, "hour": 23, "minute": 10, "second": 3, "millisecond": 123}','uploaded'=>true,'viewed'=>false]);
    }

}
