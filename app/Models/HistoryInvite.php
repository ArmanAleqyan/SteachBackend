<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryInvite extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function SenderInviteHistory(){
        return $this->belongsto(User::class, 'sender_id');
    }

    public function ReceiverInviteHistory(){
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function TenderNameHistory(){
        return $this->belongsTo(OrderTender::class, 'tender_id');
    }
}
