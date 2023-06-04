<!doctype html>
<html lang="en">
<head>
	<title>Museum</title>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="{{ asset('admin/assets/img/avatars/earth-grid.png') }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('user/fonts/icomoon/style.css') }}">
	<link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('user/css/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('user/css/owl.theme.default.min.css') }}">
	<link rel="stylesheet" href="{{ asset('user/css/owl.theme.default.min.css') }}">
	<link rel="stylesheet" href="{{ asset('user/css/jquery.fancybox.min.css') }}">
	<link rel="stylesheet" href="{{ asset('user/css/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('user/fonts/flaticon/font/flaticon.css') }}">
	<link rel="stylesheet" href="{{ asset('user/css/aos.css') }}">
	<link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
	

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    {{-- cdn leaflet search --}}
    <link rel="stylesheet" href="../src/leaflet-search.css" />
    <script src="../src/leaflet-search.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/leaflet.markercluster.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/MarkerCluster.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/MarkerCluster.Default.css" />   

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Boostrap Icon -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
      integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e"
      crossorigin="anonymous"
    />
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
	<div id="overlayer"></div>
	<div class="loader">
		<div class="spinner-border text-primary" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>
	<div class="site-wrap">
		<div class="site-mobile-menu site-navbar-target">
			<div class="site-mobile-menu-header">
				<div class="site-mobile-menu-close mt-3">
					<span class="icon-close2 js-menu-toggle"></span>
				</div>
			</div>
			<div class="site-mobile-menu-body"></div>
		</div>
		<header class="site-navbar py-2 js-sticky-header site-navbar-target" role="banner">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-6 col-xl-2">
					<h1 class="mb-0 site-logo"><a href="/" class="h2 mb-0">Museum</a></h1>
				</div>
				<div class="col-12 col-md-10 d-none d-xl-block">
					<nav class="site-navigation position-relative text-right" role="navigation">
					<ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
						@if (Auth::check())
							<li>
								<a href="{{ route('actionlogout') }}" class="btn btn-primary">Keluar</a>
							</li>
						@else	
							<li>
								<a href="/login" class="btn btn-primary">Masuk</a>
							</li>
						@endif
					</ul>
					</nav>
				</div>
				<div class="col-6 d-inline-block d-xl-none ml-md-0 py-3" style="position: relative; top: 3px;">
					<a href="#" class="site-menu-toggle js-menu-toggle float-right"><span class="icon-menu h3"></span></a>
				</div>
			</div>
		</div>
		</header>
		@yield('content')
	</div>
	<!-- .site-wrap -->
	<!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<script src="{{ asset('user/js/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ asset('user/js/jquery-ui.js') }}"></script>
	<script src="{{ asset('user/js/popper.min.js') }}"></script>
	<script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('user/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('user/js/jquery.countdown.min.js') }}"></script>
	<script src="{{ asset('user/js/jquery.easing.1.3.js') }}"></script>
	<script src="{{ asset('user/js/aos.js') }}"></script>
	<script src="{{ asset('user/js/jquery.fancybox.min.js') }}"></script>
	<script src="{{ asset('user/js/jquery.sticky.js') }}"></script>
	<script src="{{ asset('user/js/isotope.pkgd.min.js') }}"></script>
	<script src="{{ asset('user/js/main.js') }}"></script>

	@stack('script')
</body>
</html>