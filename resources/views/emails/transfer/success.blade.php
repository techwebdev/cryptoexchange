@component('mail::message')
# Transfer @if($transfer['transaction']->status == 1) {{ __('Success') }} @else {{ __('Failed') }} @endif

Hello {{ $user->name }} {{ $user->last_name }}

We have send you transfer of {{ $transfer['transaction']->to_currency }} {{ $transfer->amount }}

### Credit Account {{ $transfer->craccount }}
### Transfer ID  {{ $transfer->id }}
### Transfer Reference {{ $transfer->ref_no }} 
### Transfer Amount {{ $transfer->amount }} {{ $transfer['transaction']->to_currency }}

@component('mail::button', ['url' => route('home')])
More Info Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
