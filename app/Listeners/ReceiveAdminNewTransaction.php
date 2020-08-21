<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyAdminTransactionSuccess;
use App\User;
use App\Transaction;

class ReceiveAdminNewTransaction
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $to = User::where('is_admin','1')->first();
        $transaction = Transaction::where('id',$event->transaction->id)->with('user')->with('rave')->first();
        Mail::to($to->email)->send(new NotifyAdminTransactionSuccess($transaction));
    }
}
