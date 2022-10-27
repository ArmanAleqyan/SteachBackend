<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notification;
use Laravel\Passport\HasApiTokens;
use Symfony\Component\Mailer\Transport;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function RoleId3Reviews(){
        return $this->HasMany(RoleId3Reviews::class, 'receiver_id');
    }

    public function UserTransport(){
        return $this->HasMany(UserTransport::class, 'user_id');
    }

    public function AuthorTender(){
        return $this->hasMany(OrderTender::class, 'sender_id');
    }
    public function ExecuterTender(){
        return $this->hasMany(OrderTender::class, 'receiver_id');
    }

    public function AuthorNotification(){
        return $this->hasMany(Notification::class, 'sender_id');
    }

    public function SenderMessage(){
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function ReceiverMessage(){
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function TenderSenderMessage(){
        return $this->HasMany(TenderMessage::class, 'sender_id');
    }
    public function TenderReceiverMessage(){
        return $this->HasMany(TenderMessage::class, 'receiver_id');
    }

    public function UserHistory(){
        return $this->HasMany(HistoryTransfers::class, 'user_id');
    }


    public function ActiveJobSender(){
        return $this->HasMany(ActiveJob::class, 'sender_id');
    }

    public function ActiveJobReceiver(){
        return $this->HasMany(ActiveJob::class, 'receiver_id');
    }


    public function SenderReview(){
        return $this->hasMany(RoleId3Reviews::class, 'sender_id');
    }

    public function ReceiverReview(){
        return $this->hasMany(RoleId3Reviews::class, 'receiver_id');
    }

    public function SenderInviteHistory(){
        return $this->hasMany(HistoryInvite::class, 'sender_id');
    }

    public function ReceiverInviteHistory(){
        return $this->hasMany(HistoryInvite::class, 'receiver_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
//    protected $hidden = [
//        'password',
//        'remember_token',
//    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];
}
