@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Account Verfication') }}</div>
                <div class="card-body">
                    <form name="pmVerification" action="{{ route('ngnAlert') }}" method="POST">
                    	@csrf
                    	<p>Account Name:-<b>{{$account_name}}</b></p>
                    	<p>Are You sure want to procced.?</p>
                    	<input type="hidden" name="account_name" value="{{ $account_name }}">
                    	<input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="bank_name" value="{{ $bank_name }}">
                        <input type="hidden" name="bank_code" value="{{ $bank_code }}">
                    	<input type="hidden" name="account_no" value="{{ $account_no }}">
                        <input type="hidden" name="type" value="{{ $type }}">
                    	<input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    	<a href="{{ url('profile/'.Crypt::encrypt($type)) }}" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection