@extends('layouts.layout')

@section('title') Currency Exchange @endsection

@section('content')
	<!-- Breadcrumb Area Start -->
	<section class="breadcrumb-area extra-extra-padding">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="title">
						Lend
					</h4>
					<ul class="breadcrumb-list">
						<li>
							<a href="index.html">
									<i class="fas fa-home"></i>
									Home
							</a>
						</li>
						<li>
							<span><i class="fas fa-chevron-right"></i> </span>
						</li>
						<li>
							<a href="borrow.html">Lend</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- Breadcrumb Area End -->

	<!-- calculator Area End -->
	<div class="calculator">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="calculator-box">
						<div class="row">
							<div class="col-lg-12">
								<form action="#" method="">
									@csrf
									<ul class="list">
										<li class="enter-amount">
											<label>Amount</label>
											<input type="text" value="" placeholder="Enter Amount">
										</li>
										<li class="from-currency">
											<label>From</label>
											<select name="from-currency" class="form-control" style="margin-top: 6px;">
												<option>-Select Any Currency-</option>
												<option value="PM">PM</option>
												<option value="BTC">BTC</option>
												<option value="Naira">Naira</option>
											</select>
										</li>
										<li class="to-currency">
											<label>To</label>
											<div class="form-group">
												<select name="to-currency" class="form-control" style="margin-top: 6px;">
													<option>-Select Any Currency-</option>
													<option value="PM">PM</option>
													<option value="BTC">BTC</option>
													<option value="Naira">Naira</option>
												</select>
											</div>
										</li>
										<li class="button">
											<button type="submit" name="submit" class="mybtn1">Get Started </button>
										</li>
									</ul>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- calculator Area End -->

	<!-- lend Area Start -->
	<section class="lend lend-page">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="section-heading">
						<h5 class="subtitle extra-padding">
							The Most Trusted
						</h5>
						<h2 class="title extra-padding">
							Way to Lend
						</h2>
						<p class="text">
								Deposit crypto assets & earn interest on your reserves.
								Try to check out Lending Rate
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
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
	</section>
	<!-- lend Area End -->

	<!-- Get Start Area2 Start -->
	<section class="get-start2">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="section-heading">
						<h5 class="subtitle">
							Get started
						</h5>
						<h2 class="title">
							In a few minutes
						</h2>
						<p class="text">
							Lendbo supports a variety of the most popular digital currencies.
							Deposit crypto assets & earn interest on your reserves.
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<div class="single-work">
						<div class="icon">
							<img src="assets/images/gs1.png" alt="">
						</div>
						<div class="content">
							<span class="num">01</span>
							<h4 class="title">
								Fund Account
							</h4>
							<p class="text">
								Signup and add crypto tokens to your smart account
 								to get started
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-work">
						<div class="icon">
							<img src="assets/images/gs2.png" alt="">
						</div>
						<div class="content">
							<span class="num">02</span>
							<h4 class="title">
								Create Reserve
							</h4>
							<p class="text">
								Signup and add crypto tokens to your smart account
 								to get started
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-work">
						<div class="icon">
							<img src="assets/images/gs3.png" alt="">
						</div>
						<div class="content">
							<span class="num">03</span>
							<h4 class="title">
								Earn Interest
							</h4>
							<p class="text">
								Signup and add crypto tokens to your smart account
 								to get started
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Get Start Area2 End -->

	<!-- Check Questions Area Start -->
	<section class="check-questions">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-5 d-flex align-self-center">
					<div class="left-image">
						<img src="assets/images/cq-img.png" alt="">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="rihgt-area">
						<div class="section-heading">
							<h5 class="subtitle extra-padding">
								If you have any
							</h5>
							<h2 class="title  extra-padding">
								Questions
							</h2>
							<p class="text">
								Our top priorities are to protect your privacy, 
								provide secure  transactions, and  safeguard your
								data. When you're ready to play, registering an
								account is required so we know you're of legal
								age and so no one else can use your account.We
								answer the most commonly asked questions
							</p>
							<a href="#" class="mybtn1">Check FAQs</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Check Questions Area End -->

	<!-- Get Start Area Start -->
	<section class="get-start">
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
	</section>
	<!-- Get Start Area End -->
@endsection