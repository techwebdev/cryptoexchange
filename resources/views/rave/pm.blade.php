@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.flash')
            <div class="card">
                <div class="card-header">{{ __('Payment Confirmation') }}</div>
                <div class="card-body">
                    @if(isset($success))
                        <p class="text text-success">{{ $success }}</p>
                        @php session()->forget(['from_currency','to_currency','amount']); @endphp
                        <a href="{{ url('/') }}" class="btn btn-primary">Home</a>
                    @elseif(isset($error))
                        <p class="text text-danger">{{ $error }}</p>
                        @php session()->forget(['from_currency','to_currency','amount']); @endphp
                        <a href="{{ url('/') }}" class="btn btn-primary">Home</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection