@extends('admin.layouts.layout')

@section('title') Dashboard | {{ config('app.name', 'eCurrencyNG') }} @endsection

@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-body">
                    <div class="row">
                        <?php //print_r($data);die; ?>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-c-blue order-card">
                                <div class="card-block">
                                    <h6 class="m-b-20">Total Transaction</h6>
                                    <h2 class="text-right"><i class="ti-shopping-cart f-left"></i><span>{{ $data["total"] }}</span></h2>
                                    <p class="m-b-0">This Month<span class="f-right">{{ $data["month_total"] }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-c-green order-card">
                                <div class="card-block">
                                    <h6 class="m-b-20">Success Transaction</h6>
                                    <h2 class="text-right"><i class="ti-tag f-left"></i><span>{{ $data["success"] }}</span></h2>
                                    <p class="m-b-0">This Month<span class="f-right">{{ $data["month_success"] }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-c-yellow order-card">
                                <div class="card-block">
                                    <h6 class="m-b-20">Pending Transaction</h6>
                                    <h2 class="text-right"><i class="ti-wallet f-left"></i><span>{{ $data["pending"] }}</span></h2>
                                    <p class="m-b-0">This Month<span class="f-right">{{ $data["month_pending"] }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-c-pink order-card">
                                <div class="card-block">
                                    <h6 class="m-b-20">Reject Transaction</h6>
                                    <h2 class="text-right"><i class="ti-reload f-left"></i><span>{{ $data["reject"] }}</span></h2>
                                    <p class="m-b-0">This Month<span class="f-right">{{ $data["month_reject"] }}</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12"></div>
                        <div class="col-lg-4 col-md-12 pt-5 mt-5">
                            <h4 class="text-center">Comming Soon</h4>
                        </div>
                        <div class="col-lg-4 col-md-12"></div>
                        <!-- <div class="col-lg-8 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Statistics</h5>
                                    <span class="text-muted">Get 15% Off on <a href="https://www.amcharts.com/"
                                            target="_blank">amCharts</a> licences. Use code "codedthemes" and get the
                                        discount.</span>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="fa fa-chevron-left"></i></li>
                                            <li><i class="fa fa-window-maximize full-card"></i></li>
                                            <li><i class="fa fa-minus minimize-card"></i></li>
                                            <li><i class="fa fa-refresh reload-card"></i></li>
                                            <li><i class="fa fa-times close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div id="Statistics-chart" style="height:200px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Customer Feedback</h5>
                                </div>
                                <div class="card-block">
                                    <span class="d-block text-c-blue f-24 f-w-600 text-center">365247</span>
                                    <canvas id="feedback-chart" height="100"></canvas>
                                    <div class="row justify-content-center m-t-15">
                                        <div class="col-auto b-r-default m-t-5 m-b-5">
                                            <h4>83%</h4>
                                            <p class="text-success m-b-0"><i class="ti-hand-point-up m-r-5"></i>Positive
                                            </p>
                                        </div>
                                        <div class="col-auto m-t-5 m-b-5">
                                            <h4>17%</h4>
                                            <p class="text-danger m-b-0"><i
                                                    class="ti-hand-point-down m-r-5"></i>Negative</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card seo-card">
                                <div class="card-block seo-statustic">
                                    <i class="ti-server text-c-green"></i>
                                    <h5>65%</h5>
                                    <p>Memory</p>
                                </div>
                                <div class="seo-chart">
                                    <canvas id="seo-card1"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card seo-card">
                                <div class="card-block seo-statustic">
                                    <i class="ti-reload text-c-blue"></i>
                                    <h5>$46,845</h5>
                                    <p>Revenue</p>
                                </div>
                                <div class="seo-chart">
                                    <canvas id="seo-card2"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card seo-card">
                                <img src="{{ asset('admin_assets/assets/images/widget/seoimg2.jpg') }}" alt="seo bg"
                                    class="img-fluid">
                                <div class="overlay-bg"></div>
                                <div class="card-block seo-content">
                                    <h6>New Users</h6>
                                    <p class="m-b-5 m-t-30"><i class="fa fa-caret-up text-c-green m-r-10"></i> +52%</p>
                                    <p class="m-b-0">Calculated in 7 days</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card seo-card">
                                <img src="{{ asset('admin_assets/assets/images/widget/seoimg3.jpg') }}" alt="seo bg"
                                    class="img-fluid">
                                <div class="overlay-bg"></div>
                                <div class="card-block seo-content">
                                    <h6>Bounce Rate</h6>
                                    <p class="m-b-5 m-t-30"><i class="fa fa-caret-down text-c-pink m-r-10"></i> -82%</p>
                                    <p class="m-b-0">Calculated in 7 days</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="card tabs-card">
                                <div class="card-block p-0">

                                    <ul class="nav nav-tabs md-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home3" role="tab"><i
                                                    class="fa fa-home"></i>Home</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#profile3" role="tab"><i
                                                    class="fa fa-key"></i>Security</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#messages3" role="tab"><i
                                                    class="fa fa-play-circle"></i>Entertainment</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#settings3" role="tab"><i
                                                    class="fa fa-database"></i>Big Data</a>
                                            <div class="slide"></div>
                                        </li>
                                    </ul>

                                    <div class="tab-content card-block">
                                        <div class="tab-pane active" id="home3" role="tabpanel">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Product Code</th>
                                                        <th>Customer</th>
                                                        <th>Purchased On</th>
                                                        <th>Status</th>
                                                        <th>Transaction ID</th>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="{{ asset('admin_assets/assets/images/product/prod2.jpg') }}"
                                                                alt="prod img" class="img-fluid"></td>
                                                        <td>PNG002344</td>
                                                        <td>John Deo</td>
                                                        <td>05-01-2017</td>
                                                        <td><span class="label label-danger">Failed</span></td>
                                                        <td>#7234486</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="{{ asset('admin_assets/assets/images/product/prod3.jpg') }}"
                                                                alt="prod img" class="img-fluid"></td>
                                                        <td>PNG002653</td>
                                                        <td>Eugine Turner</td>
                                                        <td>04-01-2017</td>
                                                        <td><span class="label label-success">Delivered</span></td>
                                                        <td>#7234417</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="{{ asset('admin_assets/assets/images/product/prod4.jpg') }}"
                                                                alt="prod img" class="img-fluid"></td>
                                                        <td>PNG002156</td>
                                                        <td>Jacqueline Howell</td>
                                                        <td>03-01-2017</td>
                                                        <td><span class="label label-warning">Pending</span></td>
                                                        <td>#7234454</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load
                                                    More</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="profile3" role="tabpanel">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Product Code</th>
                                                        <th>Customer</th>
                                                        <th>Purchased On</th>
                                                        <th>Status</th>
                                                        <th>Transaction ID</th>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="{{ asset('admin_assets/assets/images/product/prod3.jpg') }}"
                                                                alt="prod img" class="img-fluid"></td>
                                                        <td>PNG002653</td>
                                                        <td>Eugine Turner</td>
                                                        <td>04-01-2017</td>
                                                        <td><span class="label label-success">Delivered</span></td>
                                                        <td>#7234417</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="{{ asset('admin_assets/assets/images/product/prod4.jpg') }}"
                                                                alt="prod img" class="img-fluid"></td>
                                                        <td>PNG002156</td>
                                                        <td>Jacqueline Howell</td>
                                                        <td>03-01-2017</td>
                                                        <td><span class="label label-warning">Pending</span></td>
                                                        <td>#7234454</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load
                                                    More</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="messages3" role="tabpanel">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Product Code</th>
                                                        <th>Customer</th>
                                                        <th>Purchased On</th>
                                                        <th>Status</th>
                                                        <th>Transaction ID</th>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="{{ asset('admin_assets/assets/images/product/prod1.jpg') }}"
                                                                alt="prod img" class="img-fluid"></td>
                                                        <td>PNG002413</td>
                                                        <td>Jane Elliott</td>
                                                        <td>06-01-2017</td>
                                                        <td><span class="label label-primary">Shipping</span></td>
                                                        <td>#7234421</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="{{ asset('admin_assets/assets/images/product/prod4.jpg') }}"
                                                                alt="prod img" class="img-fluid"></td>
                                                        <td>PNG002156</td>
                                                        <td>Jacqueline Howell</td>
                                                        <td>03-01-2017</td>
                                                        <td><span class="label label-warning">Pending</span></td>
                                                        <td>#7234454</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load
                                                    More</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="settings3" role="tabpanel">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Product Code</th>
                                                        <th>Customer</th>
                                                        <th>Purchased On</th>
                                                        <th>Status</th>
                                                        <th>Transaction ID</th>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="{{ asset('admin_assets/assets/images/product/prod1.jpg') }}"
                                                                alt="prod img" class="img-fluid"></td>
                                                        <td>PNG002413</td>
                                                        <td>Jane Elliott</td>
                                                        <td>06-01-2017</td>
                                                        <td><span class="label label-primary">Shipping</span></td>
                                                        <td>#7234421</td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="{{ asset('admin_assets/assets/images/product/prod2.jpg') }}"
                                                                alt="prod img" class="img-fluid"></td>
                                                        <td>PNG002344</td>
                                                        <td>John Deo</td>
                                                        <td>05-01-2017</td>
                                                        <td><span class="label label-danger">Failed</span></td>
                                                        <td>#7234486</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load
                                                    More</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 col-lg-4">
                            <div class="card">
                                <div class="card-block text-center">
                                    <i class="fa fa-envelope-open text-c-blue d-block f-40"></i>
                                    <h4 class="m-t-20"><span class="text-c-blue">8.62k</span> Subscribers</h4>
                                    <p class="m-b-20">Your main list is growing</p>
                                    <button class="btn btn-primary btn-sm btn-round">Manage List</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-block text-center">
                                    <i class="fa fa-twitter text-c-green d-block f-40"></i>
                                    <h4 class="m-t-20"><span class="text-c-blgreenue">+40</span> Followers</h4>
                                    <p class="m-b-20">Your main list is growing</p>
                                    <button class="btn btn-success btn-sm btn-round">Check them out</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-block text-center">
                                    <i class="fa fa-puzzle-piece text-c-pink d-block f-40"></i>
                                    <h4 class="m-t-20">Business Plan</h4>
                                    <p class="m-b-20">This is your current active plan</p>
                                    <button class="btn btn-danger btn-sm btn-round">Upgrade to VIP</button>
                                </div>
                            </div>
                        </div> -->

                    </div>
                </div>

            </div>
            <div id="styleSelector"> </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection