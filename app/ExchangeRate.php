<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeRate extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
    	'from_currency','to_currency','value'
    ];
}
