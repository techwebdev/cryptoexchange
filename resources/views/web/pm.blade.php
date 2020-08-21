@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Transaction Alert') }}</div>
                <div class="card-body">
                	<p>Are You sure want to procced.?</p>
                	@php
                	$number = 'ecurrency'.\Str::random(20);
                	$admin = App\User::where('is_admin','1')->first();
                	@endphp
					<form action="https://perfectmoney.is/api/step1.asp" method="POST">
				        <p>
				          <input type="hidden" name="PAYEE_ACCOUNT" value="{{ $payee_account }}" />
				          <input type="hidden" name="PAYEE_NAME" value="{{ $payee_name }}" />
				          <input type="hidden" name="PAYMENT_AMOUNT" value="{{ $amount }}" />
				          <input type="hidden" name="PAYMENT_UNITS" value="USD" />
				          <input type="hidden" name="STATUS_URL" value="mailto:{{ $admin->email }}"/>
				          {{-- <input type="hidden" name="STATUS_URL" value="{{ url('/pmSuccess') }}"/> --}}
				          <input type="hidden" name="PAYMENT_URL" value="{{ url('/pmSuccess/'.$number) }}"/>
				          <input type="hidden" name="PAYMENT_URL_METHOD" value="GET" />
				          <input type="hidden" name="NOPAYMENT_URL" value="{{ url('/pmCancel') }}"/>
				          <input type="hidden" name="NOPAYMENT_URL_METHOD" value="GET" />
				          <input type="hidden" name="PAYMENT_ID" value="{{ $number }}"/>
				          <input type="hidden" name="SUGGESTED_MEMO" value="{{ $number }}">
				          <input type="hidden" name="SUGGESTED_MEMO_NOCHANGE" value="1">
				          <input type="submit" class="btn btn-primary" name="PAYMENT_METHOD" value="Procced"/>
				          <a href="{{ url('/') }}" name="cancel" class="btn btn-default">Cancel</a>
				        </p>
				    </form>
			  	</div>
			</div>
		</div>
	</div>
</div>
@endsection