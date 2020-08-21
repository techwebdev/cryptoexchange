@extends('layouts.app')

@section('title') Home | {{ config('app.name', 'eCurrencyNG') }}  @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-12 col-xs-12">
            <a href="{{ url('/') }}" class="btn btn-default btn-sm mb-2">Home</a>
            <div class="card">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @if($type != "")
                        <li class="nav-item col-lg-4 col-md-4 col-12 pr-0 pl-0">
                            <a class="nav-link" id="transaction-tab" data-toggle="tab" href="#transaction" role="tab" aria-controls="transaction" aria-selected="true">Transaction</a>
                        </li>
                        <li class="nav-item col-lg-4 col-md-4 col-12 pl-0 pr-0">
                            <a class="nav-link active" id="bankInfo-tab" data-toggle="tab" href="#bankInfo" role="tab" aria-controls="bankInfo" aria-selected="false">Account Information</a>
                        </li>
                        <li class="nav-item col-lg-4 col-md-4 col-12 pr-0 pl-0">
                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
                        </li>
                    @else
                        <li class="nav-item col-lg-4 col-md-4 col-12 pr-0 pl-0">
                            <a class="nav-link active" id="transaction-tab" data-toggle="tab" href="#transaction" role="tab" aria-controls="transaction" aria-selected="true">Transaction</a>
                        </li>
                        <li class="nav-item col-lg-4 col-md-4 col-12 pl-0 pr-0">
                            <a class="nav-link" id="bankInfo-tab" data-toggle="tab" href="#bankInfo" role="tab" aria-controls="bankInfo" aria-selected="false">Account Information</a>
                        </li>
                        <li class="nav-item col-lg-4 col-md-4 col-12 pr-0 pl-0">
                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <br>
    <div class="tab-content" id="myTabContent">
        @if($type != "")
        <div class="tab-pane fade show row active justify-content-center" id="bankInfo" role="tabpanel" aria-labelledby="bankInfo-tab">
            <div class="col-md-3 col-lg-3 col-12 float-left">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @if($type != "")
                        <a class="nav-link @if($type == '1') {{ __('active') }} @endif" id="v-pills-nigeria-tab" data-toggle="pill" href="#v-pills-nigeria" role="tab" aria-controls="v-pils-nigeria" aria-selected="true">Bank Account(NGN)</a>
                        <a class="nav-link @if($type == '2') {{ __('active') }} @endif" id="v-pills-pm-tab" data-toggle="pill" href="#v-pills-pm" role="tab" aria-controls="v-pills-pm" aria-selected="false">Perfect Money Account</a>
                        <a class="nav-link @if($type == '3') {{ __('active') }} @endif" id="v-pills-btc-tab" data-toggle="pill" href="#v-pills-btc" role="tab" aria-controls="v-pills-btc" aria-selected="false">BTC Address</a>
                    @else
                        <a class="nav-link active" id="v-pills-nigeria-tab" data-toggle="pill" href="#v-pills-nigeria" role="tab" aria-controls="v-pils-nigeria" aria-selected="true">Bank Account(NGN)</a>
                        <a class="nav-link" id="v-pills-pm-tab" data-toggle="pill" href="#v-pills-pm" role="tab" aria-controls="v-pills-pm" aria-selected="false">Perfect Money Account</a>
                        <a class="nav-link" id="v-pills-btc-tab" data-toggle="pill" href="#v-pills-btc" role="tab" aria-controls="v-pills-btc" aria-selected="false">BTC Address</a>
                    @endif
                </div>
            </div>
            <div class="col-md-9 col-lg-9 float-left">
                @include('includes.flash')
                @if($type != "")
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade @if($type == '1') {{ __('show active') }} @endif" id="v-pills-nigeria" role="tabpanel" aria-labelledby="nigeria-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Bank Account(NGN) Details</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="ngnprofileUpdateForm" id="ngnprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <select name="bank_code" class="form-control select2" onchange="autoFetchName();">
                                            <option value="">Select Any Bank</option>
                                            @if(count($bank) > 0)
                                                @foreach($bank as $key=>$val)
                                                    @if(isset($ngn->bank_code) && $ngn->bank_code == $val->bankcode)
                                                        <option value="{{ $val->bankcode }},{{ $val->bankname }}" selected>{{ $val->bankname }}</option>
                                                    @else
                                                        <option value="{{ $val->bankcode }},{{ $val->bankname }}">{{ $val->bankname }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>A/C no.</label>
                                        <input type="text" name="account_no" value="{{ $ngn->account_no ?? "" }}" onkeyup="autoFetchName();" placeholder="Enter account number" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Account Name</label>
                                        <input type="text" name="account_name" value="{{ $ngn->account_name ?? "" }}" placeholder="Enter account name" class="form-control" readonly><!-- <span><i class="fa fa-check"></i></span> -->
                                        <p class="errorAccount"></p>
                                    </div>
                                   
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="1">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade @if($type == '2') {{ __('show active') }} @endif" id="v-pills-pm" role="tabpanel" aria-labelledby="pm-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Perfect Money Account</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="pmprofileUpdateForm" id="pmprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>A/C no.</label>
                                        <input type="text" name="account_no" value="{{ $pm->account_no ?? old('account_no') }}" placeholder="Enter account number" class="form-control">
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Accout Id</label>
                                        <input type="hidden" name="account_name" value="@if(isset($pms->bank_username)) {{ Crypt::encrypt($pms->bank_username) }} @endif" placeholder="Enter accounr id" class="form-control">
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Accout Password</label>
                                        <input type="hidden" name="account_password" value="@if(isset($pms->bank_password)) {{ Crypt::encrypt($pms->bank_password) }} @endif" placeholder="Enter account password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="2">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade @if($type == '3') {{ __('show active') }} @endif" id="v-pills-btc" role="tabpanel" aria-labelledby="btc-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">BTC Address</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="btcprofileUpdateForm" id="btcprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>BitCoin Address</label>
                                        <input type="text" name="account_no" value="{{ $btc->account_no ?? old('account_no') }}" placeholder="Enter bitcoin address" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="3">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-nigeria" role="tabpanel" aria-labelledby="nigeria-tab">
                        <div class="card">
                            <?php // echo "<pre>";print_r($bank);die; ?>
                            <div class="card-header bg-primary text-white">
                                Bank Account(NGN) Details
                                <!-- <a href="" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i>&nbsp;Add Account</a> -->
                            </div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="ngnprofileUpdateForm" id="ngnprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <!-- <div class="form-group">
                                        <label>Verified Accounts</label>
                                        <select name="bank_list" class="form-control select2">
                                            <option value="">Select Any Bank</option>
                                            {{--  @if(count($ngnVerfied) > 0)
                                                @foreach($ngnVerfied as $verify)
                                                    <option value="{{ $verify->bank_code }}" selected>{{ $verify->bank_name }}<i class="fa fa-check"></i></option>
                                                @endforeach
                                            @endif --}}
                                        </select>
                                    </div> -->
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <select name="bank_code" class="form-control select2" onchange="autoFetchName();">
                                            <option value="">Select Any Bank</option>
                                            @if(count($bank) > 0)
                                                @foreach($bank as $key=>$val)
                                                    @if(isset($ngn->bank_code) && $ngn->bank_code == $val->bankcode)
                                                        <option value="{{ $val->bankcode }},{{ $val->bankname }}" selected>{{ $val->bankname }}</option>
                                                    @else
                                                        <option value="{{ $val->bankcode }},{{ $val->bankname }}">{{ $val->bankname }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>A/C no.</label>
                                        <input type="text" name="account_no" value="{{ $ngn->account_no ?? old('account_no') }}" placeholder="Enter account number" class="form-control" onkeyup="autoFetchName();">
                                    </div>
                                    <div class="form-group">
                                        <label>Account Name</label>
                                        <input type="text" name="account_name" value="{{ $ngn->account_name ?? old('account_name') }}" placeholder="Enter account name" class="form-control" readonly>
                                        <p class="errorAccount"></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="1">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-pm" role="tabpanel" aria-labelledby="pm-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Perfect Money Account</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="pmprofileUpdateForm" id="pmprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>A/C no.</label>
                                        <input type="text" name="account_no" value="{{ $pm->account_no ?? old('account_no') }}" placeholder="Enter account number" class="form-control">
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Accout Id</label>
                                        <input type="hidden" name="account_name" value="@if(isset($pms->bank_username)) {{ Crypt::encrypt($pms->bank_username) }} @endif" placeholder="Enter accounr id" class="form-control">
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Accout Password</label>
                                        <input type="hidden" name="account_password" value="@if(isset($pms->bank_password)) {{ Crypt::encrypt($pms->bank_password) }} @endif" placeholder="Enter account password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="2">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-btc" role="tabpanel" aria-labelledby="btc-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">BTC Address</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="btcprofileUpdateForm" id="btcprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>BitCoin Address</label>
                                        <input type="text" name="account_no" value="{{ $btc->account_no ?? old('account_no') }}" placeholder="Enter bitcoin address" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="3">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="tab-pane fade show" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="col-md-3 col-lg-3 col-12 float-left pl-md-0">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pils-profile" aria-selected="true">Profile</a>
                    <a class="nav-link" id="v-pills-changePassword-tab" data-toggle="pill" href="#v-pills-changePassword" role="tab" aria-controls="v-pills-changePassword" aria-selected="false">Change Password</a>
                </div>
            </div>
            <div class="col-md-9 col-lg-9 float-left pr-md-0">
                @include('includes.flash')
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">User Profile</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="userprofileForm" id="userprofileForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name ?? old('name') }}" placeholder="Enter name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" value="{{ Auth::user()->email ?? old('email') }}" placeholder="Enter email" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="number" name="mobile" value="{{ Auth::user()->mobile ?? old('mobile') }}" placeholder="Enter mobile number" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="v-pills-changePassword" role="tabpanel" aria-labelledby="changePassword-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Change Password</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="chnagePasswordForm" id="chnagePasswordForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="old_password" value="" placeholder="Enter old password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="password" id="password" value="" placeholder="Enter new password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="confirm_password" value="" placeholder="Enter confirm password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="change_password" value="chnge_pwd">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade show" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">
            <!-- <div class="col-md-3 col-lg-3 col-12 float-left">&nbsp;</div> -->
            <div class="col-md-12 col-lg-12 float-left pl-md-0 pr-md-0">
                @include('includes.flash')
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Transaction</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="userTransactionTbl">
                                        <thead>
                                            <tr>
                                                 <th scope="col">Sr No.</th>
                                                 <th scope="col">Amount</th>
                                                 <th scope="col">Charges</th>
                                                 <th scope="col">Transfer Amount</th>
                                                 <th scope="col">TxnStatus</th>
                                                 <th scope="col">Transfer Status</th>
                                                 <th scope="col">Date & Time</th>
                                                 <th scope="col">Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php //echo "<pre>"; print_r($transaction);die; ?>
                                             @forelse($transaction as $val)
                                                 <tr>
                                                     <td>{{ $loop->iteration }}</td>
                                                     <td>
                                                         @if($val->to_currency === "NGN")
                                                            {{ ($val->amount === "" ? 0 : bcdiv(str_replace(",","",$val->amount),1,2)) - ($val->charges === "" ? 0 : $val->charges) }} {{ $val->from_currency }}
                                                         @elseif($val->to_currency === "PM")
                                                            {{ ($val->amount === "" ? 0 : bcdiv(str_replace(",","",$val->amount),1,2)) - ($val->charges === "" ? 0 : $val->charges) }} {{ $val->from_currency }}
                                                         @elseif($val->to_currency === "BTC")
                                                             @if($val->from_currency == "BTC")
                                                                {{ ($val->amount === "" ? 0 : $val->amount) }} {{ $val->from_currency }}
                                                             @else
                                                                {{ ($val->amount === "" ? 0 : $val->amount) - ($val->charges === "" ? 0 : $val->charges) }} {{ $val->from_currency }}
                                                             @endif
                                                         @endif
                                                     </td>
                                                     <td>{{ $val->charges }}</td>
                                                     @if($val->to_currency == "NGN")
                                                        <td>{{ $val->transferAmount==="" ? 0 : bcdiv(str_replace(",","",$val->transferAmount),1,2) }} {{ $val->to_currency }}</td>
                                                     @elseif($val->to_currency == "PM")
                                                        <td>{{ $val->transferAmount==="" ? 0 : bcdiv(str_replace(",","",$val->transferAmount),1,2) }} {{ $val->to_currency }}</td>
                                                     @else
                                                        <td>{{ $val->transferAmount==="" ? 0 : $val->transferAmount }} {{ $val->to_currency }}</td>
                                                     @endif

                                                     <td>
                                                         @php
                                                             $rave = App\Raves::where('id',$val->rave_id)->first();
                                                         @endphp
                                                         @if($rave->txn_status == "0")
                                                            @if($rave->bitcoin_id != "")
                                                                @php $btc = \App\BitcoinPayment::where('id',$rave-> bitcoin_id)->first(); @endphp
                                                                @if($btc->unspent_status == null)
                                                                    <button type="button" name="status" id="status" class="btn btn-secondary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>  
                                                                @elseif($btc->unspent_status == 0)
                                                                    <button type="button" name="status" id="status" class="btn btn-primary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Unconfirmed') }}</button>
                                                                @elseif($btc->unspent_status == 1)
                                                                    <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Confirmed') }}</button>
                                                                @endif
                                                            @else
                                                                <button type="button" name="status" id="status" class="btn btn-secondary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>
                                                            @endif
                                                         @elseif($rave->txn_status == "1")
                                                            @if($rave->bitcoin_id != "")
                                                                @php $btc = \App\BitcoinPayment::where('id',$rave->bitcoin_id)->first(); @endphp
                                                                @if($btc->unspent_status == null)
                                                                    <button type="button" name="status" id="status" class="btn btn-secondary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>  
                                                                @elseif($btc->unspent_status == 0)
                                                                    <button type="button" name="status" id="status" class="btn btn-primary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Unconfirmed') }}</button>
                                                                @elseif($btc->unspent_status == 1)
                                                                    <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Confirmed') }}</button>
                                                                @endif
                                                            @else        
                                                                <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Success') }}</button>
                                                            @endif
                                                         @endif
                                                     </td>
                                                     <td>
                                                         @if($val->status == "0")
                                                             <button type="button" name="status" id="status" class="btn btn-secondary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>
                                                         @elseif($val->status == "1")
                                                             <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Success') }}</button>
                                                         @else
                                                             <button type="button" name="status" id="status" class="btn btn-danger btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Rejected') }}</button>
                                                         @endif
                                                     </td>
                                                     <td>{{ Carbon::parse($val->created_at)->format('Y-m-d h:i A') }}</td>
                                                     <td>
                                                        <div class="btn-group">
                                                        @if($rave->txn_status == "1")
                                                         <button type="button" class="btn btn-info btn-sm mr-1" title="Transaction info" data-toggle="modal" data-target="#myModal{{$rave->id}}"><i class="fa fa-info text-white"></i></button>
                                                        @endif         
                                                        @php
                                                        if(isset($rave->bitcoin_id) && $rave->bitcoin_id != ""){
                                                            $bitCoin = App\BitcoinPayment::where('id',$rave->bitcoin_id)->first();
                                                            if($rave->txn_status == "0" && $bitCoin->status == "0"){
                                                                if(isset($bitCoin->receive_amount) && $bitCoin->receive_amount != ""){
                                                                    $amount =$bitCoin->actual_amount - $bitCoin->receive_amount;
                                                                }else{
                                                                    $amount = $bitCoin->actual_amount;
                                                                }
                                                            @endphp
                                                            @if($bitCoin->unspent_status == null)
                                                                <a target="_blank" href="{{ route('pendingBTC',['amount'=>Crypt::encryptString($amount),'address'=>Crypt::encryptString($bitCoin->from_address)]) }}" title="Pending Bitcoin Payment" id="status" class="btn btn-secondary btn-sm mr-1"><i class="fa fa-clock-o text-white"></i></a>
                                                                <form id="delete-form{{$bitCoin->id}}" action="{{ route('bitcoin.destroy',$bitCoin->id) }}" method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                        <button type="submit" title="Delete" name="delete" class="btn btn-danger btn-sm mr-1"><i class="fa fa-trash"></i></button>
                                                                </form>
                                                            @endif
                                                            </div>
                                                        @php }  } @endphp
                                                         <div class="modal" id="myModal{{$rave->id}}">
                                                             <div class="modal-dialog">
                                                               <div class="modal-content">
                                                                 <!-- Modal Header -->
                                                                 <div class="modal-header">
                                                                   <h4 class="modal-title">Payment Information</h4>
                                                                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                 </div>
                                                                 <!-- Modal body -->
                                                                 <div class="modal-body">
                                                                     <div class="row">
                                                                         @if(isset($rave->txn_id) && $rave->txn_id != "")
                                                                             <div class="col-md-5">
                                                                                 <label><b>Txn Id</b></label>  
                                                                             </div>
                                                                             <div class="col-md-7">
                                                                                 <strong>{{ $rave->txn_id }}</strong>
                                                                             </div>
                                                                         @endif
                                                                     </div>
                                                                     <div class="row">
                                                                         @if(isset($rave->txn_Ref) && $rave->txn_Ref != "")
                                                                             <div class="col-md-5">
                                                                                 <label><b>Txn Reference</b></label>  
                                                                             </div>
                                                                             <div class="col-md-7">
                                                                                 <strong>{{ $rave->txn_Ref }}</strong>
                                                                             </div>
                                                                         @endif
                                                                     </div>
                                                                     @if($val->status == "1")
                                                                     <div class="row">
                                                                             @php
                                                                                 $transfer = \App\Transfer::where(['transaction_id'=>$val->id])->first();
                                                                             @endphp
                                                                             @if(isset($transfer->ref_no) && $transfer->ref_no != "")
                                                                                 <div class="col-md-5">
                                                                                     <label><b>Transfer Reference No.</b></label>  
                                                                                 </div>
                                                                                 <div class="col-md-7">
                                                                                     <strong>{{ $transfer->ref_no }}</strong>
                                                                                 </div>
                                                                             @endif
                                                                     </div>
                                                                     @endif
                                                                 </div>
                                                                 <!-- Modal footer -->
                                                                 <div class="modal-footer">
                                                                   <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                 </div>
                                                                 
                                                               </div>
                                                             </div>
                                                           </div>
                                                     </td>
                                                 </tr>
                                             @empty
                                                 <tr>
                                                     <td colspan="8" align="center">No Transaction found</td>
                                                 </tr>
                                             @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="tab-pane fade show row justify-content-center" id="bankInfo" role="tabpanel" aria-labelledby="bankInfo-tab">
            <div class="col-md-3 col-lg-3 col-12 float-left">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @if($type != "")
                        <a class="nav-link @if($type == '1') {{ __('active') }} @endif" id="v-pills-nigeria-tab" data-toggle="pill" href="#v-pills-nigeria" role="tab" aria-controls="v-pils-nigeria" aria-selected="true">Bank Account(NGN)</a>
                        <a class="nav-link @if($type == '2') {{ __('active') }} @endif" id="v-pills-pm-tab" data-toggle="pill" href="#v-pills-pm" role="tab" aria-controls="v-pills-pm" aria-selected="false">Perfect Money Account</a>
                        <a class="nav-link @if($type == '3') {{ __('active') }} @endif" id="v-pills-btc-tab" data-toggle="pill" href="#v-pills-btc" role="tab" aria-controls="v-pills-btc" aria-selected="false">BTC Address</a>
                    @else
                        <a class="nav-link active" id="v-pills-nigeria-tab" data-toggle="pill" href="#v-pills-nigeria" role="tab" aria-controls="v-pils-nigeria" aria-selected="true">Bank Account(NGN)</a>
                        <a class="nav-link" id="v-pills-pm-tab" data-toggle="pill" href="#v-pills-pm" role="tab" aria-controls="v-pills-pm" aria-selected="false">Perfect Money Account</a>
                        <a class="nav-link" id="v-pills-btc-tab" data-toggle="pill" href="#v-pills-btc" role="tab" aria-controls="v-pills-btc" aria-selected="false">BTC Address</a>
                    @endif
                </div>
            </div>
            <div class="col-md-9 col-lg-9 float-left">
                @include('includes.flash')
                @if($type != "")
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade @if($type == '1') {{ __('show active') }} @endif" id="v-pills-nigeria" role="tabpanel" aria-labelledby="nigeria-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Bank Account(NGN) Details</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="ngnprofileUpdateForm" id="ngnprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <select name="bank_code" class="form-control select2" onchange="autoFetchName();">
                                            <option value="">Select Any Bank</option>
                                            @if(count($bank) > 0)
                                                @foreach($bank as $key=>$val)
                                                    @if(isset($ngn->bank_code) && $ngn->bank_code == $val->bankcode)
                                                        <option value="{{ $val->bankcode }},{{ $val->bankname }}" selected>{{ $val->bankname }}</option>
                                                    @else
                                                        <option value="{{ $val->bankcode }},{{ $val->bankname }}">{{ $val->bankname }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>A/C no.</label>
                                        <input type="text" name="account_no" value="{{ $ngn->account_no ?? "" }}" onkeyup="autoFetchName();" placeholder="Enter account number" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Account Name</label>
                                        <input type="text" name="account_name" value="{{ $ngn->account_name ?? "" }}" placeholder="Enter account name" class="form-control" readonly><!-- <span><i class="fa fa-check"></i></span> -->
                                        <p class="errorAccount"></p>
                                    </div>
                                   
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="1">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade @if($type == '2') {{ __('show active') }} @endif" id="v-pills-pm" role="tabpanel" aria-labelledby="pm-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Perfect Money Account</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="pmprofileUpdateForm" id="pmprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>A/C no.</label>
                                        <input type="text" name="account_no" value="{{ $pm->account_no ?? old('account_no') }}" placeholder="Enter account number" class="form-control">
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Accout Id</label>
                                        <input type="hidden" name="account_name" value="@if(isset($pms->bank_username)) {{ Crypt::encrypt($pms->bank_username) }} @endif" placeholder="Enter accounr id" class="form-control">
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Accout Password</label>
                                        <input type="hidden" name="account_password" value="@if(isset($pms->bank_password)) {{ Crypt::encrypt($pms->bank_password) }} @endif" placeholder="Enter account password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="2">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade @if($type == '3') {{ __('show active') }} @endif" id="v-pills-btc" role="tabpanel" aria-labelledby="btc-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">BTC Address</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="btcprofileUpdateForm" id="btcprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>BitCoin Address</label>
                                        <input type="text" name="account_no" value="{{ $btc->account_no ?? old('account_no') }}" placeholder="Enter bitcoin address" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="3">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-nigeria" role="tabpanel" aria-labelledby="nigeria-tab">
                        <div class="card">
                            <?php // echo "<pre>";print_r($bank);die; ?>
                            <div class="card-header bg-primary text-white">
                                Bank Account(NGN) Details
                                <!-- <a href="" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i>&nbsp;Add Account</a> -->
                            </div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="ngnprofileUpdateForm" id="ngnprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <!-- <div class="form-group">
                                        <label>Verified Accounts</label>
                                        <select name="bank_list" class="form-control select2">
                                            <option value="">Select Any Bank</option>
                                            {{--  @if(count($ngnVerfied) > 0)
                                                @foreach($ngnVerfied as $verify)
                                                    <option value="{{ $verify->bank_code }}" selected>{{ $verify->bank_name }}<i class="fa fa-check"></i></option>
                                                @endforeach
                                            @endif --}}
                                        </select>
                                    </div> -->
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <select name="bank_code" class="form-control select2" onchange="autoFetchName();">
                                            <option value="">Select Any Bank</option>
                                            @if(count($bank) > 0)
                                                @foreach($bank as $key=>$val)
                                                    @if(isset($ngn->bank_code) && $ngn->bank_code == $val->bankcode)
                                                        <option value="{{ $val->bankcode }},{{ $val->bankname }}" selected>{{ $val->bankname }}</option>
                                                    @else
                                                        <option value="{{ $val->bankcode }},{{ $val->bankname }}">{{ $val->bankname }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>A/C no.</label>
                                        <input type="text" name="account_no" value="{{ $ngn->account_no ?? old('account_no') }}" placeholder="Enter account number" class="form-control" onkeyup="autoFetchName();">
                                    </div>
                                    <div class="form-group">
                                        <label>Account Name</label>
                                        <input type="text" name="account_name" value="{{ $ngn->account_name ?? old('account_name') }}" placeholder="Enter account name" class="form-control" readonly>
                                        <p class="errorAccount"></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="1">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-pm" role="tabpanel" aria-labelledby="pm-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Perfect Money Account</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="pmprofileUpdateForm" id="pmprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>A/C no.</label>
                                        <input type="text" name="account_no" value="{{ $pm->account_no ?? old('account_no') }}" placeholder="Enter account number" class="form-control">
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Accout Id</label>
                                        <input type="hidden" name="account_name" value="@if(isset($pms->bank_username)) {{ Crypt::encrypt($pms->bank_username) }} @endif" placeholder="Enter accounr id" class="form-control">
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Accout Password</label>
                                        <input type="hidden" name="account_password" value="@if(isset($pms->bank_password)) {{ Crypt::encrypt($pms->bank_password) }} @endif" placeholder="Enter account password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="2">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-btc" role="tabpanel" aria-labelledby="btc-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">BTC Address</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="btcprofileUpdateForm" id="btcprofileUpdateForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>BitCoin Address</label>
                                        <input type="text" name="account_no" value="{{ $btc->account_no ?? old('account_no') }}" placeholder="Enter bitcoin address" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="type" value="3">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="tab-pane fade show" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="col-md-3 col-lg-3 col-12 float-left pl-md-0">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pils-profile" aria-selected="true">Profile</a>
                    <a class="nav-link" id="v-pills-changePassword-tab" data-toggle="pill" href="#v-pills-changePassword" role="tab" aria-controls="v-pills-changePassword" aria-selected="false">Change Password</a>
                </div>
            </div>
            <div class="col-md-9 col-lg-9 float-left pr-md-0">
                @include('includes.flash')
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">User Profile</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="userprofileForm" id="userprofileForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name ?? old('name') }}" placeholder="Enter name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" value="{{ Auth::user()->email ?? old('email') }}" placeholder="Enter email" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="number" name="mobile" value="{{ Auth::user()->mobile ?? old('mobile') }}" placeholder="Enter mobile number" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="v-pills-changePassword" role="tabpanel" aria-labelledby="changePassword-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Change Password</div>
                            <form action="{{ route('profileupdate') }}" method="POST" name="chnagePasswordForm" id="chnagePasswordForm">
                                @method('POST')
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="old_password" value="" placeholder="Enter old password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="password" id="password" value="" placeholder="Enter new password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="confirm_password" value="" placeholder="Enter confirm password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="change_password" value="chnge_pwd">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade show active" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">
            <!-- <div class="col-md-3 col-lg-3 col-12 float-left">&nbsp;</div> -->
            <div class="col-md-12 col-lg-12 float-left pl-md-0 pr-md-0">
                @include('includes.flash')
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Transaction</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="userTransactionTbl">
                                        <thead>
                                            <tr>
                                                 <th scope="col">Sr No.</th>
                                                 <th scope="col">Amount</th>
                                                 <th scope="col">Charges</th>
                                                 <th scope="col">Transfer Amount</th>
                                                 <th scope="col">TxnStatus</th>
                                                 <th scope="col">Transfer Status</th>
                                                 <th scope="col">Date & Time</th>
                                                 <th scope="col">Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php //echo "<pre>"; print_r($transaction);die; ?>
                                             @forelse($transaction as $val)
                                                 <tr>
                                                     <td>{{ $loop->iteration }}</td>
                                                     <td>
                                                         @if($val->to_currency === "NGN")
                                                            {{ ($val->amount === "" ? 0 : bcdiv(str_replace(",","",$val->amount),1,2)) - ($val->charges === "" ? 0 : $val->charges) }} {{ $val->from_currency }}
                                                         @elseif($val->to_currency === "PM")
                                                            {{ ($val->amount === "" ? 0 : bcdiv(str_replace(",","",$val->amount),1,2)) - ($val->charges === "" ? 0 : $val->charges) }} {{ $val->from_currency }}
                                                         @elseif($val->to_currency === "BTC")
                                                             @if($val->from_currency == "BTC")
                                                                {{ ($val->amount === "" ? 0 : $val->amount) }} {{ $val->from_currency }}
                                                             @else
                                                                {{ ($val->amount === "" ? 0 : $val->amount) - ($val->charges === "" ? 0 : $val->charges) }} {{ $val->from_currency }}
                                                             @endif
                                                         @endif
                                                     </td>
                                                     <td>{{ $val->charges }}</td>
                                                     
                                                     @if($val->to_currency == "NGN")
                                                        <td>{{ $val->transferAmount==="" ? 0 : bcdiv(str_replace(",","",$val->transferAmount),1,2) }} {{ $val->to_currency }}</td>
                                                     @elseif($val->to_currency == "PM")
                                                        <td>{{ $val->transferAmount==="" ? 0 : bcdiv(str_replace(",","",$val->transferAmount),1,2) }} {{ $val->to_currency }}</td>
                                                     @else
                                                        <td>{{ $val->transferAmount==="" ? 0 : $val->transferAmount }} {{ $val->to_currency }}</td>
                                                     @endif
                                                     
                                                     <td>
                                                         @php
                                                             $rave = App\Raves::where('id',$val->rave_id)->first();
                                                         @endphp
                                                         @if($rave->txn_status == "0")
                                                            @if(isset($rave->bitcoin_id) && $rave->bitcoin_id != "")
                                                                @php $btc = App\BitcoinPayment::where('id',$rave->bitcoin_id)->first(); @endphp
                                                                <?php //echo "abc";echo $rave->bitcoin_id;print_r($btc);die; ?>
                                                                @if($btc->unspent_status == null)
                                                                    <button type="button" name="status" id="status" class="btn btn-secondary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>  
                                                                @elseif($btc->unspent_status == 0)
                                                                    <button type="button" name="status" id="status" class="btn btn-primary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Unconfirmed') }}</button>
                                                                @elseif($btc->unspent_status == 1)
                                                                    <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Confirmed') }}</button>
                                                                @endif
                                                            @else
                                                                <button type="button" name="status" id="status" class="btn btn-secondary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>
                                                            @endif
                                                         @elseif($rave->txn_status == "1")
                                                            @if($rave->bitcoin_id != "")
                                                                @php $btc = App\BitcoinPayment::where('id',$rave->bitcoin_id)->first(); @endphp
                                                                @if($btc->unspent_status == 0)
                                                                    <button type="button" name="status" id="status" class="btn btn-primary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Unconfirmed') }}</button>    
                                                                @elseif($btc->unspent_status == 1)                                                                    
                                                                    <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Confirmed') }}</button>
                                                                @elseif($btc->unspent_status == null)
                                                                    <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>    
                                                                @endif
                                                            @else        
                                                                <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Success') }}</button>
                                                            @endif
                                                         @endif
                                                     </td>
                                                     <td>
                                                         @if($val->status == "0")
                                                             <button type="button" name="status" id="status" class="btn btn-secondary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>
                                                         @elseif($val->status == "1")
                                                             <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Success') }}</button>
                                                         @else
                                                             <button type="button" name="status" id="status" class="btn btn-danger btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Rejected') }}</button>
                                                         @endif
                                                     </td>
                                                     <td>{{ Carbon::parse($val->created_at)->format('Y-m-d h:i A') }}</td>
                                                     <td>
                                                        <div class="btn-group">
                                                        @if($rave->txn_status == "1")
                                                         <button type="button" class="btn btn-info btn-sm mr-1" title="Transaction info" data-toggle="modal" data-target="#myModal{{$rave->id}}"><i class="fa fa-info text-white"></i></button>
                                                        @endif         
                                                        @php
                                                        if(isset($rave->bitcoin_id) && $rave->bitcoin_id != ""){
                                                            $bitCoin = App\BitcoinPayment::where('id',$rave->bitcoin_id)->first();
                                                            if($rave->txn_status == "0" && $bitCoin->status == "0"){
                                                                if(isset($bitCoin->receive_amount) && $bitCoin->receive_amount != ""){
                                                                    $amount =$bitCoin->actual_amount - $bitCoin->receive_amount;
                                                                }else{
                                                                    $amount = $bitCoin->actual_amount;
                                                                }
                                                            @endphp
                                                            @if($bitCoin->unspent_status == null)
                                                                <a target="_blank" href="{{ route('pendingBTC',['amount'=>Crypt::encryptString($amount),'address'=>Crypt::encryptString($bitCoin->from_address)]) }}" title="Pending Bitcoin Payment" id="status" class="btn btn-secondary btn-sm mr-1"><i class="fa fa-clock-o text-white"></i></a>
                                                                <form id="delete-form{{$bitCoin->id}}" action="{{ route('bitcoin.destroy',$bitCoin->id) }}" method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                        <button type="submit" title="Delete" name="delete" class="btn btn-danger btn-sm mr-1"><i class="fa fa-trash"></i></button>
                                                                </form>
                                                            @endif
                                                            </div>
                                                        @php }  } @endphp
                                                         <div class="modal" id="myModal{{$rave->id}}">
                                                             <div class="modal-dialog">
                                                               <div class="modal-content">
                                                                 <!-- Modal Header -->
                                                                 <div class="modal-header">
                                                                   <h4 class="modal-title">Payment Information</h4>
                                                                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                 </div>
                                                                 <!-- Modal body -->
                                                                 <div class="modal-body">
                                                                     <div class="row">
                                                                         @if(isset($rave->txn_id) && $rave->txn_id != "")
                                                                             <div class="col-md-5">
                                                                                 <label><b>Txn Id</b></label>  
                                                                             </div>
                                                                             <div class="col-md-7">
                                                                                 <strong>{{ $rave->txn_id }}</strong>
                                                                             </div>
                                                                         @endif
                                                                     </div>
                                                                     <div class="row">
                                                                         @if(isset($rave->txn_Ref) && $rave->txn_Ref != "")
                                                                             <div class="col-md-5">
                                                                                 <label><b>Txn Reference</b></label>  
                                                                             </div>
                                                                             <div class="col-md-7">
                                                                                 <strong>{{ $rave->txn_Ref }}</strong>
                                                                             </div>
                                                                         @endif
                                                                     </div>
                                                                     @if($val->status == "1")
                                                                     <div class="row">
                                                                             @php
                                                                                 $transfer = \App\Transfer::where(['transaction_id'=>$val->id])->first();
                                                                             @endphp
                                                                             @if(isset($transfer->ref_no) && $transfer->ref_no != "")
                                                                                 <div class="col-md-5">
                                                                                     <label><b>Transfer Reference No.</b></label>  
                                                                                 </div>
                                                                                 <div class="col-md-7">
                                                                                     <strong>{{ $transfer->ref_no }}</strong>
                                                                                 </div>
                                                                             @endif
                                                                     </div>
                                                                     @endif
                                                                 </div>
                                                                 <!-- Modal footer -->
                                                                 <div class="modal-footer">
                                                                   <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                 </div>
                                                                 
                                                               </div>
                                                             </div>
                                                           </div>
                                                     </td>
                                                 </tr>
                                             @empty
                                                 <tr>
                                                     <td colspan="8" align="center">No Transaction found</td>
                                                 </tr>
                                             @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection