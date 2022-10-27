<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleId3Reviews extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function SenderReview(){
        return $this->BelongsTo(User::class, 'sender_id');
    }

    public function ReceiverReview(){
        return $this->BelongsTo(User::class, 'receiver_id');
    }

  
}
