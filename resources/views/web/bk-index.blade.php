@extends('layouts.layout')

@section('title') {{ config('app.name', 'eCurrencyNG') }}  @endsection

@section('content')
    <!-- Hero Area Start -->
	<div class="hero-area myform">
		<div class="container">
			@include('includes.flash')
			<form method="POST" action="{{ route('store') }}" name="exchangeForm" id="exchangeForm">
				@method('POST')
				@csrf
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-3 col-md-6 col-sm-12 col-12 d-flex align-self-center">
						<div class="form-group">
							<label>Amount</label>
							<input type="text" name="amount" class="form-control" value="{{ old('amount') ?? session('amount') }}" placeholder="Enter amount" onkeyup="exchangeRate();">
                            @error('amount')
                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                            @enderror
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-12 col-12 d-flex align-self-center">
						<div class="form-group">
							<label>From</label>
							<select class="form-control" name="from_currency" onchange="removeSelected();exchangeRate();">
								<option value="">-Select Any Currency-</option>
								@foreach($data as $key=>$val):
									@if($val->name == session('from_currency'))
										<option value="{{ $val->name }}" onchange="exchangeRate();" selected>{{ $val->name ?? session('from_currency') }}</option>	
									@else
										<option value="{{ $val->name }}" onchange="exchangeRate();" >{{ $val->name ?? session('from_currency') }}</option>
									@endif
								@endforeach
							</select>
							@error('from_currency')
                                <small class="text-danger">{{ $errors->first('from_currency') }}</small>
                            @enderror
						</div>
					</div>
					<div class=" d-flex align-self-center xs-w-full pr-4 xs-px-5">
						<div class="form-group">
							<label>To</label>
							<select class="form-control" name="to_currency" onchange="exchangeRate();">
								<option value="">-Select Any Currency-</option>
								@foreach($data as $key=>$val):
									@if(session('to_currency') == $val->name)
										<option value="{{ $val->name }}" onchange="exchangeRate();" selected>{{ $val->name ?? session('to_currency') }}</option>
									@else
										<option value="{{ $val->name }}" onchange="exchangeRate();">{{ $val->name ?? session('to_currency') }}</option>
									@endif
								@endforeach
							</select>
							@error('to_currency')
                                <small class="text-danger">{{ $errors->first('to_currency') }}</small>
                            @enderror
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-12 col-12 d-flex align-self-center pl-0 xs-px-5">
						<div class="form-group">
							{{-- <input type="submit" name="submit" name="convert" class="btn btn-primary" style="margin-top: 30px;"> --}}
							<input type="hidden" name="previousURL" value="{{ url()->current() }}">
							<input type="hidden" name="status" value="0">
							<button type="submit" class="btn btn-primary btn-lg" style="margin-top: 30px;"><i class="fas fa-angle-double-right"></i></button>
						</div>
					</div>
				</div>
				<div class="row" id="exchangeRateConverter" style="display: none;">
					<div class="col-lg-4 col-md-4 col-12"></div>
					<div class="col-lg-4 col-md-4 col-sm-12 col-12">
						<p class="exchangeRate text-center"></p>
					</div>
				</div>
			</form>
					<!-- <div class="left-content">
						<div class="content">
							<h5 class="subtitle">
								Secure. Fast. Profitable
							</h5>
							<h1 class="title">
								Lend and Borrow
								Cryptocurrency
							</h1>
							<p class="text">
								Borrow, Lend and margin trade crypto
								assets on Lendbo								   
							</p>
							<div class="links">
								<a href="#" class="mybtn1 link1"><span>Start Borrowing</span> </a>
								<a href="#" class="mybtn1 link2"><span>Start Lending</span> </a>
							</div>
						</div>
					</div> -->

				</div>
			</div>
		</div>
	</div>
				<div class="row">
					<div class="col-md-2 col-lg-2 col-12"></div>
					<div class="col-md-4 col-lg-4 col-12">
						<div class="right-img">
							<img src="assets/images/hero.png" alt="">
						</div>
					</div>
					<div class="col-md-4 col-lg-4 col-12">
						<table class="table table-bordered table-hover">
							<thead>
								<tr class="thead-light">
									<th><font color="#2a80f073">Sr No.</font></th>
									<th><font color="#2a80f073">Currency</font></th>
									<th><font color="#2a80f073">Buy</font></th>
									<th><font color="#2a80f073">Sell</font></th>
								</tr>
							</thead>
							<tbody>
								@if(count($exchangeRate) > 0)
									@foreach($exchangeRate as $val)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<th>{{ $val->from_currency }}</th>
										<td>
											@if($val->from_currency == "NGN" && $val->to_currency == "PM")
												{{ $val->amount }}
											@elseif($val->from_currency == "NGN" && $val->to_currency == "BTC")
												{{ $val->amount }}
											@endif
										</td>
										<td>
											@if($val->from_currency == "PM" && $val->to_currency == "NGN")
												{{ $val->amount }}
											@elseif($val->from_currency == "BTC" && $val->to_currency == "NGN")
												{{ $val->amount }}
											@endif	
										</td>
										<!-- <td>
										    @if($val['from_currency'] == "PM")
										        <img class="img-responsive" src="{{ asset('assets/images/pm.png') }}" style="width:50px;height:50px;">
										    @elseif($val['from_currency'] == "BTC")
										        <img src="{{ asset('assets/images/bt.png') }}"  style="width:50px;height:50px;">
										    @elseif($val['from_currency'] == "NGN")
										        ₦
										    @endif
										     1 
										    {{ $val->from_currency }}
										</td> -->
										<!-- <td>
										    @if($val->to_currency == "PM")
										        <img class="img-responsive" src="{{ asset('assets/images/pm.png') }}" style="width:50px;height:50px;">
										    @elseif($val->to_currency == "BTC")
										        <img src="{{ asset('assets/images/bt.png') }}"  style="width:50px;height:50px;">
										    @elseif($val->to_currency == "NGN")
										        ₦
										    @endif
										    {{ $val->amount }}
										     {{ $val->to_currency }}
										</td> -->
									</tr>
									@endforeach	
								@else
									<tr>
										<td>No exchange rate</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
	<!-- Hero Area End -->

	<!-- Features Area Start -->
	<!-- <section class="features">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="single-feature">
						<div class="left">
							<img src="assets/images/feat1.png" alt="">
						</div>
						<div class="right">
							<p class="sub-title">
							Yearly Interest
							</p>
							<h4 class="title">
								3%
							</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="single-feature">
						<div class="left">
							<img src="assets/images/feat2.png" alt="">
						</div>
						<div class="right">
							<p class="sub-title">
								Loan Duration
							</p>
							<h4 class="title">
								0-12Mo
							</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="single-feature">
						<div class="left">
							<img src="assets/images/feat3.png" alt="">
						</div>
						<div class="right">
							<p class="sub-title">
								Fee as low as
							</p>
							<h4 class="title">
								0%
							</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- Features Area End -->

	<!-- Whay Choose us Area Start -->
	<!-- <section class="why-choose-us">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="section-heading">
						<h5 class="subtitle">
							The Most Trusted
						</h5>
						<h2 class="title extra-padding">
							Cryptocurrency Platform
						</h2>
						<p class="text">
							Here are a few reasons why you should choose Lendbo
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="single-why">
						<div class="left">
							<div class="icon">
								<img src="assets/images/why1.png" alt="">
							</div>
						</div>
						<div class="right">
							<h4 class="title">
								Reliable and Safe
							</h4>
							<p class="text">
								Advanced security and reliability
								of your collateral									
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="single-why">
						<div class="left">
							<div class="icon">
								<img src="assets/images/why2.png" alt="">
							</div>
						</div>
						<div class="right">
							<h4 class="title">
								Crypto as Collateral
							</h4>
							<p class="text">
								Advanced security and reliability
								of your collateral									
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="single-why">
						<div class="left">
							<div class="icon">
								<img src="assets/images/why3.png" alt="">
							</div>
						</div>
						<div class="right">
							<h4 class="title">
									Easy to Use
							</h4>
							<p class="text">
								Advanced security and reliability
								of your collateral									
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="single-why">
						<div class="left">
							<div class="icon">
								<img src="assets/images/why4.png" alt="">
							</div>
						</div>
						<div class="right">
							<h4 class="title">
									Simple Process
							</h4>
							<p class="text">
								Advanced security and reliability
								of your collateral									
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="single-why">
						<div class="left">
							<div class="icon">
								<img src="assets/images/why5.png" alt="">
							</div>
						</div>
						<div class="right">
							<h4 class="title">
									Available Worldwide
							</h4>
							<p class="text">
								Advanced security and reliability
								of your collateral									
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="single-why">
						<div class="left">
							<div class="icon">
								<img src="assets/images/why6.png" alt="">
							</div>
						</div>
						<div class="right">
							<h4 class="title">
									Variety of Currencies
							</h4>
							<p class="text">
								Advanced security and reliability
								of your collateral									
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- Whay Choose us Area End -->

	<!-- Lend Area Start -->
	<!-- <section class="lend">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="section-heading">
						<h5 class="subtitle extra-padding">
							The Smarter Way 
						</h5>
						<h2 class="title">
							Lend and Borrow
						</h2>
						<p class="text">
							The World's First Crypto Lending Marketplace and 
							Affordable and competitive interest rates
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="tab-menu-area">
						<ul class="nav nav-lend mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-lend-tab" data-toggle="pill" href="#pills-lend" role="tab" aria-controls="pills-lend" aria-selected="true">Lend</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-borrow-tab" data-toggle="pill" href="#pills-borrow" role="tab" aria-controls="pills-borrow" aria-selected="false">Borrow</a>
							</li>
						</ul>
					</div>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-lend" role="tabpanel" aria-labelledby="pills-lend-tab">
							<div class="responsive-table">
								<table class="table">
									<thead>
										<tr>
										<th scope="col">TOKEN NAME</th>
										<th scope="col">LEND APR</th>
										<th scope="col">BORROW APR</th>
										<th scope="col">LOANS ACTIVE</th>
										<th scope="col">RESERVE POOL</th>
										<th scope="col">LEND & EARN</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										<td>
											<img src="assets/images/icon1.png" alt="">
											BTC
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon2.png" alt="">
											ETH
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon3.png" alt="">
											DASH
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon4.png" alt="">
											ETC
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon5.png" alt="">
											TRX
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon1.png" alt="">
											BTC
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
									</tbody>
									</table>
							</div>
						</div>
						<div class="tab-pane fade" id="pills-borrow" role="tabpanel" aria-labelledby="pills-borrow-tab">
							<div class="responsive-table">
								<table class="table">
									<thead>
										<tr>
										<th scope="col">TOKEN NAME</th>
										<th scope="col">LEND APR</th>
										<th scope="col">BORROW APR</th>
										<th scope="col">LOANS ACTIVE</th>
										<th scope="col">RESERVE POOL</th>
										<th scope="col">LEND & EARN</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										<td>
											<img src="assets/images/icon1.png" alt="">
											BTC
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon2.png" alt="">
											ETH
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon3.png" alt="">
											DASH
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon4.png" alt="">
											ETC
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon5.png" alt="">
											TRX
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
										<tr>
										<td>
											<img src="assets/images/icon1.png" alt="">
											BTC
										</td>
										<td>9.8%</td>
										<td>17.9%</td>
										<td>$325,650</td>
										<td>$481,694</td>
										<td>
											<a href="#">
												Lend
											</a>
										</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- Lend Area End -->

	<!-- fact Area Start -->
	<!-- <section class="fact">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="section-heading">
						<h5 class="subtitle">
							Some Facts
						</h5>
						<h2 class="title">
							Lendbo In Numbers
						</h2>
						<p class="text">
								Lendbo has a variety of features that make it the best place to start trading
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="single-fun">
						<div class="left">
							<img src="assets/images/icon6.png" alt="">
						</div>
						<div class="right">
							<h4 class="title">
								$840K
							</h4>
							<p class="sub-title">
								LOANS
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="single-fun">
						<div class="left">
							<img src="assets/images/icon7.png" alt="">
						</div>
						<div class="right">
							<h4 class="title">
								$2.42M
							</h4>
							<p class="sub-title">
								RESERVES
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="single-fun">
						<div class="left">
							<img src="assets/images/icon8.png" alt="">
						</div>
						<div class="right">
							<h4 class="title">
								3046
							</h4>
							<p class="sub-title">
								ORDERS
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- fact Area End -->

	<!-- How it work Area Start -->
	<!-- <section class="how-it-work">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="section-heading">
						<h5 class="subtitle">
								Try To Check Out
						</h5>
						<h2 class="title">
								How Everything Works!
						</h2>
						<p class="text">
								We help you save time and money by easily finding the best loan options. 3 simple step to get Started
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<div class="single-work">
						<div class="icon">
							<img src="assets/images/how-work1.png" alt="">
						</div>
						<div class="content">
							<span class="num">01</span>
							<h4 class="title">
								Register
								within a minute
							</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-work">
						<div class="icon">
							<img src="assets/images/how-work2.png" alt="">
						</div>
						<div class="content">
							<span class="num">02</span>
							<h4 class="title">
									Deposit &
									collateral
							</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-work">
						<div class="icon">
							<img src="assets/images/how-work3.png" alt="">
						</div>
						<div class="content">
							<span class="num">03</span>
							<h4 class="title">
									Confirm the loan terms 
									
							</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- How it work Area End -->

	<!-- Get Start Area Start -->
	<!-- <section class="get-start">
		<div class="container">
			<div class="row">
				<div class="col-lg-5">
					<div class="left-image">
						<img src="assets/images/get-start.png" alt="">
					</div>
				</div>
				<div class="col-lg-7">
					<div class="rihgt-area">
						<div class="section-heading">
							<h5 class="subtitle extra-padding">
								Ready To Start
							</h5>
							<h2 class="title  extra-padding">
								Lending Or Borrowing
							</h2>
							<p class="text">
									What Are You Waiting For? Make Things Happen The Way
									You Want With Lendbo!
							</p>
							<a href="#" class="mybtn1">Get Started Today</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- Get Start Area End -->

	<!-- Testimonial Area Start -->
	<!-- <section class="testimonial">
		<div class="testimonial-top-area">
			<img class="shape" src="assets/images/testi-shape.png" alt="">
			<div class="container">
				<div class="row">
					<div class="col-lg-7 d-flex align-self-center">
						<div class="left-area">
							<div class="section-heading">
								<h5 class="subtitle extra-padding">
										Don‘t Take Our Word For It
								</h5>
								<h2 class="title  extra-padding">
										Take Our Customers
								</h2>
								<p class="text">
										Over 7,000 Happy Customers.We have many
										happy investors invest with us .Some impresions
										from our Customers!  PLease read some of the
										lovely things our Customers say about us.
								</p>
								<a href="#" class="mybtn1">WHAT WE OFFER</a>
							</div>
						</div>
					</div>
					<div class="col-lg-5 d-flex align-self-center">
						<div class="right-img">
							<img src="assets/images/testimonial-right.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="testimonial-review-area">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="testimonial-review-box">
							<div class="row">
								<div class="col-lg-12">
									<div class="header-area">
										<div class="reating">
											<span class="info">Excellent</span>
											<ul class="stars">
												<li>
													<i class="fas fa-star"></i>
												</li>
												<li>
													<i class="fas fa-star"></i>
												</li>
												<li>
													<i class="fas fa-star"></i>
												</li>
												<li>
													<i class="fas fa-star"></i>
												</li>
											</ul>
										</div>
										<p class="reating-info-text">
											Rated 4.8 out of 5 based on 613 reviews
										</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="review-slider">
										<div class="single-review">
											<div class="text-box">
												<ul class="stars">
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
												</ul>
												<h4 class="subject">
													Financing Made Simple!
												</h4>
												<p class="text">
													love this company, Approval was very fast, i got my fund under 24hrs. Easy to work with, i recommend this 
													company to anyone looking for business capital.
												</p>
											</div>
											<div class="reviewer-box">
												<div class="img">
													<img src="assets/images/review.png" alt="">
												</div>
												<h4 class="name">
													Andrew Sanchez 
												</h4>
												<p class="info">
													United kingdom, 28th May,2019
												</p>
											</div>
										</div>
										<div class="single-review">
											<div class="text-box">
												<ul class="stars">
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
												</ul>
												<h4 class="subject">
													Financing Made Simple!
												</h4>
												<p class="text">
													love this company, Approval was very fast, i got my fund under 24hrs. Easy to work with, i recommend this 
													company to anyone looking for business capital.
												</p>
											</div>
											<div class="reviewer-box">
												<div class="img">
													<img src="assets/images/review.png" alt="">
												</div>
												<h4 class="name">
												William Murphy
												</h4>
												<p class="info">
													United kingdom, 28th May,2019
												</p>
											</div>
										</div>
										<div class="single-review">
											<div class="text-box">
												<ul class="stars">
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
													<li>
														<i class="fas fa-star"></i>
													</li>
												</ul>
												<h4 class="subject">
													Financing Made Simple!
												</h4>
												<p class="text">
													love this company, Approval was very fast, i got my fund under 24hrs. Easy to work with, i recommend this 
													company to anyone looking for business capital.
												</p>
											</div>
											<div class="reviewer-box">
												<div class="img">
													<img src="assets/images/review.png" alt="">
												</div>
												<h4 class="name">
												Stephen Bailey
												</h4>
												<p class="info">
													United kingdom, 28th May,2019
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- Testimonial Area End -->

	<!-- Partner Area Start -->
	<!-- <section class="partner">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 d-flex">
					<div class="left-area">
						<ul class="patner-list">
							<li>
								<a href="#">
									<img src="assets/images/patner.png" alt="">
								</a>
							</li>
							<li>
								<a href="#">
									<img src="assets/images/patner.png" alt="">
								</a>
							</li>
							<li>
								<a href="#">
									<img src="assets/images/patner.png" alt="">
								</a>
							</li>
							<li>
								<a href="#">
									<img src="assets/images/patner.png" alt="">
								</a>
							</li>
							<li>
								<a href="#">
									<img src="assets/images/patner.png" alt="">
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-7 order-first order-lg-last">
					<div class="right-area">
						<div class="section-heading">
							<h5 class="subtitle">
								Let’s See Our
							</h5>
							<h2 class="title">
								Trusted Partners
							</h2>
							<p class="text">
								We’re committed to making our clients successful by becoming their partners and trusted advisors .Lendbo  believes in being your trusted partner and earning that trust through confidence  
								and performance in service and support. 
							</p>
							<a href="#" class="mybtn1">
								Join With US
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- Partner Area End -->
@endsection