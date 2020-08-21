@extends('layouts.app')

@section('title') Unspent Bitcoin Transaction | {{ config('app.name', 'eCurrencyNG') }} @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.flash')
            <div class="card">
                <div class="card-header">{{ __('Payment Confirmation') }}</div>
                <div class="card-body">
                    @php session()->forget(['from_currency','to_currency','amount']); @endphp
                	<p class="text text-success">Your BTC Payment has been received, Please wait for 3 BTC Confirmation for your transaction to be automatically processed.</p>
                	<a href="{{ route('home') }}" class="btn btn-primary">Go To Transaction Page</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection