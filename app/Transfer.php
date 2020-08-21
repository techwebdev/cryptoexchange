<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;
use App\User;

class Transfer extends Model
{
    public function transaction(){
    	return $this->belongsTo(Transaction::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
    
}
