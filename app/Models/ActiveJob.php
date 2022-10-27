<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveJob extends Model
{
    use HasFactory;
    protected  $guarded = [];

    public function ActiveJobSender(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function ActiveJobReceiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function ActiveJobTender(){
        return $this->belongsTo(OrderTender::class, 'tender_id');
    }

    public function ActiveJobHistory(){
        return $this->hasOne(HistoryTransfers::class, 'job_id');
    }
}
