@extends('layouts.layout')

@section('title') FAQ | {{ config('app.name', 'eCurrencyNG') }}  @endsection

@section('content')
<?php
$data = array(
	array('title'=>'Why use eCurrencyNG?','description'=>"Ecurrency is becoming more popular by the minute. It's starting to seem that everyone wants in, yet it isn't always so easy to get a hold of. For instance, the process of purchasing ecurrencies by bank transfer is a lengthy process that in some cases can take days, approving your documents can also take a while, so until you actually get your order processed it could take some time.Endopay is here to change that. We now offer the quickest way of purchasing ecurrency/crypto-currency online using your Credit Card, Debit Card or Cash, so you'll purchase your ecurrency within minutes!"),
	array('title'=>'What currencies does eCurrencyNG accept?','description'=>"We accept all Nigerian NGN,PM AND BTC at this time"),
	array('title'=>"How long does it take for eCurrencyNG to send my ecurrency once I've paid?",'description'=>"eCurrencyNG sends e-currency immediately after successful payment and wallet address have been confirmed (delays might occur in rear occasions)."),
	array('title'=>"Can I use a Credit/Debit Card?",'description'=>"Yes, you can purchase ecurrency with a Credit Card or a Debit Card via AccessBank / Interswitch, which allows you to pay online and receive your ecurrency quicker.(ONLY Nigerian Cards are currently acceptable.)"),
	array('title'=>"I am having issues paying with my Credit/Debit Card?",'description'=>"If you having paying with your credit/debit card, you can use your mobile/internet banking or cash deposit, quoting your order number as the reference.(NB. You can only pay for an order when it is valid, else charges may apply.)"),
	array('title'=>"Which ecurrencies are available to transfer proccess?",'description'=>"As for now we offer Bitcoin, Perfect Money And Nigeria."),
	array('title'=>"How can I prove that a transaction was made?",'description'=>"You can see in your account transaction section with your order id and transaction reference"),
	array('title'=>"Why must I provide my personal details?",'description'=>"As part of eCurrencyNG policy to prevent money laundering, we request our clients to identify themselves."),
	array('title'=>"Are my Credit/Debit Card details saved in your system?",'description'=>"As per government guide line and our privacy policy we can't store credit card and debit card details to our server."),
	array('title'=>"What are your fees?",'description'=>"All the fees depend on the transaction and depending on payment gateway rules."),
	array('title'=>'When can I get my eCurrencyNG tranfer amount?','description'=>"You can get within 30 minute after successful  transaction."),
);
?>
<div class="container">
	<div class="row justify-content-center mt-5 pt-5">
	    <div class="col-md-8">
			@foreach($data as $key=>$val)
			<div class="panel-group card" id="eCurrencyNG" data-toggle="collapse" data-parent="#eCurrencyNG" href = "#faq{{$key}}">
				   <div class = "panel panel-default">

				      <div class="card-header">
				         <h6 class="panel-title" data-toggle="collapse" data-parent="#eCurrencyNG" href = "#faq{{$key}}">
				         	{{ $val['title'] }}
				         	<button type="button" class="btn btn-default btn-sm pull-right" data-parent="#eCurrencyNG" data-toggle="collapse" data-target="#faq{{$key}}"><i class="fa fa-angle-down" aria-hidden="true"></i></button>
				         </h6>
				      </div>
				      
				      <div id = "faq{{$key}}" class="panel-collapse collapse">
				         <div class = "card-body">
				            {{ $val['description'] }}
				         </div>
				      </div>

				   </div>
			</div>
			@endforeach
		</div>
		</div>
</div>
@endsection