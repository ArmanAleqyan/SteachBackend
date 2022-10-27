<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransport extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function UserTransport(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function TransporPhoto(){
        return $this->hasMany(PhotoTransport::class, 'transport_id');
    }

    public function TransportAdditional(){
        return $this->hasMany(AdditionalEquipmentTransport::class, 'transport_id');
    }

    public function texPassport(){
        return $this->HasMany(TexPassportTransport::class, 'transport_id');
    }
}
