<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\BankDetail;
use App\Transaction;
use App\Settings;
use App\Transfer;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','last_name','email', 'password','mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','isVerified','isAttempt'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* public function bank_detail(){
        return $this->hasOne(BankDetail::class);
    } */

    public function bank_detail(){
        return $this->hasMany(BankDetail::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

    public function settings(){
        return $this->hasOne(Settings::class);
    }

    /* public function transfer(){
        return $this->hasOne(Transfer::class);
    } */

    public function transfer(){
        return $this->hasMany(Transfer::class);
    }
}
