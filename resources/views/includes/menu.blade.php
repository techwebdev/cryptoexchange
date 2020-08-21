<body>
    <!-- preloader area start -->
    <div class="preloader" id="preloader">
        <img src="{{ asset('assets/images/preloader.gif') }}" style="width: 50%;filter: hue-rotate(200deg);">
    </div>

    <!-- Main Loader -->
    <div class="" id="main_loader" style="display: none;flex-direction: column;justify-content: center;align-items: center;z-index: 11111111111;position: fixed;top: 0;right: 0;left: 0;bottom:0;width:100%;height:100%;background-color:#00000050;">
        <img src="{{ asset('assets/images/preloader.gif') }}" style="width: 25%;filter: hue-rotate(200deg);">
    </div>
    <!-- End loader -->

    <!-- Header Area Start  -->
    <header class="header">
        <!-- Top Header Area Start -->
        <!-- <section class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="content">
                            <div class="left-content">
                                <ul class="left-list">
                                    <li>
                                        <p>
                                            <i class="fas fa-headset"></i> Support
                                        </p>
                                    </li>
                                    <li>
                                        <div class="currency-selector">
                                            <select name="currency" class="currency">
                                                <option value="1">USD</option>
                                                <option value="2">BDT</option>
                                                <option value="3">BTC</option>
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="right-content">
                                <ul class="right-list">
                                    <li>
                                        <div class="language-selector">
                                            <select name="language" class="language">
                                                <option value="en">ENG</option>
                                                <option value="bn">BAN</option>
                                                <option value="cn">CN</option>
                                                <option value="jp">IN</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <ul class="social-link">
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-linkedin-in"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- Top Header Area End -->
        <!--Main-Menu Area Start-->
        <div class="mainmenu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <!-- <img src="assets/images/logo.png" alt=""> -->
                                <h3>{{ config('app.name', 'eCurrencyNG') }}</h3>
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu"
                                aria-controls="main_menu" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse fixed-height" id="main_menu">
                                @php
                                $admin = App\User::where('is_admin','1')->first();
                                @endphp
                                <marquee style="color:black">
                                    Support <i class="fa fa-envelope text-black" aria-hidden="true"></i> <strong>{{ $admin->email }}</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Contact <i class="fa fa-whatsapp text-black" aria-hidden="true"></i> <strong>{{ $admin->mobile }}</strong>
                                </marquee>
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <!-- <a class="nav-link active dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Home
                                        </a> -->
                                        @auth
                                            @if(Auth::user()->is_admin == "1")
                                                <a class="nav-link" href="{{ route('admin.home') }}" role="button">
                                                    Home
                                                </a>
                                            @else
                                                <a class="nav-link" href="{{ route('home') }}" role="button">
                                                    Home
                                                </a>
                                            @endif
                                        @else
                                        <a class="nav-link" href="{{ url('/') }}" role="button">
                                            Home
                                        </a>
                                        @endauth
                                        <!-- <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="index.html"> <i
                                                        class="fa fa-angle-double-right"></i>Home 1</a></li>
                                            <li><a class="dropdown-item" href="index2.html"> <i
                                                        class="fa fa-angle-double-right"></i> Home 2</a></li>
                                            <li><a class="dropdown-item" href="index3.html"> <i
                                                        class="fa fa-angle-double-right"></i> Home 3</a></li>
                                            <li><a class="dropdown-item" href="index4.html"> <i
                                                        class="fa fa-angle-double-right"></i> Home 4</a></li>
                                            <li><a class="dropdown-item" href="index5.html"> <i
                                                        class="fa fa-angle-double-right"></i> Home 5</a></li>
                                        </ul> -->
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" href="aboutus.html">About</a>
                                    </li> -->
                                </ul>
                                @guest
                                <div class="row">
                                    <div class="col-sm-8">
                                        <a href="{{ route('login') }}" class="mybtn1">Login</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <a href="{{ route('register') }}" class="mybtn1">Register</a>
                                    </div>
                                </div>
                                @else
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            @if(auth()->user()->is_admin)
                                                <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                                                    {{ __('Profile') }}
                                                </a>
                                            @else
                                                @if(auth()->user()->isVerified == "1")
                                                    <a class="dropdown-item" href="{{ route('home') }}">
                                                        {{ __('Transaction') }}
                                                    </a>
                                                @endif
                                            @endif
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                                @endguest
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--Main-Menu Area Start-->
    </header>
    <!-- Header Area End  -->