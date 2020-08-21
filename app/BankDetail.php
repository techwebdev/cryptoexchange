<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Type;
use Auth;

class BankDetail extends Model
{
    protected $table = "bank_details";

    public function user(){
        return $this->belongsTo(User::class);
    }

    /* public function type(){
        return $this->belongsTo(Type::class);
    } */
}
