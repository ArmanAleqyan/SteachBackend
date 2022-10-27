<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoTransport extends Model
{
    use HasFactory;
    protected  $guarded =[];

    public function TransporPhoto(){
        return $this->BelongTo(UserTransport::class, 'transport_id');
    }
}
