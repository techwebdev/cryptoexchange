@component('mail::message')
# Transfer @if($transfer['transaction']->status == 1) {{ __('Success') }} @else {{ __('Failed') }} @endif

Hello {{ $user->name }} {{ $user->last_name }}

We send a new transfer {{ $transfer['transaction']->to_currency }} {{ $transfer->amount }} of transaction {{ $transfer['transaction']->from_currency }} {{ $transfer['transaction']->amount }}

### Credited Account {{ $transfer->craccount }}
### Debited Account {{ $transfer->draccount }}
### Transfer ID  {{ $transfer->id }}
### Transfer Reference {{ $transfer->ref_no }} 
### Debited Amount {{ $transfer->amount }} {{ $transfer['transaction']->to_currency }}

@component('mail::button', ['url' => route('home')])
More Info Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
