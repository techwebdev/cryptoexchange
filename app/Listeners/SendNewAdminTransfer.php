<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyAdminTransferSuccess;
use App\Transfer;
use App\User;

class SendNewAdminTransfer
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
        $transfer = Transfer::where('id',$event->transfer->id)->with('transaction')->first();
        Mail::to($to->email)->send(new NotifyAdminTransferSuccess($transfer,$to));
    }
}
