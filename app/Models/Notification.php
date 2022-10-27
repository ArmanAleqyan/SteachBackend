<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function AuthorNotification(){
        return $this->belongsto(User::class, 'sender_id');
    }

    public function TenderNotification(){
        return $this->belongsto(OrderTender::class, 'tender_id');
    }

}
