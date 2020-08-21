@extends('admin.layouts.layout')

@section('title') Users | {{ config('app.name', 'eCurrencyNG') }} @endsection

@section('content')
<div class="pcoded-content">
	<div class="pcoded-inner-content">
		@include('admin.includes.flash')
		<div class="card">
			<div class="card-header">
				<h5>Users List</h5>
				<span></span>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive">
					<!-- <a href="{{ route('admin.transaction.create') }}" class="btn btn-primary btn-sm pull-right">Add New<i
							class="ti-plus"></i></a> -->
					    <table id="transactionTable" class="table table-striped table-bordered nowrap">
						<thead>
							<tr>
								<th scope="col">Sr No.</th>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Total Transaction</th>
                                <th scope="col">Total Transfer</th>
                                <th scope="col">Users Accounts</th>
                                <th scope="col">Last Transaction Date</th>
								<th scope="col">Created At</th>
							</tr>
						</thead>
						<tbody>
                            @forelse($users as $key=>$val)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $val->name }}
                                        @if($val->email_verified_at != "" && $val->isVerified == "1")
                                            <img src="{{ asset('admin_assets/assets/images/correct.svg') }}  " style='width: 14px;'/> 
                                        @endif
                                    </td>
                                    <td>{{ $val->email }}</td>
                                    <td>{{ $val->mobile }}</td>
                                    <td>
                                        @if(count($val->transaction) > 0)
                                            <span class="label label-primary">{{ __(count($val->transaction)) }}</span>
                                        @else
                                            <span class="label label-danger">{{ __(count($val->transaction)) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(count($val->transfer) > 0)
                                            <span class="label label-primary">{{ __(count($val->transfer)) }}</span>
                                        @else
                                        <span class="label label-danger">{{ __(count($val->transfer)) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @forelse($val->bank_detail as $bank)
                                            @php 
                                            $tot_account = explode(',',$bank->type_id);
                                            $type = App\Type::where('id',$tot_account)->first()->short_name; 
                                            @endphp
                                            {{ $type }}
                                            @if($bank->type_id == "1")
                                                @if($bank->isVerified == "1")
                                                    <img src="{{ asset('admin_assets/assets/images/correct.svg') }}  " style='width: 14px;'/> 
                                                @endif
                                            @elseif($bank->type_id == "2")
                                                @if($bank->isVerified == "1")
                                                    <img src="{{ asset('admin_assets/assets/images/correct.svg') }}  " style='width: 14px;'/> 
                                                @endif
                                            @elseif($bank->type_id == "3")
                                                @if($bank->isVerified == "1")
                                                    <img src="{{ asset('admin_assets/assets/images/correct.svg') }}  " style='width: 14px;'/> 
                                                @endif
                                            @endif
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td>
                                        @php
                                        $lastTransaction = \App\Transaction::where('user_id',$val->id)->orderBy('id','desc')->first();
                                        @endphp
                                        @empty(!$lastTransaction)
                                            {{ Carbon::parse($lastTransaction->created_at)->format('Y-m-d H:i A') }}
                                        @else
                                            -
                                        @endempty
                                    </td>
                                    <td>{{ Carbon::parse($val->created_at)->format('Y-m-d H:i A') }}</td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="9" align="center">No Record Found</td>
                            </tr>
                            @endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
@endsection