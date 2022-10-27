<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTransfers extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function UserHistory(){
        return $this->Belongsto(User::class, 'user_id');
    }

    public function ActiveJobHistory(){
        return $this->BelongsTo(ActiveJob::class, 'job_id');
    }
}
