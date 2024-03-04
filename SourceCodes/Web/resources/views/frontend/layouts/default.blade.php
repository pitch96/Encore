<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('/') }}">
    <meta name="user_id" content="{{ Auth::user() ? Auth::user()->id : null }}">

    <title>Encore Events | @yield('title')</title>

    <!-- CSS Files -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/styles.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" />
   
    <!-- Script Files -->
    <!-- Script Files -->
    <script type="text/javascript" src="{{ asset('frontend/js/front/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('frontend/js/front/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/front/custom.js') }}"></script>

   
	<script src="{{asset('vendor/jquery-validation/dist/jquery.validate.js')}}"></script>
	<script src="{{ asset('assets/dist/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
	<!-- <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" type="text/css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}" type="text/css"> --}}
    {{-- toastr --}}
    <link rel="stylesheet" href="{{ asset('assets/dist/css/toastr.min.css') }}">

	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
  
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    {{-- <link rel="stylesheet" href="https://cdnjs.com/libraries/jquery.mask"> --}}

</head>

<body>

 <div id="wrapper">

	 	<!-- Start header section -->
		<header id="header" class="site-header">
			<div class="container-fluid">
				<div class="header-wrap d-flex">
					<div class="header-inner-wrap">
						<a class="header-logo" href="{{ url('/') }}">
							<img src="{{ asset('frontend/images/e-core-logo.png') }}" alt="e-core-logo">
						</a>
						<nav class="header-menu">
							<ul class="unstyle-list d-flex">
								@foreach($cat_menus as $cat)
									<li>
										<a href="{{ url('events') }}?category_id={{ $cat->id }}">{{ $cat->name }}</a>
									</li>
								@endforeach
								<li class="hidden-desktop header-login">
									@if(!Auth::check())
										<a href="{{ route('login') }}" class="btn-commons">Login</a>
									@else	
										<a href="{{ route('logout') }}" class="btn-commons">Logout</a>
									@endif
								</li>
							</ul>
						</nav>
					</div>
					<div class="header-login " style="margin-left: auto;">
						@if(!Auth::check())
							<a href="{{ route('login') }}" class="btn-common">Login</a>
						@else
							<div class="nav-right">	
								<nav>
									
									<div class="profile">
										<div class="user">
											<h3 class="user-name">{{ Auth::user()->first_name }}</h3>
										</div>
										<div class="img-box">
											<img src="{{ Auth::user()->user_profile ? asset('user-images/' . Auth::user()->user_profile) : asset('no-image.png') }}" alt="some user image">
										</div>
									</div>
									<div class="menu">
										<ul>
											@if(Auth::user()->user_type === config('constants.ADMIN_TYPE') || Auth::user()->user_type === config('constants.PROMOTER_TYPE'))
												<li>
													<a class="dropdown-item" href="{{ url('admin/purchase') }}">
													My Purchases</a>
												</li>
												@endif
												<li><a class="dropdown-item" href="@if(Auth::user()->user_type === config('constants.ADMIN_TYPE') || Auth::user()->user_type === config('constants.PROMOTER_TYPE')){{ url('admin/profile') }} @else {{ url('account') }} @endif">
													My Account
												</a></li>
												<li><a class="dropdown-item" href="{{ url('checkout') }}">
													My Cart
												</a></li>
												<li><a class="dropdown-item" href="{{ url('logout') }}">
													{{ __('Logout') }}
												</a></li>
											{{-- <li><a href="#"><i class="ph-bold ph-user"></i>&nbsp;Profile</a></li>
											<li><a href="#"><i class="ph-bold ph-envelope-simple"></i>&nbsp;Inbox</a></li>
											<li><a href="#"><i class="ph-bold ph-gear-six"></i>&nbsp;Settings</a></li>
											<li><a href="#"><i class="ph-bold ph-question"></i>&nbsp;Help</a></li>
											<li><a href="#"><i class="ph-bold ph-sign-out"></i>&nbsp;Sign Out</a></li> --}}
										</ul>
									</div>
								</nav>
							{{-- <ul>
								<li class="nav-item">
									<div class="user-panel d-flex">
										<div class="image">
											<img src="{{ Auth::user()->user_profile ? asset('user-images/' . Auth::user()->user_profile) : asset('no-image.png') }}"
												class="img-circle elevation-2" alt="User Image">
										</div>
									</div>
								</li>
								<li class="nav-item dropdown">
									<a id="dropdownMenuButton" class="nav-link dropdown-toggle dropdownMenuSize" href="#" role="button"
										data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
										{{ Auth::user()->first_name }}
									</a>
									<div class="dropdown-menu dropdown-menu-end" id="user_menu_subparent"
										aria-labelledby="dropdownMenuButton">
										
										@if(Auth::user()->user_type === config('constants.ADMIN_TYPE') || Auth::user()->user_type === config('constants.PROMOTER_TYPE'))
										<a class="dropdown-item" href="{{ url('admin/purchase') }}">
											My Purchases
										</a>
										@endif
										<a class="dropdown-item" href="@if(Auth::user()->user_type === config('constants.ADMIN_TYPE') || Auth::user()->user_type === config('constants.PROMOTER_TYPE')){{ url('admin/profile') }} @else {{ url('account') }} @endif">
											My Account
										</a>
										<a class="dropdown-item" href="{{ url('checkout') }}">
											My Cart
										</a>
										<a class="dropdown-item" href="{{ url('logout') }}">
											{{ __('Logout') }}
										</a>
									</div>
								</li>
							</ul> --}}
							</div>
						@endif
					</div>
					<div class="toggle-menu">
						<span></span>
						<span></span>
						<span></span>
						<span></span>
						<span></span>
						<span></span>
					</div>
				</div>
			</div>
		</header>
		<!-- End Header section -->
        @yield('content')
		
		<!-- Start Footer section -->
        <footer class="bg-footer">
			<div class="container">
				<div class="footer-wrapper">
					<div class="footer-link">
						<h2 class="footer-title">
							Our Company
						</h2>
						<ul class="footer-menu unstyle-list">
							<li>
								<a href="{{ url('aboutus') }}">
									About Us
								</a>
							</li>
							<li>
								<a href="{{ url('contactus') }}">
									Contact Us
								</a>
							</li>
							<li>
								<a href="{{ url('privacypolicy') }}">
									Privacy Policy
								</a>
							</li>
							<li>
								<a href="{{ url('termsconditions') }}">
									Terms & Conditions
								</a>
							</li>
							<li> 
								<a href="{{ url('sales') }}" class="listing text-decoration-none">
									Market With Us
								</a> 
							</li>
						</ul>
					</div>
					<div class="footer-form">
						<form action="" id="subscription-form">
							@csrf
							<h2 class="footer-title">
								Subscribe and receive weekly program and schedule
							</h2>
							<div class="form-group" style="flex-direction: column;">
								<div class="form-control">
									<input type="text"  type='email' id="email" placeholder="Enter Email Address" class="input-fields input-subscibe subscriber_email">
								</div>
								<div class="g-recaptcha" id="feedback-recaptcha"
									data-sitekey="{{ config('constants.GOOGLE_RECAPTCHA_KEY') }}"
									data-callback="hideAlertMsg" style="margin-left: 10px;margin-bottom: 10px;">
                            	</div>
								<div class="form-control">
									<button type="button" id="subscribe" class="input-subscribe btn-common">Subscribe</button>
								</div>
								<div style="margin-left: 10px;margin-bottom: 10px;" class="newsfeedback text-left email-validation subscribe-invalid-text" style="display: none"> </div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</footer>
		<!-- End Footer section -->

 </div>
 <script src="{{ asset('frontend/js/jquery.mask.min.js') }}"></script>
 <script src="{{ asset('frontend/js/bootstrap.min.js') }} "></script>
 <!-- DataTables  & Plugins -->
 <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
 
 <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
 <script src="{{ asset('frontend/js/master.js') }}"></script>
<script>
	let profile = document.querySelector('.profile');
	let menu = document.querySelector('.menu');

	if (profile != null ) {
		profile.onclick = function () {
		menu.classList.toggle('active');
	}
	}


	$('.tab-menu li a').on('click', function(){
		var target = $(this).attr('data-rel');
		$('.tab-menu li a').removeClass('active');
		$(this).addClass('active');
		$("#"+target).fadeIn('slow').siblings(".tab-box").hide();
		return false;
  	});


$(document).ready( function () {
    $('#ordertable').DataTable();
} );
</script>
@yield('script')
</body>
</html>
