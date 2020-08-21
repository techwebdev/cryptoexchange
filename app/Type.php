<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BankDetail;

class Type extends Model
{
    protected $table = "type";

    /* public function bank_detail(){
        return $this->hasOne(BankDetail::class);
    } */
}
