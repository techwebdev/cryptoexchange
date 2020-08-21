<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionSuccess;
use App\User;
use App\Transaction;

class ReceiveNewTransaction
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $to = User::where('id',$event->transaction->user_id)->first();
        $transaction = Transaction::where('id',$event->transaction->id)->with('user')->with('rave')->first();
        Mail::to($to->email)->send(new TransactionSuccess($transaction));
    }
}
