@extends('layouts.app')

@section('title') Verify | {{ config('app.name', 'eCurrencyNG') }}  @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.flash')
            <div class="card">
                <div class="card-header">Verify amount</div>
                <form action="{{ route('home.verifyAmount') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="card-body">
                        <p class="text-danger"></p>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" value="" placeholder="Enter Amount" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="type" value="{{ Crypt::decrypt($type) }}">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection