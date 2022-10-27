<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TexPassportTransport extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function texPassport(){
        return $this->belongsTo(UserTransport::class, 'transport_id');
    }
}
