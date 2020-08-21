@extends('admin.layouts.layout')

@section('title') Currency | Crypto Exchange @endsection

@section('content')
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		@include('admin.includes.flash')
		<div class="card">
			<div class="card-header">
				<h5>Add New Currency</h5>
				<span></span>
			</div>
			<form action="{{ route('admin.currency.store') }}" method="POST" name="currencyForm" id="currencyForm">
				@method('POST')
				@csrf
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<div class="form-group">
							<label>Name</label>
							<select class="form-control" name="name">
								<option value="">-Select Currency--</option>
								<option value="ngn">Nigiria</option>
								<option value="pm">PM</option>
								<option value="btc">BTC</option>
							</select>
						</div>
					</div>
					<div class="col-md-1"></div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<div class="form-group">
							<label>Value</label>
							<input type="text" name="value" class="form-control" placeholder="Enter the value">
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