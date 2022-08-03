<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
  <meta name="author" content="themefisher.com">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('master.layouts.master-frontend')
  <title>Linc Group | Homepage</title>
  <style>
	.card-name{
		position: absolute;
		left: 0px;
		right: 0px;
		bottom: 0px;
		color: white;
		background-color: rgba(0, 0, 0, 0.8);
	}

	.profile-card-priviledges{
		background-color: darkred;
	}
  </style>
</head>

<body id="top">

<header>
	<div class="header-top-bar">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<ul class="top-bar-info list-inline-item pl-0 mb-0">
						<li class="list-inline-item"><a href=""><i class="icofont-support-faq mr-2"></i>IT: michaeltenoyo.lincgroup@gmail.com</a></li>
						<li class="list-inline-item"><i class="icofont-location-pin mr-2"></i>Jl. Sulawesi No. 3</li>
					</ul>
				</div>
				<div class="col-lg-6">
					<div class="text-lg-right top-right-bar mt-2 mt-lg-0">
						<a href="https://wa.me/087750362066" >
							<span>Feedback IT : </span>
							<span class="h4">6287750362066</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-expand-lg navigation" id="navbar">
		<div class="container">
		 	 <a class="navbar-brand" href="index.html">
			  	<img width="50%" src="{{ asset('assets/novena/images/logo.png') }}" alt="" class="img-fluid">
			  </a>

		  	<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarmain" aria-controls="navbarmain" aria-expanded="false" aria-label="Toggle navigation">
			<span class="icofont-navigation-menu"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarmain">
			<ul class="navbar-nav ml-auto">
			  <li class="nav-item active">
				<a class="nav-link" href="index.html">Home</a>
			  </li>
			   <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
			    <li class="nav-item"><a class="nav-link" href="service.html">Services</a></li>

			    <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="department.html" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Features <i class="icofont-thin-down"></i></a>
					<ul class="dropdown-menu" aria-labelledby="dropdown02">
						<li><a class="dropdown-item" href="/smart">SMART Data Services</a></li>
						<li><a class="dropdown-item" href="/lautanluas">LTL Data Services</a></li>
						<li><a class="dropdown-item" href="/greenfields">Greenfields Data Services</a></li>
						<li><a class="dropdown-item" href="/loa">Letter of Agreements</a></li>
						<li><a class="dropdown-item" href="/sales">Statistic Report</a></li>
					</ul>
			  	</li>

			   <!-- Account -->
			   @if (Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="department.html" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <i class="icofont-thin-down"></i></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown02">
                        <li><a class="dropdown-item" href="department.html">Account Info</a></li>
                        <li class="logout-btn"><a class="dropdown-item" href=""><i class="inline-icon small material-icons">chevron_left</i> Logout</a></li>
                    </ul>
                </li>
			   @else
			    <li id="nav-login"><a class="nav-link font-weight-bold text-decoration-underline" href="" data-toggle="modal" data-target="#loginModal"><u>Login</u></a></li>
			   @endif

			</ul>
		  </div>
		</div>
	</nav>
</header>




<!-- Slider Start -->
<section class="banner">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12 col-xl-7">
				<div class="block mt-3">
					<!--
						<div class="divider mb-3"></div>
						<span class="text-uppercase text-sm letter-spacing ">LINC DATA SOLUTION</span>
						<h1 class="mb-3 mt-3">Manage and Process Data Easiser Now!</h1>

						<p class="mb-4 pr-5">Website ini dibangun untuk mempermudah manajemen data surat jalan, pembuatan report, dan proforma.</p>
						<div class="btn-container ">
							<a href="" target="_blank" class="btn btn-main-2 btn-icon btn-round-full">Baca lebih lanjut... <i class="icofont-simple-right ml-2  "></i></a>
						</div>
					-->

					@if (Auth::user())
					<div class="card ml-5 mt-5" style="width: 70%;">
						<img class="card-img-top" src="{{ asset('assets/novena/images/landing-card-background.png') }}" alt="Card image cap">
						<div class="card-name rounded px-4 pt-2">
							<p>
								<span><b>{{ strtoupper(Auth::user()->name) }}</b></span>
								<br>
								<span>{{ Auth::user()->email }}</span>
								<br><br>
								@foreach ($priviledges as $p)
									<span class="profile-card-priviledges p-2 mr-2 rounded-lg">{{strtoupper($p)}}</span>
								@endforeach
							</p>
						</div>
					</div>
					@else
					<div class="card" style="width: 70%;">
						<img class="card-img-top" src="{{ asset('assets/novena/images/landing-card-background.png') }}" alt="Card image cap">
						<div class="card-name rounded px-4 pt-2">
							<p>
								<span><b>Welcome Back!</b></span>
								<br>
								<span>Please login to your account</span>
							</p>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</section>
<section class="features">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="feature-block d-lg-flex">
					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<img height="50rem" src="{{ asset('assets/novena/images/service/logo/smart.jpg') }}" alt="">
						</div>
						<span>Data Services</span>
						<h4 class="mb-3">SMART Customer</h4>
						<p class="mb-4">Truck and item database for SMART customer, auto-generate report for SMART.</p>
						<a href="{{ url('/smart') }}" class="btn btn-main btn-round-full">GO TO SMART</a>
					</div>

					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<img height="50rem" src="{{ asset('assets/novena/images/service/logo/ltl.jpg') }}" alt="">
						</div>
						<span>Data Services</span>
						<h4 class="mb-3">LTL Customer</h4>
						<p class="mb-4">Order database for LTL (Lautan Luas) customer, auto-generate report for LTL.</p>
						<a href="{{ url('/lautanluas') }}" class="btn btn-main btn-round-full">GO TO LTL</a>
					</div>

					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<img height="50rem" src="{{ asset('assets/novena/images/service/logo/greenfields.jpg') }}" alt="">
						</div>
						<span>Data Services</span>
						<h4 class="mb-3">Greenfields Customer</h4>
						<p class="mb-4">Order database for Greenfields customer, auto-generate report for Greenfields.</p>
						<a href="{{ url('/greenfields') }}" class="btn btn-main btn-round-full">GO TO GREENFIELDS</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="features-2">
	<div class="container">
		<div class="row mt-4 mb-5">
			<div class="col-lg-12">
				<div class="feature-block d-lg-flex">
					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<img height="50rem" src="{{ asset('assets/novena/images/service/logo/loa.jpg') }}" alt="">
						</div>
						<span>Data Services</span>
						<h4 class="mb-3">LOA Data</h4>
						<p class="mb-4">Database for letter of agreement, with report, and easier monitoring for LOA.</p>
						<a href="{{ url('/user/underMaintenance') }}" class="btn btn-main btn-round-full">UNDER BIG REVISION!</a>
					</div>

					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<img height="50rem" src="{{ asset('assets/novena/images/service/logo/revenue.jpg') }}" alt="">
						</div>
						<span>Data Services</span>
						<h4 class="mb-3">Statistic Report</h4>
						<p class="mb-4">Reporting for performance statistic, with visualization, and specific master in detail.</p>
						<a href="{{ url('/sales') }}" class="btn btn-main btn-round-full">GO TO STATISTIC REPORT</a>
					</div>

					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<img height="50rem" src="{{ asset('assets/novena/images/service/logo/blujay.png') }}" alt="">
						</div>
						<span>Data Services</span>
						<h4 class="mb-3">Third Party System</h4>
						<p class="mb-4">This module will give you an insight of all available data in third party system used.</p>
						<a href="{{ url('/third-party') }}" class="btn btn-main btn-round-full">UNDER CONSTRUCTION</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- footer Start -->
<footer class="footer section gray-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 mr-auto col-sm-6">
				<div class="widget mb-5 mb-lg-0">
					<div class="logo mb-4">
						<img src="images/logo.png" alt="" class="img-fluid">
					</div>
					<p>This middleware webapp is used by Linc Group company. &copy; All right of the full support system is reserved to <a href="https://www.lincgrp.com/" target="_blank">Linc Group.</a></p>
				</div>
			</div>

			<div class="col-lg-4 col-md-6 col-sm-6">
				<div class="widget mb-5 mb-lg-0">
					<h4 class="text-capitalize mb-3">Services</h4>
					<div class="divider mb-4"></div>

					<ul class="list-unstyled footer-menu lh-35">
						<li><a href="/smart">SMART Middleware</a></li>
						<li><a href="/lautanluas">Lautan Luas Middleware</a></li>
						<li><a href="/loa">LOA Management</a></li>
						<li><a href="/sales">Statistic Report</a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="widget widget-contact mb-5 mb-lg-0">
					<h4 class="text-capitalize mb-3">Bug or Error ?</h4>
					<div class="divider mb-4"></div>

					<div class="footer-contact-block mb-4">
						<div class="icon d-flex align-items-center">
							<i class="icofont-email mr-3"></i>
							<span class="h6 mb-0">Mail me at :</span>
						</div>
						<h4 class="mt-2"><a href="tel:+23-345-67890">michaeltenoyo.lincgroup@gmail.com</a></h4>
					</div>

					<div class="footer-contact-block">
						<div class="icon d-flex align-items-center">
							<i class="icofont-support mr-3"></i>
							<span class="h6 mb-0">Mon to Fri : 09:00 - 17:00</span>
						</div>
						<h4 class="mt-2"><a href="tel:+23-345-67890">+62-877-50362066</a></h4>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-btm py-4 mt-5">
			<div class="row align-items-center justify-content-between">
				<div class="col-lg-6">
					<div class="copyright">
						&copy; UI Template - Copyright Reserved to <span class="text-color">Novena</span> by <a href="https://themefisher.com/" target="_blank">Themefisher</a>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="subscribe-form text-lg-right mt-5 mt-lg-0">
						<form action="#" class="subscribe">
							<input type="text" class="form-control" placeholder="Your Email address">
							<a href="#" class="btn btn-main-2 btn-round-full">Subscribe</a>
						</form>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4">
					<a class="backtop js-scroll-trigger" href="#top">
						<i class="icofont-long-arrow-up"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>
</body>
</html>

@include('master.modals.login-modal')
@include('shared.master-scripts')
