@extends('admin.layouts.layout')

@section('title') Currency | Crypto Exchange @endsection

@section('content')
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		@include('admin.includes.flash')
		<div class="card">
			<div class="card-header">
				<h5>Edit Currency</h5>
				<span></span>
			</div>
			<form action="{{ route('admin.currency.update',$data->id) }}" method="POST" name="currencyForm" id="currencyForm">
				@method('PUT')
				@csrf
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<div class="form-group">
							<label>Name</label>
							<select class="form-control" name="name" required>
								<option value="">-Select Currency--</option>
								<option value="naira" @if(strtolower($data->name) == "ngn") {{ __('selected') }} @endif>Nagiria
								</option>
								<option value="pm" @if(strtolower($data->name) == "pm") {{ __('selected') }} @endif>PM</option>
								<option value="btc" @if(strtolower($data->name) == "btc") {{ __('selected') }} @endif>BTC</option>
							</select>
						</div>
					</div>
					<div class="col-md-1"></div>
				</div>
				<!-- <div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<div class="form-group">
							<label>Value</label>
							<input type="text" name="value" class="form-control" value="{{ $data->value }}"
								placeholder="Enter the value" required>
						</div>
					</div>
					<div class="col-md-1"></div>
				</div> -->
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