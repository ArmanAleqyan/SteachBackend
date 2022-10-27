<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderMessage extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function TenderSenderMessage(){
        return $this->belongsto(User::class, 'sender_id');
    }
    public function TenderReceiverMessage(){
        return $this->belongsto(User::class, 'receiver_id');
    }
    public function TenderOrderMessage(){
        return $this->belongsto(OrderTender::class, 'tender_id');
    }
}
