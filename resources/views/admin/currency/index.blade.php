@extends('admin.layouts.layout')

@section('title') Currency | {{ config('app.name', 'eCurrencyNG') }} @endsection

@section('content')
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		@include('admin.includes.flash')
		<div class="card">
			<div class="card-header">
				<h5>Currency List</h5>
				<span></span>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive">
					{{-- <a href="{{ route('admin.currency.create') }}" class="btn btn-primary btn-sm pull-right">Add New<i
							class="ti-plus"></i></a> --}}
					<table id="currencyTable" class="table table-striped table-bordered nowrap">
						<thead>
							<tr>
								<th>Sr No.</th>
								<th>Name</th>
								<!-- <th>Value</th> -->
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($data) && count($data) > 0)
								@foreach($data as $key=>$val)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $val["name"] }}</td>
										<td>
											<a href="{{ route('admin.currency.edit',$val['id']) }}"
												class="btn btn-info btn-sm"><i class="ti-pencil-alt"></i></a>
											<form id="delete-form" action="{{ route('admin.currency.destroy',$val['id']) }}"
												method="POST">
												@method('DELETE')
												@csrf
												<button type="submit" name="delete" class="btn btn-danger btn-sm"><i
														class="ti-trash"></i></button>
											</form>
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="4" align="center">No Record Found</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
@endsection