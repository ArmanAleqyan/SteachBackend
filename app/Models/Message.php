<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function SenderMessage(){
        return $this->belongsto(User::class, 'sender_id');
    }
    public function ReceiverMessage(){
        return $this->belongsto(User::class, 'receiver_id');
    }
}
