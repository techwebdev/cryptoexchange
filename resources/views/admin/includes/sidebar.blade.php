<div class="pcoded-main-container">
	<div class="pcoded-wrapper">
		<nav class="pcoded-navbar">
			<div class="sidebar_toggle"><a href="javascript:void(0)"><i class="icon-close icons"></i></a></div>
			<div class="pcoded-inner-navbar main-menu">
				<div class="pcoded-navigation-label"></div>
				<ul class="pcoded-item pcoded-left-item">
					<!-- <li class="pcoded-hasmenu active pcoded-trigger tab"> -->
					<li class="tab">
						<a href="{{ route('admin.home') }}">
							<span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
							<span class="pcoded-mtext">Dashboard</span>
							<span class="pcoded-mcaret"></span>
						</a>
						<!-- <ul class="pcoded-submenu">
							<li class="active">
								<a href="index-2.html">
									<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
									<span class="pcoded-mtext">Default</span>
									<span class="pcoded-mcaret"></span>
								</a>
							</li>
							<li class="">
								<a href="dashboard-ecommerce.html">
									<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
									<span class="pcoded-mtext">Ecommerce</span>
									<span class="pcoded-mcaret"></span>
								</a>
							</li>
							<li class=" ">
								<a href="dashboard-analytics.html">
									<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
									<span class="pcoded-mtext">Analytics</span>
									<span class="pcoded-badge label label-info ">NEW</span>
									<span class="pcoded-mcaret"></span>
								</a>
							</li>
						</ul> -->
					</li>

					<li class="tab">
						<a href="{{ route('admin.currency.index') }}">
							<span class="pcoded-micon"><i class="ti-money"></i><b>N</b></span>
							<span class="pcoded-mtext">Currency</span>
							<span class="pcoded-mcaret"></span>
						</a>
					</li>

					<li class="tab bankInfo">
						<a href="{{ route('admin.users.index') }}">
							<span class="pcoded-micon"><i class="ti-user"></i><b>N</b></span>
							<span class="pcoded-mtext">Users</span>
							<span class="pcoded-mcaret"></span>
						</a>
					</li>

					<li class="tab">
						<a href="{{ route('admin.transaction.index') }}">
							<span class="pcoded-micon"><i class="ti-location-arrow"></i><b>N</b></span>
							<span class="pcoded-mtext">Transactions</span>
							<span class="pcoded-mcaret"></span>
						</a>
					</li>

					<li class="tab bankInfo">
						<a href="{{ route('admin.exchange-rate.index') }}">
							<span class="pcoded-micon"><i class="ti-wallet"></i><b>N</b></span>
							<span class="pcoded-mtext">Exchange Rate</span>
							<span class="pcoded-mcaret"></span>
						</a>
					</li>

					<li class="tab bankInfo">
						<a href="{{ route('admin.profile.index') }}">
							<span class="pcoded-micon"><i class="ti-info-alt"></i><b>N</b></span>
							<span class="pcoded-mtext">Bank Details</span>
							<span class="pcoded-mcaret"></span>
						</a>
					</li>

					<!-- <li class="pcoded-hasmenu">
						<a href="javascript:void(0)">
							<span class="pcoded-micon"><i class="ti-layout"></i><b>P</b></span>
							<span class="pcoded-mtext">Page layouts</span>
							<span class="pcoded-badge label label-warning">NEW</span>
							<span class="pcoded-mcaret"></span>
						</a>
						<ul class="pcoded-submenu">
							<li class=" pcoded-hasmenu">
								<a href="javascript:void(0)">
									<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
									<span class="pcoded-mtext">Vertical</span>
									<span class="pcoded-mcaret"></span>
								</a>
								<ul class="pcoded-submenu">
									<li class=" ">
										<a href="menu-static.html">
											<span class="pcoded-micon"><i class="icon-chart"></i></span>
											<span class="pcoded-mtext">Static Layout</span>
											<span class="pcoded-mcaret"></span>
										</a>
									</li>
									<li class=" ">
										<a href="menu-header-fixed.html">
											<span class="pcoded-micon"><i class="icon-chart"></i></span>
											<span class="pcoded-mtext">Header Fixed</span>
											<span class="pcoded-mcaret"></span>
										</a>
									</li>
									<li class=" ">
										<a href="menu-compact.html">
											<span class="pcoded-micon"><i class="icon-chart"></i></span>
											<span class="pcoded-mtext">Compact</span>
											<span class="pcoded-mcaret"></span>
										</a>
									</li>
									<li class=" ">
										<a href="menu-sidebar.html">
											<span class="pcoded-micon"><i class="icon-chart"></i></span>
											<span class="pcoded-mtext">Sidebar Fixed</span>
											<span class="pcoded-mcaret"></span>
										</a>
									</li>
								</ul>
							</li>
							<li class=" pcoded-hasmenu">
								<a href="javascript:void(0)">
									<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
									<span class="pcoded-mtext">Horizontal</span>
									<span class="pcoded-mcaret"></span>
								</a>
								<ul class="pcoded-submenu">
									<li class=" ">
										<a href="menu-horizontal-static.html" target="_blank">
											<span class="pcoded-micon"><i class="icon-chart"></i></span>
											<span class="pcoded-mtext">Static Layout</span>
											<span class="pcoded-mcaret"></span>
										</a>
									</li>
									<li class=" ">
										<a href="menu-horizontal-fixed.html" target="_blank">
											<span class="pcoded-micon"><i class="icon-chart"></i></span>
											<span class="pcoded-mtext">Fixed layout</span>
											<span class="pcoded-mcaret"></span>
										</a>
									</li>
									<li class=" ">
										<a href="menu-horizontal-icon.html" target="_blank">
											<span class="pcoded-micon"><i class="icon-chart"></i></span>
											<span class="pcoded-mtext">Static With Icon</span>
											<span class="pcoded-mcaret"></span>
										</a>
									</li>
									<li class=" ">
										<a href="menu-horizontal-icon-fixed.html" target="_blank">
											<span class="pcoded-micon"><i class="icon-chart"></i></span>
											<span class="pcoded-mtext">Fixed With Icon</span>
											<span class="pcoded-mcaret"></span>
										</a>
									</li>
								</ul>
							</li>
							<li class=" ">
								<a href="menu-bottom.html">
									<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
									<span class="pcoded-mtext">Bottom Menu</span>
									<span class="pcoded-mcaret"></span>
								</a>
							</li>
							<li class=" ">
								<a href="box-layout.html" target="_blank">
									<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
									<span class="pcoded-mtext">Box Layout</span>
									<span class="pcoded-mcaret"></span>
								</a>
							</li>
							<li class=" ">
								<a href="menu-rtl.html" target="_blank">
									<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
									<span class="pcoded-mtext">RTL</span>
									<span class="pcoded-mcaret"></span>
								</a>
							</li>
						</ul>
					</li>
					<li class="">
						<a href="navbar-light.html">
							<span class="pcoded-micon"><i class="ti-layout-cta-right"></i><b>N</b></span>
							<span class="pcoded-mtext">Navigation</span>
							<span class="pcoded-mcaret"></span>
						</a>
					</li>
					<li class="pcoded-hasmenu">
						<a href="javascript:void(0)">
							<span class="pcoded-micon"><i class="ti-view-grid"></i><b>W</b></span>
							<span class="pcoded-mtext">Widget</span>
							<span class="pcoded-badge label label-danger">100+</span>
							<span class="pcoded-mcaret"></span>
						</a>
						<ul class="pcoded-submenu">
							<li class="">
								<a href="widget-statistic.html">
									<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
									<span class="pcoded-mtext">Statistic</span>
									<span class="pcoded-mcaret"></span>
								</a>
							</li>
							<li class=" ">
								<a href="widget-data.html">
									<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
									<span class="pcoded-mtext">Data</span>
									<span class="pcoded-mcaret"></span>
								</a>
							</li>
							<li class=" ">
								<a href="widget-chart.html">
									<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
									<span class="pcoded-mtext">Chart Widget</span>
									<span class="pcoded-mcaret"></span>
								</a>
							</li>
						</ul>
					</li> -->
				</ul>
		</nav>