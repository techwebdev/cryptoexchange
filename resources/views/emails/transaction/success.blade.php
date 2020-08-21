@component('mail::message')
# Transaction @if($transaction['rave']->txn_status == "1") {{ __('Success') }} @else {{ __('Failed') }} @endif

Hello {{ $transaction['user']->name }} {{ $transaction['user']->last_name }}

We have received your transaction of {{ $transaction['rave']->currency }} {{ $transaction['rave']->amount }}

### Transaction ID  {{ $transaction['rave']->txn_id }}
### Transaction Reference {{ $transaction['rave']->txn_Ref }}
@if($transaction->from_currency == "BTC")
### Transaction Amount {{ $transaction['rave']->amount }} {{ $transaction['rave']->currency }}
@else
### Transaction Amount {{ $transaction['rave']->amount - ($transaction['rave']->charges === "" ? 0 : $transaction['rave']->charges) }} {{ $transaction['rave']->currency }}
@endif
### Transaction Charge {{ $transaction['rave']->charges === "" ? 0 : $transaction['rave']->charges }} 

@component('mail::button', ['url' => route('home')])
More Info Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
