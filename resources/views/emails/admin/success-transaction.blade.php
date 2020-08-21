@component('mail::message')
# Transaction @if($transaction['rave']->txn_status == "1") {{ __('Success') }} @else {{ __('Failed') }} @endif

Transaction Received From {{ $transaction['user']->name }} {{ $transaction['user']->last_name }}

User Email Address {{ $transaction['user']->email }}

We are received new transaction of {{ $transaction['rave']->currency }} {{ $transaction['rave']->amount }}

### Transaction Reference {{ $transaction['rave']->txn_Ref }} 
@if($transaction->from_currency == "BTC")
### Credited Amount {{ $transaction['rave']->amount }} {{ $transaction['rave']->currency }}
@else
### Credited Amount {{ $transaction['rave']->amount - ($transaction['rave']->charges === "" ? 0 : $transaction['rave']->charges) }} {{ $transaction['rave']->currency }}
@endif
### Transaction Charge {{ $transaction['rave']->charges }} 

@component('mail::button', ['url' => route('home')])
More Info Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
