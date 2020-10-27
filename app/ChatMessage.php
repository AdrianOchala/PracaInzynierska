<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'participantId', 'repairId','type','content','timestamp','uploaded','viewed'
    ];
    public $timestamps = false;
}
