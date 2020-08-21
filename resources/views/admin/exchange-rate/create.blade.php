@extends('admin.layouts.layout')

@section('title') Currency | {{ config('app.name', 'eCurrencyNG') }} @endsection

@section('content')
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		<div class="card">
			<div class="card-header">
				<h5>Add New Rate</h5>
				<span></span>
			</div>
			<form action="{{ route('admin.exchange-rate.store') }}" method="POST" name="currencyForm" id="currencyForm">
				@method('POST')
				@csrf
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<div class="form-group">
							<label>From Currency</label>
							<select class="form-control" name="from_currency">
								<option value="">-Select Currency--</option>
								<option value="ngn">Nigeria</option>
								<option value="pm">PM</option>
								<option value="btc">BTC</option>
							</select>
							@if ($errors->has('from_currency'))
						    	<span class="error">{{ $errors->first('from_currency') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-1"></div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<div class="form-group">
							<label>To Currency</label>
							<select class="form-control" name="to_currency">
								<option value="">-Select Currency--</option>
								<option value="ngn">Nigeria</option>
								<option value="pm">PM</option>
								<option value="btc">BTC</option>
							</select>
							@if ($errors->has('to_currency'))
						    	<span class="error">{{ $errors->first('to_currency') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-1"></div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<div class="form-group">
							<label>Amount</label>
							<input type="text" name="amount" class="form-control" placeholder="Enter the amount">
							@if ($errors->has('Amount'))
						    	<span class="error">{{ $errors->first('Amount') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-1"></div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<input type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm">
					</div>
					<div class="col-md-1"></div>
				</div>
				<br>
			</form>
		</div>
	</div>
</div>
@endsection