@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	{{ __('Bitcoin Details Form') }}
                	<br>
                	<span class="text-danger">Note: This information is not for storing purpose</span>
                </div>
                <div class="card-body">
                	<form method="POST" action="{{ route('btc') }}" id="btcForm">
						{{ csrf_field() }}
						<div class="row">
                			<div class="col-md-12">
                				<div class="form-group">
                					<label for="bitcoin_wallet">Bitcoin Wallet Id <span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="bitcoin_wallet" placeholder="Enter bitcoin address">
                				</div>
                			</div>
                		</div>
                		<div class="row">
                			<div class="col-md-12">
                				<div class="form-group">
                					<label for="bitcoin_address">Bitcoin Address Id <span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="bitcoin_address" placeholder="Enter bitcoin address">
                				</div>
                			</div>
                		</div>

                		<div class="row">
                			<div class="col-md-12">
                				<div class="form-group">
                					<label for="bitcoin_password">Bitcoin Password <span class="text-danger">*</span></label>
                					<input type="password" name="bitcoin_password" class="form-control" placeholder="Enter bitcoin main password">
                				</div>
                			</div>
                		</div>

                		<div class="row">
                			<div class="col-md-12">
                				<div class="form-group">
                					<label for="bitcoin_second_password">Bitcoin Second Password</label>
                					<input type="text" name="bitcoin_second_password" class="form-control" placeholder="Enter bitcoin second password(optional)">
                				</div>
                			</div>
                		</div>

                		<div class="row">
                			<div class="col-md-12">
                				<div class="form-group">
                					<input type="hidden" name="amount" value="{{ $amount }}">
                					<input type="hidden" name="to_address" value="{{ $to_address }}">
                					<input type="submit" name="submit" value="Submit" class="btn btn-primary">
                				</div>
                			</div>
                		</div>

                	</form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection