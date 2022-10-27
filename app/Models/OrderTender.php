<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

class OrderTender extends Model
{
    use HasFactory;
    protected  $guarded =[];


    public function Tender(){
        return $this->HasMany(OrderTenderPhoto::class, 'tender_id');
    }

    public function AuthorTender(){
        return $this->belongsto(User::class, 'sender_id');
    }

    public function ExecuterTender(){
        return $this->belongsto(User::class, 'receiver_id');
    }

    public function TenderNotification(){
        return $this->HasMany(Notification::class, 'tender_id');
    }

    public function TenderOrderMessage(){
        return $this->hasMany(TenderMessage::class, 'tender_id');
    }
    public function ActiveJobTender(){
        return $this->HasMany(ActiveJob::class, 'tender_id');
    }

    public function TenderNameHistory(){
        return $this->HasMany(HistoryInvite::class, 'tender_id');
    }
}
