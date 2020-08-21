<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransferSuccess;
use App\Transfer;
use App\User;

class SendNewTransfer
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $to = User::where('id',$event->transfer->user_id)->first();
        $transfer = Transfer::where('id',$event->transfer->id)->with('transaction')->first();
        Mail::to($to->email)->send(new TransferSuccess($transfer,$to));
    }
}
