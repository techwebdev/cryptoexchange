@extends('layouts.app')

@section('title') Dashboard | {{ config('app.name', 'eCurrencyNG') }}  @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 col-lg-2 col-12">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <!-- <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pils-home" aria-selected="true">Home</a> -->
                {{-- <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a> --}}
                <a class="nav-link active" id="v-pills-transaction-tab" data-toggle="pill" href="#v-pills-transaction" role="tab" aria-controls="v-pills-transaction" aria-selected="false">Transaction</a>
            </div>
        </div>
        <div class="col-md-8 col-12">
            @include('includes.flash')
            <div class="tab-content" id="v-pills-tabContent">
                <!-- <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="card">
                        <div class="card-header">Dashboard</div>
                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif
                            You are logged in!
                        </div>
                    </div>
                </div> -->
                {{-- <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="card">
                        <div class="card-header">Profile</div>
                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif
                           Profile
                        </div>
                    </div>
                </div> --}}
                <div class="tab-pane fade show active" id="v-pills-transaction" role="tabpanel" aria-labelledby="v-pills-transaction-tab">
                    <div class="card">
                        <div class="card-header">Transaction</div>
                        <div class="card-body">
                           <table class="table table-striped" id="userTransactionTbl">
                               <thead>
                                   <tr>
                                        <th scope="col">Sr No.</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Charges</th>
                                        <th scope="col">Transfer Amount</th>
                                        <th scope="col">TxnStatus</th>
                                        <th scope="col">Transfer Status</th>
                                        <!-- <th scope="col">Date & Time</th> -->
                                        <th scope="col">Info</th>
                                   </tr>
                               </thead>
                               <tbody>
                                <?php //echo "<pre>"; print_r($transaction);die; ?>
                                    @forelse($transaction as $val)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $val->amount - $val->charges }} {{ $val->from_currency }}</td>
                                            <td>{{ $val->charges }}</td>
                                            <td>{{ $val->transferAmount }} {{ $val->to_currency }}</td>
                                            <td>
                                                @php
                                                    $rave = App\Raves::where('id',$val->rave_id)->first();
                                                @endphp
                                                @if($rave->txn_status == "0")
                                                    <button type="button" name="status" id="status" class="btn btn-secondary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>
                                                @elseif($rave->txn_status == "1")
                                                    <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Success') }}</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if($val->status == "0")
                                                    <button type="button" name="status" id="status" class="btn btn-secondary btn-sm"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ __('Pending') }}</button>
                                                @else
                                                    <button type="button" name="status" id="status" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;&nbsp;{{ __('Success') }}</button>
                                                @endif
                                            </td>
                                            <!-- <td>{{ date('Y-m-d h:i s',strtotime($val->created_at)) }}</td> -->
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$rave->id}}"><i class="fa fa-info"></i></button>
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
                                                                @if($rave->txn_id != "")
                                                                    <div class="col-md-5">
                                                                        <label><b>Txn Id</b></label>  
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <strong>{{ $rave->txn_id }}</strong>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                @if($rave->txn_Ref != "")
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
                                                                    @if($transfer->ref_no != "")
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
                                            <td colspan="7" align="center">No Transaction found</td>
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
    <br>
</div>
@endsection