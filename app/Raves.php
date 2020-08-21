<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Raves extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'txn_id','txn_Ref','txn_flwRef','txn_status','amount','charges'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
