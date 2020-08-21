@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	{{ __('Transaction Alert') }}
                </div>
                <div class="card-body">
                	<p>Are you sure want to proceed?</p>
                	<form method="POST" action="{{ route('btc') }}" id="btcForm">
                		@method('POST')
                		@csrf
                		<input type="hidden" name="amount" value="{{ $amount }}">
                        <input type="submit" name="submit" value="Proceed" class="btn btn-primary">
                        <a class="btn btn-default" href="{{ url('/') }}">Cancel</a>
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection