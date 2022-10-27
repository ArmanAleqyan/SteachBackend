<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected  $guarded =[];

    const ADMIN_ID = 1;
    const Customer = 2;
    const Executor =3;


    public function user_role_id(){
        return $this->hasMany(User::class, 'role_id');
    }
}
