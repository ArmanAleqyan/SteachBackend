<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalEquipmentTransport extends Model
{
    use HasFactory;
    protected $guarded =[];


    public function TransportAdditional(){
        return $this->belongsTo(UserTransport::class, 'transport_id');
    }

}
