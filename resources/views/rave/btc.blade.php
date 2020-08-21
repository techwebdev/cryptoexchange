@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Payment Info') }}</div>
                <div class="card-body">
					<?php
                	$satoshi_amount = $amount / 100000000;
            		$chkAddress = DB::table('bitcoin_payments')->where('from_address',[$payTo])->first();
					session(['pay_address'=>$payTo]);//this can be added to the Database
					if($payTo != ""){
						if(empty($chkAddress)){
							$transferAmount = \DB::table('exchange_rates')->where('from_currency',session('from_currency'))->where('to_currency',session('to_currency'))->first();
							// echo "<pre>";print_r($transferAmount->amount * $amount);die;
							$bitCoin = \DB::table('bitcoin_payments')->insert(['user_id' => Auth::user()->id, 'from_address' => $payTo,'to_address'=>'','order_id'=>$orderID,'actual_amount'=>$amount,'receive_amount'=>'','fees'=>'','status'=>'0','created_at'=>Carbon::now()]);
							$rave = \DB::table('raves')->insert(['user_id' => Auth::user()->id, 'bitcoin_id' => DB::getPdo('bitcoin_payments')->lastInsertId(),'txn_id'=>'','txn_Ref'=>'','currency'=>'','amount'=>'','charges'=>'0','txn_status'=>'0','created_at'=>Carbon::now()]);
							$transaction = \DB::table('transactions')->insert(['user_id' => Auth::user()->id, 'rave_id' => DB::getPdo('raves')->lastInsertId(),'amount'=>$amount,'transferAmount'=>$transferAmount->amount * $amount,'charges'=>'0','from_currency'=>session('from_currency'),'to_currency'=>session('to_currency'),'status'=>'0','created_at'=>Carbon::now()]);
						}
					}
					?>
                	@push('scripts')
					<!-- TOASTR ALERT OPTIONAL -->
					<link href="{{ asset('assets/toastr/toastr.css') }}" rel="stylesheet">
					<link href="{{ asset('assets/example_1.css') }}" rel="stylesheet">
					<script src="{{ asset('assets/toastr/toastr.js') }}"></script>
					<script type="text/javascript">
						setInterval(function(){
							// console.log("hello");
							chekConfirmation();
						},10000);
						function chekConfirmation(){
							var address = '<?php echo $payTo ?>';
							$.ajax({
								url:"{{ route('checkConfirmation') }}",
								type:"POST",
								data:{address:address},
								success:function(response){
									if(response.success && response.success == "1" && response.data && (response.data.confirmations >= 0 || response.data.confirmations >= "0")){
										window.location.href = response.redirect_url;
									}
								}
							});
						}
					</script>
                	@endpush
                	@stack('scripts')
					<div class="col-md-12">
					    <div class="offer offer-warning" id="Example2PaymentBox_<?= $orderID ?>">
					      <div class="shape">
					        <div class="shape-text">
					          BTC               
					        </div>
					      </div>
					      <div class="offer-content mt-3">
					        <h3 class="lead">
					          Send <b><?= $amount ?> BTC</b>
					        </h3>
					        <p>
					        <div class="col-sm-4 col-md-4 col-lg-4">
					          <img src="https://chart.googleapis.com/chart?chs=125x125&cht=qr&chl=bitcoin:<?= $payTo ?>?amount=<?= $amount ?>&choe=UTF-8"  class="img-responsive">
					        </div>
					        <div class="col-sm-8 col-md-8 col-lg-8" style="padding:10px;">
					          Send <b><?= $amount ?> BTC</b><br/><input type="text" id="address_<?= $orderID ?>" class="form-control" value="<?= $payTo ?>" onclick="this.select();" readonly>
					          Simply scan QR Code with your mobile device or copy one in the input box<br/><br/>
					          <small class="text text-secondary" id="messages">
					          No need to refresh page, your payment status will be updated automatically.<br/>
					          <span class="text text-info"><i class="fa fa-spin fa-circle-o-notch"></i> Awaiting <?= $amount ?> bitcoin payment ....</span>
					          </small>
					        </div>
					        </p>
					      </div>
					    </div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection