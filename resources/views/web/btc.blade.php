@extends('layouts.app')

@section('title') Pending Payment | {{ config('app.name','eCurrencyNG') }}  @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Payment Info') }}</div>
                <div class="card-body">
					<?php
                	$satoshi_amount = $amount / 100000000;
					  if(isset($payTo)){
						$chkAddress = DB::table('bitcoin_payments')->where('from_address',[$payTo])->first();
						session(['pay_address'=>$payTo]);//this can be added to the Database
						/*if(isset($chkAddress) && $chkAddress->status == "1"){
							session(['pay_address_ispaid'=>true]);//this can be read from the Database
						}else{
							session(['pay_address_ispaid'=>false]);//this can be read from the Database
						}*/
					  }else{
					  	return redirect()->back()->with('error','Invalid pending address');
					    // header('Location: error_page.php?msg='.$json['message']." - ".$json['description']);
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
                	<!-- <script>
						var btcs = new WebSocket('<?= $app_webSocketURL ?>');
						  console.log(btcs)

						btcs.onopen = function(){
						  btcs.send( JSON.stringify( {"op":"addr_sub", "addr":"<?= $payTo ?>"} ) );
						};
						btcs.onmessage = function(onmsg){
						  var response = JSON.parse(onmsg.data);
						  console.log(response)
						  var hash = response.x.hash;
						  var getOuts = response.x.out;
						  var countOuts = getOuts.length;
						  var getInputs = response.x.inputs;
						  var countInputs = getInputs.length;
						  for(var j = 0;j<countInputs;j++){
						  	var inputAdd = response.x.inputs[j].prev_out.addr;
						  	var receive_amount = response.x.inputs[j].prev_out.value;
						  	var inScript = response.x.inputs[j].prev_out.script;
						  }
						  for(var i = 0; i < countOuts; i++)
						  {
						      //check every output to see if it matches specified address
						      var outScript = response.x.out[i].script;
						      var outAdd = response.x.out[i].addr;
						      var specAdd = "<?= $payTo ?>";
						      var expectedAmnt = "<?= $satoshi_amount ?>";
						      if (outAdd == specAdd )
						      {
						        //var expectedAmnt = expectedval / 100000000;
						        var amount = response.x.out[i].value;
						        var calAmount = amount / 100000000;
						        //check if amount sent is equal to the expected
						        if(calAmount < expectedAmnt){
						          toastr.error("Received "+calAmount+" BTC amount was lower than the expected ");
						        }
						        	transactionInfo(outAdd,inputAdd,hash,outScript,calAmount);
						        	$('#messages').removeClass('text-info').addClass('text-success').html("<span class='text text-success'><i class='fa fa-thumbs-o-up'></i> Your payment of " + calAmount + " BTC has been Received </span>");
						        	//uses toastr/toastr.js and toastr/toastr.css
						        	toastr.success("Received " + calAmount + " BTC");

						        var beep_notify_sound = <?= $beed_notify ?>;
						        if(beep_notify_sound == true){
						         var snd = new  Audio("<?= $beed_sound_code ?>");  
						         snd.play();
						        }
						      } 
						  }
						}
						function transactionInfo(payto,payUser,hash,outScript,receive_amount){
							$.ajax({
								url:"{{ route('btcPendingPayment') }}",
								type:"POST",
								data:{payto:payto,payUser:payUser,hash:hash,script:outScript,receive_amount:receive_amount},
								beforeSend:function(){

								},
								success:function(response){
									console.log(response);
									alert(response.msg);
									if(response.success && response.success == "1"){
										window.location.href = response.redirect_url;
									}
								},
								error:function(error){
									console.log(error);
									toastr.error(error);
								}
							})
						}
						</script> -->
                	@endpush
                	@stack('scripts')
                	<!-- <div class="jumbotron">
					  <h1 class="text text-secondary text-center"><?= $amount ?> BTC</h1>
					</div> -->
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