@extends('admin.layouts.layout')

@section('title') Profile | {{ config('app.name','eCurrencyNG') }} @endsection

@section('content')

<div class="pcoded-content">
	<div class="pcoded-inner-content">
		@include('admin.includes.flash')
		<div class="main-body">
			<div class="page-wrapper">

				<div class="page-header card">
					<div class="card-block">
						<h5 class="m-b-10">User Profile</h5>
					</div>
				</div>


				<div class="page-body">


					<div class="row">
						<div class="col-lg-12">

							<div class="tab-header card">
								<ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#binfo" role="tab">Bank Info</a>
										<div class="slide"></div>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#personal"
											role="tab">Personal Info</a>
										<div class="slide"></div>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#secret_key"
											role="tab">Rubies Secret Key</a>
										<div class="slide"></div>
									</li>
								</ul>
							</div>


							<div class="tab-content">

								<div class="tab-pane" id="secret_key" role="tabpanel">
									<div class="card">
										<div class="card-header">
											<h5 class="card-header-text">Rubies Secret Key</h5>
										</div>
										<div class="card-block">
											<div class="row">
												<div class="col-md-12">
													<div class="card b-l-success business-info services m-b-20">
														<form name="profileUpdate" id="ngnupdateProfile" method="POST"
															action="{{ route('admin.profile.update',Auth::user()->id) }}">
															@method('PATCH')
															@csrf
															<div class="card-block">
																<div class="view-info">
																	<div class="row">
																		<div class="col-lg-12">
																			<div class="general-info">
																				<div class="row">
																					<div class="col-lg-12 col-xl-6">
																						<div class="table-responsive">
																							<table class="table m-0">
																								<tbody>
																									<tr>
																										<th scope="row">Secret Key</th>
																										<td><input
																												type="text"
																												name="secret_key"
																												value="{{ $other->secret_key ?? "" }}"
																												class="form-control"
																												placeholder="Enter secret key">
																										@if($errors->has('secret_key'))
																										    <div class="error">{{ $errors->first('secret_key') }}</div>
																										@endif
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">Account Number</th>
																										<td><input
																												type="text"
																												name="account_number"
																												value="{{ $other->bank_account_no ?? "" }}"
																												class="form-control"
																												placeholder="Enter account number">
																										@if($errors->has('account_number'))
																										    <div class="error">{{ $errors->first('account_number') }}</div>
																										@endif
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</div>
																					</div>
																					<div class="col-lg-12 col-xl-6">
																						<div class="table-responsive">
																							<table class="table">
																								<tbody>
																									<tr>
																										<th scope="row">Max Payout Amount</th>
																										<td><input
																												type="text"
																												name="min_amount"
																												value="{{ $other->min_amount ?? "" }}"
																												class="form-control"
																												placeholder="Enter max amount">
																										@if($errors->has('min_amount'))
																										    <div class="error">{{ $errors->first('min_amount') }}</div>
																										@endif
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Min Payout Amount
																										</th>
																										<td><input
																												type="text"
																												name="min2_amount"
																												value="{{ $other->min2_amount ?? "" }}"
																												class="form-control"
																												placeholder="Enter min payout amount">
																										@if($errors->has('min2_amount'))
																										    <div class="error">{{ $errors->first('min2_amount') }}</div>
																										@endif
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</div>
																					</div>
																					<div class="col-lg-12">
																						<div class="general-info">
																							<div class="text-center">
																								<input type="hidden"
																									name="ac_type"
																									value="4">
																								<input type="hidden"
																								name="bank_info"
																								value="bank_info">
																								<input type="submit"
																									class="btn btn-primary waves-effect waves-light m-r-20"
																									value="Save">
																								<a href="{{ route('admin.home') }}" id="edit-cancel"
																									class="btn btn-default waves-effect">Cancel</a>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane active" id="binfo" role="tabpanel">
									{{-- <div class="card">
										<div class="card-header">
											<h5 class="card-header-text">Nigeria Account Bank Info</h5>
										</div>
										<div class="card-block">
											<div class="row">
												<div class="col-md-12">
													<div class="card b-l-success business-info services m-b-20">
														<form name="profileUpdate" id="ngnupdateProfile" method="POST"
															action="{{ route('admin.profile.update',Auth::user()->id) }}">
															@method('PATCH')
															@csrf
															<div class="card-block">
																<div class="view-info">
																	<div class="row">
																		<div class="col-lg-12">
																			<div class="general-info">
																				<div class="row">
																					<div class="col-lg-12 col-xl-6">
																						<div class="table-responsive">
																							<table class="table m-0">
																								<tbody>
																									<!-- <tr>
																										<th scope="row">
																											Bank
																											Username
																										</th>
																										<td><input
																												type="text"
																												name="bank_username"
																												value="{{ $ngn->bank_username ?? "" }}"
																												class="form-control"
																												placeholder="Enter bank username">
																										</td>
																									</tr> -->
																									<tr>
																										<th scope="row">
																											Bank Name
																										</th>
																										<td>
																											<select name="bank_name" class="form-control">
																												<option value="">--Select Any Bank--</option>
																												@if(count($bank) > 0):
																													@foreach($bank as $key=>$val):
																														@if(isset($ngn->bank_name) && $val->bankname == $ngn->bank_name)
																															<option value="{{ $val->bankname }}" selected>{{ $val->bankname }}</option>
																														@endif
																														<option value="{{ $val->bankname }}">{{ $val->bankname }}</option>
																													@endforeach
																												@endif
																											</select>
																											@if($errors->has('bank_name'))
																											    <div class="error">{{ $errors->first('bank_name') }}</div>
																											@endif
																											<!-- <input
																												type="text"
																												name="bank_name"
																												placeholder="Enter name"
																												class="form-control"
																												value="{{ $ngn->bank_name ?? "" }}"> -->
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Bank 
																											Code</th>
																										<td><input
																												type="text"
																												name="bank_code"
																												value="{{ $ngn->bank_code ?? "" }}"
																												class="form-control"
																												placeholder="Enter bank code">
																										@if($errors->has('bank_code'))
																										    <div class="error">{{ $errors->first('bank_code') }}</div>
																										@endif
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</div>
																					</div>
																					<div class="col-lg-12 col-xl-6">
																						<div class="table-responsive">
																							<table class="table">
																								<tbody>
																									<!-- <tr>
																										<th scope="row">
																											Bank
																											Password
																										</th>
																										<td><input
																												type="password"
																												name="bank_password"
																												value="{{ $ngn->bank_password ?? "" }}"
																												class="form-control"
																												placeholder="Enter password">
																										</td>
																									</tr> -->
																									<tr>
																										<th scope="row">
																											Bank Account
																											Number</th>
																										<td><input
																												type="text"
																												name="bank_account_no"
																												value="{{ $ngn->bank_account_no ?? "" }}"
																												class="form-control"
																												placeholder="Enter bank account no">
																											@if($errors->has('bank_account_no'))
																										    	<div class="error">{{ $errors->first('bank_account_no') }}</div>
																											@endif
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-lg-12">
																			<div class="general-info">
																				<div class="text-center">
																					<input type="hidden" name="ac_type" value="1">
																					<input type="hidden"
																						name="bank_info"
																						value="bank_info">
																					<input type="submit"
																						class="btn btn-primary waves-effect waves-light m-r-20"
																						value="Save">
																					<a href="{{ route('admin.home') }}" id="edit-cancel"
																						class="btn btn-default waves-effect">Cancel</a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div> --}}
									<div class="card">
										<div class="card-header">
											<h5 class="card-header-text">Perfect Money Account Bank Info</h5>
										</div>
										<div class="card-block">
											<div class="row">
												<div class="col-md-12">
													<div class="card b-l-success business-info services m-b-20">
														<form name="profileUpdate" id="pmupdateProfile" method="POST"
															action="{{ route('admin.profile.update',Auth::user()->id) }}">
															@method('PATCH')
															@csrf
															<div class="card-block">
																<div class="view-info">
																	<div class="row">
																		<div class="col-lg-12">
																			<div class="general-info">
																				<div class="row">
																					<div class="col-lg-12 col-xl-6">
																						<div class="table-responsive">
																							<table class="table m-0">
																								<tbody>
																									<tr>
																										<th scope="row">
																											Username
																										</th>
																										<td><input
																												type="text"
																												name="bank_username"
																												value="{{ $pm->bank_username ?? "" }}"
																												class="form-control"
																												placeholder="Enter bank username">
																										@if($errors->has('bank_username'))
																										    <div class="error">{{ $errors->first('bank_username') }}</div>
																										@endif
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Bank Account
																											Number</th>
																										<td><input
																												type="text"
																												name="bank_account_no"
																												value="{{ $pm->bank_account_no ?? "" }}"
																												class="form-control"
																												placeholder="Enter bank account">
																										@if($errors->has('bank_account_no'))
																										    <div class="error">{{ $errors->first('bank_account_no') }}</div>
																										@endif
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Min Payout Amount
																										</th>
																										<td><input
																												type="text"
																												name="min2_amount"
																												value="{{ $pm->min2_amount ?? "" }}"
																												class="form-control"
																												placeholder="Enter min payout amount">
																										@if($errors->has('min2_amount'))
																										    <div class="error">{{ $errors->first('min2_amount') }}</div>
																										@endif
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</div>
																					</div>
																					<div class="col-lg-12 col-xl-6">
																						<div class="table-responsive">
																							<table class="table">
																								<tbody>
																									<tr>
																										<th scope="row">
																											Password
																										</th>
																										<td>
																											<input
																												type="password"
																												name="bank_password"
																												value="{{ $pm->bank_password ?? "" }}"
																												class="form-control"
																												placeholder="Enter password">
																										@if($errors->has('bank_password'))
																										    <div class="error">{{ $errors->first('bank_password') }}</div>
																										@endif
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Max Payout Amount
																										</th>
																										<td>
																											<input
																												type="text"
																												name="pm_min_amount"
																												value="{{ $pm->min_amount ?? "" }}"
																												class="form-control"
																												placeholder="Enter max amount">
																										@if($errors->has('min_amount'))
																										    <div class="error">{{ $errors->first('min_amount') }}</div>
																										@endif
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-lg-12">
																			<div class="general-info">
																				<div class="text-center">
																					<input type="hidden" name="ac_type" value="2">
																					<input type="hidden"
																						name="bank_info"
																						value="bank_info">
																					<input type="submit"
																						class="btn btn-primary waves-effect waves-light m-r-20"
																						value="Save">
																					<a href="{{ route('admin.home') }}" id="edit-cancel"
																						class="btn btn-default waves-effect">Cancel</a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card">
										<div class="card-header">
											<h5 class="card-header-text">Bitcoin Account Bank Info</h5>
										</div>
										<div class="card-block">
											<div class="row">
												<div class="col-md-12">
													<div class="card b-l-success business-info services m-b-20">
														<form name="profileUpdate" id="updateProfile" method="POST"
															action="{{ route('admin.profile.update',Auth::user()->id) }}">
															@method('PATCH')
															@csrf
															<div class="card-block">
																<div class="view-info">
																	<div class="row">
																		<div class="col-lg-12">
																			<div class="general-info">
																				<div class="row">
																					<div class="col-lg-12 col-xl-6">
																						<div class="table-responsive">
																							<table class="table m-0">
																								<tbody>
																									<tr>
																										<th scope="row">
																											Address
																										</th>
																										<td><input
																												type="text"
																												name="btc_address"
																												value="{{ $btc->btc_address ?? "" }}"
																												class="form-control"
																												placeholder="Enter bitcoin address">
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Api Key
																										</th>
																										<td><input
																												type="text"
																												name="secret_key"
																												placeholder="Enter secret key"
																												class="form-control"
																												value="{{ $btc->secret_key ?? "" }}">
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Wallet ID
																										</th>
																										<td><input
																												type="text"
																												name="wallet_address"
																												placeholder="Enter wallet address"
																												class="form-control"
																												value="{{ $btc->wallet_address ?? "" }}">
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Max Payout Amount
																										</th>
																										<td><input
																												type="text"
																												name="btc_min_amount"
																												placeholder="Enter max amount"
																												class="form-control"
																												value="{{ $btc->min_amount ?? "" }}">
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</div>
																					</div>
																					<div class="col-lg-12 col-xl-6">
																						<div class="table-responsive">
																							<table class="table">
																								<tbody>
																									<tr>
																										<th scope="row">
																											App Secret Key
																										</th>
																										<td><input
																												type="text"
																												name="app_secret_key"
																												value="{{ $btc->app_secret_key ?? \Str::random(20) }}"
																												class="form-control"
																												placeholder="Enter App secret key">
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											X-Pub Key
																										</th>
																										<td><input
																												type="text"
																												name="x_pub_key"
																												value="{{ $btc->pub_key ?? "" }}"
																												class="form-control"
																												placeholder="Enter x-pub key">
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Wallet Password
																										</th>
																										<td><input
																												type="text"
																												name="bank_password"
																												placeholder="Enter wallet password"
																												class="form-control"
																												value="{{ $btc->bank_password ?? "" }}">
																										</td>
																									</tr>
																									<tr>
																										<th scope="row">
																											Min Payout Amount
																										</th>
																										<td><input
																												type="text"
																												name="min2_amount"
																												value="{{ $btc->min2_amount ?? "" }}"
																												class="form-control"
																												placeholder="Enter min payout amount">
																										@if($errors->has('min2_amount'))
																										    <div class="error">{{ $errors->first('min2_amount') }}</div>
																										@endif
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-lg-12">
																			<div class="general-info">
																				<p class="text-danger">Wallets that require email authorization are currently not supported in the Wallet API. Please disable this in your wallet settings, or add the IP address of this server to your wallet IP whitelist.<br>
																				Goto wallet >security> advance add server ip in whitelist ip<br>
																				 E.g 157.%.%.%
																				</p>
																				<div class="text-center">
																					<input type="hidden" name="ac_type" value="3">
																					<input type="hidden"
																						name="bank_info"
																						value="bank_info">
																					<input type="submit"
																						class="btn btn-primary waves-effect waves-light m-r-20"
																						value="Save">
																					<a href="{{ route('admin.home') }}" id="edit-cancel"
																						class="btn btn-default waves-effect">Cancel</a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="personal" role="tabpanel">

									<div class="card">
										<div class="card-header">
											<h5 class="card-header-text">About Me</h5>
										</div>
										<form name="profileUpdate" id="updateProfile" method="POST"
											action="{{ route('admin.profile.update',Auth::user()->id) }}">
											@method('PATCH')
											@csrf
											<div class="card-block">
												<div class="view-info">
													<div class="row">
														<div class="col-lg-12">
															<div class="general-info">
																<div class="row">
																	<div class="col-lg-12 col-xl-6">
																		<div class="table-responsive">
																			<table class="table m-0">
																				<tbody>
																					<tr>
																						<th scope="row">Full Name</th>
																						<td><input type="text"
																								name="name"
																								value="{{ Auth::user()->name }}"
																								class="form-control"
																								placeholder="Enter name">
																						</td>
																					</tr>
																					<tr>
																						<th scope="row">Mobile Number
																						</th>
																						<td><input type="text"
																								name="mobile"
																								placeholder="Enter number"
																								class="form-control"
																								value="{{ Auth::user()->mobile }}">
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</div>
																	</div>
																	<div class="col-lg-12 col-xl-6">
																		<div class="table-responsive">
																			<table class="table">
																				<tbody>
																					<tr>
																						<th scope="row">Email</th>
																						<td><input type="email"
																								name="email"
																								placeholder="Enter email"
																								class="form-control"
																								value="{{ Auth::user()->email ?? "" }}">
																						</td>
																					</tr>
																					@if($errors->has('email'))
														                            	<strong style="color: red;">{{ $errors->first('email') }}</strong>
														                            @endif
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-lg-12">
															<div class="general-info">
																<div class="text-center">
																	<input type="hidden" name="personal"
																		value="personal">
																	<input type="submit"
																		class="btn btn-primary waves-effect waves-light m-r-20"
																		value="Save">
																	<a href="#!" id="edit-cancel"
																		class="btn btn-default waves-effect">Cancel</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>

									</div>
								</div>


								<div class="tab-pane" id="contacts" role="tabpanel">
									<div class="row">
										<div class="col-xl-3">

											<div class="card">
												<div class="card-header contact-user">
													<img class="img-radius img-40"
														src="../files/assets/images/avatar-4.jpg" alt="contact-user">
													<h5 class="m-l-10">John Doe</h5>
												</div>
												<div class="card-block">
													<ul class="list-group list-contacts">
														<li class="list-group-item active"><a href="#">All Contacts</a>
														</li>
														<li class="list-group-item"><a href="#">Recent Contacts</a></li>
														<li class="list-group-item"><a href="#">Favourite Contacts</a>
														</li>
													</ul>
												</div>
												<div class="card-block groups-contact">
													<h4>Groups</h4>
													<ul class="list-group">
														<li class="list-group-item justify-content-between">
															Project
															<span class="badge badge-primary badge-pill">30</span>
														</li>
														<li class="list-group-item justify-content-between">
															Notes
															<span class="badge badge-success badge-pill">20</span>
														</li>
														<li class="list-group-item justify-content-between">
															Activity
															<span class="badge badge-info badge-pill">100</span>
														</li>
														<li class="list-group-item justify-content-between">
															Schedule
															<span class="badge badge-danger badge-pill">50</span>
														</li>
													</ul>
												</div>
											</div>
											<div class="card">
												<div class="card-header">
													<h4 class="card-title">Contacts<span class="f-15"> (100)</span></h4>
												</div>
												<div class="card-block">
													<div class="connection-list">
														<a href="#"><img class="img-fluid img-radius"
																src="../files/assets/images/user-profile/follower/f-1.jpg"
																alt="f-1" data-toggle="tooltip" data-placement="top"
																data-original-title="Airi Satou">
														</a>
														<a href="#"><img class="img-fluid img-radius"
																src="../files/assets/images/user-profile/follower/f-2.jpg"
																alt="f-2" data-toggle="tooltip" data-placement="top"
																data-original-title="Angelica Ramos">
														</a>
														<a href="#"><img class="img-fluid img-radius"
																src="../files/assets/images/user-profile/follower/f-3.jpg"
																alt="f-3" data-toggle="tooltip" data-placement="top"
																data-original-title="Ashton Cox">
														</a>
														<a href="#"><img class="img-fluid img-radius"
																src="../files/assets/images/user-profile/follower/f-4.jpg"
																alt="f-4" data-toggle="tooltip" data-placement="top"
																data-original-title="Cara Stevens">
														</a>
														<a href="#"><img class="img-fluid img-radius"
																src="../files/assets/images/user-profile/follower/f-5.jpg"
																alt="f-5" data-toggle="tooltip" data-placement="top"
																data-original-title="Garrett Winters">
														</a>
														<a href="#"><img class="img-fluid img-radius"
																src="../files/assets/images/user-profile/follower/f-1.jpg"
																alt="f-6" data-toggle="tooltip" data-placement="top"
																data-original-title="Cedric Kelly">
														</a>
														<a href="#"><img class="img-fluid img-radius"
																src="../files/assets/images/user-profile/follower/f-3.jpg"
																alt="f-7" data-toggle="tooltip" data-placement="top"
																data-original-title="Brielle Williamson">
														</a>
														<a href="#"><img class="img-fluid img-radius"
																src="../files/assets/images/user-profile/follower/f-5.jpg"
																alt="f-8" data-toggle="tooltip" data-placement="top"
																data-original-title="Jena Gaines">
														</a>
													</div>
												</div>
											</div>

										</div>
										<div class="col-xl-9">
											<div class="row">
												<div class="col-sm-12">

													<div class="card">
														<div class="card-header">
															<h5 class="card-header-text">Contacts</h5>
														</div>
														<div class="card-block contact-details">
															<div class="data_table_main table-responsive dt-responsive">
																<table id="simpletable"
																	class="table  table-striped table-bordered nowrap">
																	<thead>
																		<tr>
																			<th>Name</th>
																			<th>Email</th>
																			<th>Mobileno.</th>
																			<th>Favourite</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="18797a7b292a2b587f75797174367b7775">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="9efffcfdafacaddef9f3fff7f2b0fdf1f3">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star-o"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="9afbf8f9aba8a9dafdf7fbf3f6b4f9f5f7">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="accdcecf9d9e9feccbc1cdc5c082cfc3c1">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="ed8c8f8edcdfdead8a808c8481c38e8280">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star-o"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="5a3b38396b68691a3d373b333674393537">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="9bfaf9f8aaa9a8dbfcf6faf2f7b5f8f4f6">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="3f5e5d5c0e0d0c7f58525e5653115c5052">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="e1808382d0d3d2a1868c80888dcf828e8c">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="e7868584d6d5d4a7808a868e8bc984888a">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star-o"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="1b7a79782a29285b7c767a727735787476">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="88e9eaebb9babbc8efe5e9e1e4a6ebe7e5">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="93f2f1f0a2a1a0d3f4fef2faffbdf0fcfe">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="f0919293c1c2c3b0979d91999cde939f9d">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="5a3b38396b68691a3d373b333674393537">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star-o"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="d9b8bbbae8ebea99beb4b8b0b5f7bab6b4">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="0766656436353447606a666e6b2964686a">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star-o"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="4726252476757407202a262e2b6924282a">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="c8a9aaabf9fafb88afa5a9a1a4e6aba7a5">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="1e7f7c7d2f2c2d5e79737f7772307d7173">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star-o"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="8feeedecbebdbccfe8e2eee6e3a1ece0e2">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="e2838081d3d0d1a2858f838b8ecc818d8f">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="ef8e8d8cdedddcaf88828e8683c18c8082">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star-o"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="79181b1a484b4a391e14181015571a1614">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="4120232270737201262c20282d6f222e2c">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="4e2f2c2d7f7c7d0e29232f2722602d2123">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="94f5f6f7a5a6a7d4f3f9f5fdf8baf7fbf9">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="fa9b9899cbc8c9ba9d979b9396d4999597">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="c7a6a5a4f6f5f487a0aaa6aeabe9a4a8aa">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="e0818283d1d2d3a0878d81898cce838f8d">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="6001020351525320070d01090c4e030f0d">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="e0818283d1d2d3a0878d81898cce838f8d">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="7f1e1d1c4e4d4c3f18121e1613511c1012">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="fb9a9998cac9c8bb9c969a9297d5989496">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="8cedeeefbdbebfccebe1ede5e0a2efe3e1">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="6c0d0e0f5d5e5f2c0b010d0500420f0301">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="55343736646766153238343c397b363a38">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="2746454416151467404a464e4b0944484a">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="abcac9c89a9998ebccc6cac2c785c8c4c6">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="3657545507040576515b575f5a1855595b">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="0e6f6c6d3f3c3d4e69636f6762206d6163">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="c7a6a5a4f6f5f487a0aaa6aeabe9a4a8aa">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="bedfdcdd8f8c8dfed9d3dfd7d290ddd1d3">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="a1c0c3c2909392e1c6ccc0c8cd8fc2cecc">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="b7d6d5d4868584f7d0dad6dedb99d4d8da">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="19787b7a282b2a597e74787075377a7674">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="7a1b18194b48493a1d171b131654191517">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="bedfdcdd8f8c8dfed9d3dfd7d290ddd1d3">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="6001020351525320070d01090c4e030f0d">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="4322212072717003242e222a2f6d202c2e">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td>Garrett Winters</td>
																			<td><a href="http://html.codedthemes.com/cdn-cgi/l/email-protection"
																					class="__cf_email__"
																					data-cfemail="ddbcbfbeecefee9dbab0bcb4b1f3beb2b0">[email&#160;protected]</a>
																			</td>
																			<td>9989988988</td>
																			<td><i class="fa fa-star"
																					aria-hidden="true"></i></td>
																			<td class="dropdown">
																				<button type="button"
																					class="btn btn-primary dropdown-toggle"
																					data-toggle="dropdown"
																					aria-haspopup="true"
																					aria-expanded="false"><i
																						class="fa fa-cog"
																						aria-hidden="true"></i></button>
																				<div
																					class="dropdown-menu dropdown-menu-right b-none contact-menu">
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-edit"></i>Edit</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-delete"></i>Delete</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye-alt"></i>View</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-tasks-alt"></i>Project</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-ui-note"></i>Notes</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-eye"></i>Activity</a>
																					<a class="dropdown-item"
																						href="#!"><i
																							class="icofont icofont-badge"></i>Schedule</a>
																				</div>
																			</td>
																		</tr>
																	</tbody>
																	<tfoot>
																		<tr>
																			<th>Name</th>
																			<th>Email</th>
																			<th>Mobileno.</th>
																			<th>Favourite</th>
																			<th>Action</th>
																		</tr>
																	</tfoot>
																</table>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="review" role="tabpanel">
									<div class="card">
										<div class="card-header">
											<h5 class="card-header-text">Review</h5>
										</div>
										<div class="card-block">
											<ul class="media-list">
												<li class="media">
													<div class="media-left">
														<a href="#">
															<img class="media-object img-radius comment-img"
																src="../files/assets/images/avatar-1.jpg"
																alt="Generic placeholder image">
														</a>
													</div>
													<div class="media-body">
														<h6 class="media-heading">Sortino media<span
																class="f-12 text-muted m-l-5">Just now</span></h6>
														<div class="stars-example-css review-star">
															<i class="icofont icofont-star"></i>
															<i class="icofont icofont-star"></i>
															<i class="icofont icofont-star"></i>
															<i class="icofont icofont-star"></i>
															<i class="icofont icofont-star"></i>
														</div>
														<p class="m-b-0">Cras sit amet nibh libero, in gravida nulla.
															Nulla vel metus scelerisque ante sollicitudin commodo. Cras
															purus odio, vestibulum in vulputate at, tempus viverra
															turpis.</p>
														<div class="m-b-25">
															<span><a href="#!"
																	class="m-r-10 f-12">Reply</a></span><span><a
																	href="#!" class="f-12">Edit</a> </span>
														</div>
														<hr>

														<div class="media mt-2">
															<a class="media-left" href="#">
																<img class="media-object img-radius comment-img"
																	src="../files/assets/images/avatar-2.jpg"
																	alt="Generic placeholder image">
															</a>
															<div class="media-body">
																<h6 class="media-heading">Larry heading <span
																		class="f-12 text-muted m-l-5">Just now</span>
																</h6>
																<div class="stars-example-css review-star">
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																</div>
																<p class="m-b-0"> Cras sit amet nibh libero, in gravida
																	nulla. Nulla vel metus scelerisque ante sollicitudin
																	commodo. Cras purus odio, vestibulum in vulputate
																	at, tempus viverra turpis.</p>
																<div class="m-b-25">
																	<span><a href="#!"
																			class="m-r-10 f-12">Reply</a></span><span><a
																			href="#!" class="f-12">Edit</a> </span>
																</div>
																<hr>

																<div class="media mt-2">
																	<div class="media-left">
																		<a href="#">
																			<img class="media-object img-radius comment-img"
																				src="../files/assets/images/avatar-3.jpg"
																				alt="Generic placeholder image">
																		</a>
																	</div>
																	<div class="media-body">
																		<h6 class="media-heading">Colleen Hurst <span
																				class="f-12 text-muted m-l-5">Just
																				now</span></h6>
																		<div class="stars-example-css review-star">
																			<i class="icofont icofont-star"></i>
																			<i class="icofont icofont-star"></i>
																			<i class="icofont icofont-star"></i>
																			<i class="icofont icofont-star"></i>
																			<i class="icofont icofont-star"></i>
																		</div>
																		<p class="m-b-0">Cras sit amet nibh libero, in
																			gravida nulla. Nulla vel metus scelerisque
																			ante sollicitudin commodo. Cras purus odio,
																			vestibulum in vulputate at, tempus viverra
																			turpis.</p>
																		<div class="m-b-25">
																			<span><a href="#!"
																					class="m-r-10 f-12">Reply</a></span><span><a
																					href="#!" class="f-12">Edit</a>
																			</span>
																		</div>
																	</div>
																	<hr>
																</div>
															</div>
														</div>

														<div class="media mt-2">
															<div class="media-left">
																<a href="#">
																	<img class="media-object img-radius comment-img"
																		src="../files/assets/images/avatar-1.jpg"
																		alt="Generic placeholder image">
																</a>
															</div>
															<div class="media-body">
																<h6 class="media-heading">Cedric Kelly<span
																		class="f-12 text-muted m-l-5">Just now</span>
																</h6>
																<div class="stars-example-css review-star">
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																</div>
																<p class="m-b-0">Cras sit amet nibh libero, in gravida
																	nulla. Nulla vel metus scelerisque ante sollicitudin
																	commodo. Cras purus odio, vestibulum in vulputate
																	at, tempus viverra turpis.</p>
																<div class="m-b-25">
																	<span><a href="#!"
																			class="m-r-10 f-12">Reply</a></span><span><a
																			href="#!" class="f-12">Edit</a> </span>
																</div>
																<hr>
															</div>
														</div>
														<div class="media mt-2">
															<a class="media-left" href="#">
																<img class="media-object img-radius comment-img"
																	src="../files/assets/images/avatar-4.jpg"
																	alt="Generic placeholder image">
															</a>
															<div class="media-body">
																<h6 class="media-heading">Larry heading <span
																		class="f-12 text-muted m-l-5">Just now</span>
																</h6>
																<div class="stars-example-css review-star">
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																</div>
																<p class="m-b-0"> Cras sit amet nibh libero, in gravida
																	nulla. Nulla vel metus scelerisque ante sollicitudin
																	commodo. Cras purus odio, vestibulum in vulputate
																	at, tempus viverra turpis.</p>
																<div class="m-b-25">
																	<span><a href="#!"
																			class="m-r-10 f-12">Reply</a></span><span><a
																			href="#!" class="f-12">Edit</a> </span>
																</div>
																<hr>

																<div class="media mt-2">
																	<div class="media-left">
																		<a href="#">
																			<img class="media-object img-radius comment-img"
																				src="../files/assets/images/avatar-3.jpg"
																				alt="Generic placeholder image">
																		</a>
																	</div>
																	<div class="media-body">
																		<h6 class="media-heading">Colleen Hurst <span
																				class="f-12 text-muted m-l-5">Just
																				now</span></h6>
																		<div class="stars-example-css review-star">
																			<i class="icofont icofont-star"></i>
																			<i class="icofont icofont-star"></i>
																			<i class="icofont icofont-star"></i>
																			<i class="icofont icofont-star"></i>
																			<i class="icofont icofont-star"></i>
																		</div>
																		<p class="m-b-0">Cras sit amet nibh libero, in
																			gravida nulla. Nulla vel metus scelerisque
																			ante sollicitudin commodo. Cras purus odio,
																			vestibulum in vulputate at, tempus viverra
																			turpis.</p>
																		<div class="m-b-25">
																			<span><a href="#!"
																					class="m-r-10 f-12">Reply</a></span><span><a
																					href="#!" class="f-12">Edit</a>
																			</span>
																		</div>
																	</div>
																	<hr>
																</div>
															</div>
														</div>
														<div class="media mt-2">
															<div class="media-left">
																<a href="#">
																	<img class="media-object img-radius comment-img"
																		src="../files/assets/images/avatar-2.jpg"
																		alt="Generic placeholder image">
																</a>
															</div>
															<div class="media-body">
																<h6 class="media-heading">Mark Doe<span
																		class="f-12 text-muted m-l-5">Just now</span>
																</h6>
																<div class="stars-example-css review-star">
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																	<i class="icofont icofont-star"></i>
																</div>
																<p class="m-b-0">Cras sit amet nibh libero, in gravida
																	nulla. Nulla vel metus scelerisque ante sollicitudin
																	commodo. Cras purus odio, vestibulum in vulputate
																	at, tempus viverra turpis.</p>
																<div class="m-b-25">
																	<span><a href="#!"
																			class="m-r-10 f-12">Reply</a></span><span><a
																			href="#!" class="f-12">Edit</a> </span>
																</div>
																<hr>
															</div>
														</div>
													</div>
												</li>
											</ul>
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Right addon">
												<span class="input-group-addon"><i
														class="icofont icofont-send-mail"></i></span>
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

		<div id="styleSelector"></div>
	</div>
</div>
</div>
</div>
</div>
</div>
@endsection