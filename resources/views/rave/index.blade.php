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
                    $array = array(array('metaname' => 'color', 'metavalue' => 'blue'),
                            array('metaname' => 'size', 'metavalue' => 'big'));
                    @endphp
                    <form method="POST" action="{{ route('pay') }}" id="paymentForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="amount" value="{{ $amount }}" /> <!-- Replace the value with your transaction amount -->
                        <input type="hidden" name="payment_method" value="account" /> <!-- Can be card, account, both -->
                        <input type="hidden" name="description" value="Beats by Dre. 2017" /> <!-- Replace the value with your transaction description -->
                        <input type="hidden" name="country" value="NG" /> <!-- Replace the value with your transaction country -->
                        <input type="hidden" name="currency" value="{{ $from_currency }}" /> <!-- Replace the value with your transaction currency -->
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}" /> <!-- Replace the value with your customer email -->
                        <input type="hidden" name="firstname" value="{{ Auth::user()->name }}" /> <!-- Replace the value with your customer firstname -->
                        <input type="hidden" name="lastname" value="{{ Auth::user()->last_name }}" /><!-- Replace the value with your customer lastname -->
                        <input type="hidden" name="metadata" value="{{ json_encode($array) }}" > <!-- Meta data that might be needed to be passed to the Rave Payment Gateway -->
                        <input type="hidden" name="phonenumber" value="{{ Auth::user()->mobile }}" /> <!-- Replace the value with your customer phonenumber -->
                        
                        <input type="hidden" name="to_currency" value="{{ $to_currency }}" />
                        <input type="hidden" name="status" value="{{ $status }}" />
                        
                        <input type="submit" value="Proceed" class="btn btn-primary"  />
                        <a href="{{ url()->previous() }}" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection