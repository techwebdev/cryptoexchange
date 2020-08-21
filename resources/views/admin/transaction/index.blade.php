@extends('admin.layouts.layout')

@section('title') Transaction | {{ config('app.name', 'eCurrencyNG') }} @endsection

@section('content')
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		@include('admin.includes.flash')
		<div class="card">
			<div class="card-header">
				<h5>Transaction List</h5>
				<span></span>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive">
					<!-- <a href="{{ route('admin.transaction.create') }}" class="btn btn-primary btn-sm pull-right">Add New<i
							class="ti-plus"></i></a> -->
					<table id="transactionTable" class="table table-striped table-bordered nowrap">
						<thead>
							<tr>
								<th>Sr No.</th>
								<th>Name</th>
								<th>Amount</th>
								<th>Transfer</th>
								<th>Txn Status</th>
								<th>Transfer Status</th>
								<th>Created At</th>
								<th>Info</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($data) && count($data) > 0)
								@foreach($data as $key=>$val)
									@if($val['rave']->txn_status == "1")
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $val["user"]->name }}</td>
										<td>
										    @if($val->amount == "")
										        @if($val->from_currency == "BTC")
										            {{ 0 ."  ".$val->from_currency }}
										        @else
										            {{ 0 -  ($val["rave"]->charges === "" ? 0 : $val["rave"]->charges)."  ".$val->from_currency  }}
										        @endif
										    @else 
										        @if($val->from_currency == "BTC")
										            {{ $val->amount."  ".$val->from_currency }}
										        @else
										            {{ $val->amount - ($val["rave"]->charges === "" ? 0 : $val["rave"]->charges)."  ".$val->from_currency }}
										        @endif
										    @endif
										</td>
										<!--<td>{{ ($val->amount === "" ?? 0) - ($val["rave"]->charges === "" ?? 0 )." ".$val->from_currency }}</td>-->
										<td>{{ $val->transferAmount }} {{ $val->to_currency }}</td>
										<td>
											@if($val["rave"]->txn_status == "1") 
											<span class="label label-success">{{ __('Success') }}</span> 
											@else 
											<span class="label label-warning">{{ __('Pending') }}</span>
											@endif
										</td>
										<td>
											@csrf
											@if($val->status == "0")
												<span class="label label-warning">{{ __('Pending') }}</span>
												<!-- <button type="button" name="status" id="status" class="btn btn-warning btn-sm" data-id={{ $val->id }} data-value="{{ $val->status }}"><i class="ti-info"></i>{{ __('Pending') }}</button> -->
											@elseif($val->status == "1")
												<span class="label label-success">{{ __('Success') }}</span>
												<!-- <button type="button" name="status" id="status" class="btn btn-success btn-sm" data-id={{ $val->id }} data-value="{{ $val->status }}"><i class="ti-check"></i>{{ __('Success') }}</button> -->
											@else
												<span class="label label-danger">{{ __('Reject') }}</span>
												<!-- <button type="button" name="status" id="status" class="btn btn-danger btn-sm" data-id={{ $val->id }}  data-value="{{ $val->status }}"><i class="ti-close"></i>{{ __('Reject') }}</button> -->
											@endif
										</td>
										<td>{{ Carbon::parse($val->created_at)->format('Y-m-d h:i A') }}</td>
										<td>
											<span class="label label-danger" data-toggle="modal" data-target="#myModal{{$val->id}}"><i class="ti ti-info"></i></span>
											<div class="modal fade" id="myModal{{$val->id}}" role="dialog">
											    <div class="modal-dialog modal-lg">
											      <!-- Modal content-->
											      <div class="modal-content">
											        <div class="modal-header">
											        	<h4 class="modal-title">Transaction Info</h4>
											          	<button type="button" class="close" data-dismiss="modal">&times;</button>
											        </div>
											        <div class="modal-body">
											        	@if($val["rave"]->txn_id != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Transaction ID</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>
														          		{{ $val['rave']->txn_id }}</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        	@if($val["rave"]->txn_Ref != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Transaction Reference</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>
														          		{{ substr($val['rave']->txn_Ref,0,48) }} <br> {{ substr($val['rave']->txn_Ref,49,100) }}
														          	</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        	@if($val["rave"]->txn_flwRef != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Flutterwave Reference</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>
														          		{{ $val['rave']->txn_flwRef }}</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        	@php $btc = App\BitcoinPayment::where('id',$val['rave']->id)->first(); @endphp
											        	@if(isset($btc) && isset($btc->from_address) && $btc->from_address != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Bitcoin From Address</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>
														          		{{ $btc->from_address }}</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        	@if(isset($btc) && isset($btc->to_address) && $btc->to_address != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Bitcoin To Address</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>
														          		{{ $btc->to_address }}</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        	@if($val["rave"]->amount != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Transaction Amount</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>
														          		{{ $val['rave']->amount }} {{ $val->from_currency }}</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        	@if($val->transferAmount != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Transfer Amount</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>{{ $val->transferAmount ?? ""  }} {{ $val->to_currency }}</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        	@php
											        	$transfer = App\Transfer::where('transaction_id',$val->id)->first();
											        	@endphp
											        	@if(isset($transfer->draccount) && $transfer->draccount != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Debited Account</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>
														          		{{ $transfer->draccount }}
														          	</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        	@if(isset($transfer->craccount) && $transfer->craccount != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Credited Account</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>
														          		{{ $transfer->craccount }}
														          	</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        	@if(isset($transfer->ref_no) && $transfer->ref_no != "")
											        	<div class="row">
											        		<div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label><strong>Transfer Reference No</strong></label>
														        </div>
													        </div>
													        <div class="col-md-5 col-lg-5 col-sm-5">
												        		<div class="form-group">
														          	<label>
														          	    {{ substr($transfer->ref_no,0,48) }} <br> {{ substr($transfer->ref_no,49,100) }}
														          	</label>
														        </div>
													        </div>
											        	</div>
											        	@endif
											        </div>
											        <div class="modal-footer">
											          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											        </div>
											      </div>
											      
											    </div>
											</div>
										</td>
										<td>
											@if($val->status == "0")
												<button type="button" name="status" onclick="autoTransferAdmin(this);" class="btn btn-success btn-sm" data-to={{ $val->to_currency }} data-id={{ $val->id }}  data-value="{{ $val->status }}" data-status="success"><i class="ti-check"></i></button>
												<button type="button" name="status" id="reject" class="btn btn-danger btn-sm" data-id={{ $val->id }}  data-value="{{ $val->status }}" data-status="reject"><i class="ti-close"></i></button>
											@elseif($val->status == "1")
												<span class="label label-primary ">{{ __('Approved') }}</span>
											@else
												<span class="label label-danger">{{ __('Rejected') }}</span>
											@endif
										</td>
										<!-- <td>
											<a href="{{ route('admin.transaction.edit',$val['id']) }}"
												class="btn btn-info btn-sm"><i class="ti-pencil-alt"></i></a>
											<form id="delete-form" action="{{ route('admin.transaction.destroy',$val['id']) }}"
												method="POST">
												@method('DELETE')
												@csrf
												<button type="submit" name="delete" class="btn btn-danger btn-sm"><i
														class="ti-trash"></i></button>
											</form>
										</td> -->
									</tr>
									@endif
								@endforeach
							@else
								<tr>
									<td colspan="8" align="center">No Record Found</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
@endsection