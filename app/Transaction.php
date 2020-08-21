<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Raves;
use App\Transfer;

class Transaction extends Model 
{
    use SoftDeletes;

    protected $fillable = [
        'amount','from_currency','to_currency','status'
    ];

    protected $hidden = [
        'user_id','rave_id'
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function rave(){
        return $this->belongsTo(Raves::class);   
    }

    public function transfer(){
        return $this->belongsTo(Transfer::class);    
    }
}
