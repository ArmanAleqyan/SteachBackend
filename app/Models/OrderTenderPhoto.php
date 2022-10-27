<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTenderPhoto extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function Tender(){
        return $this->belongsto(OrderTender::class, 'tender_id');
    }
}
