<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Hotel Dashboard</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('assets/img/favicon.png') }}">
	<link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ URL::to('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ URL::to('assets/plugins/fontawesome/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ URL::to('assets/plugins/datatables/datatables.min.css') }}">
	<link rel="stylesheet" href="{{ URL::to('assets/css/feathericon.min.css') }}">
	<link rel="stylehseet" href="https://cdn.oesmith.co.uk/morris-0.5.1.css">
	<link rel="stylesheet" href="{{ URL::to('assets/plugins/morris/morris.css') }}">
	<link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">
</head>
<link rel="stylesheet" type="text/css" href="{{ URL::to('assets/css/bootstrap-datetimepicker.min.css') }}">

<link rel="stylesheet" href="{{ URL::to('assets/css/toastr.min.css') }}">
<script src="{{ URL::to('assets/js/toastr_jquery.min.js') }}"></script>
<script src="{{ URL::to('assets/js/toastr.min.js') }}"></script>

<body>
	<div class="main-wrapper">
		<div class="header">
			<div class="header-left">
				<a href="{{ route('home') }}" class="logo">
					<img src="{{ URL::to('assets/img/hotel_logo.png') }}" width="50" height="70" alt="logo">
					<span class="logoclass">HOTEL</span>
				</a>
				<a href="{{ route('home') }}" class="logo logo-small">
					<img src="{{ URL::to('assets/img/hotel_logo.png') }}" alt="Logo" width="30" height="30">
				</a>
			</div>
			<a href="javascript:void(0);" id="toggle_btn"> <i class="fe fe-text-align-left"></i> </a>
			<a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a>

			<ul class="nav user-menu">
				<li class="nav-item dropdown has-arrow">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
						<span class="user-img">
							<img class="rounded-circle" src="{{ URL::to('assets/img/hotel_logo.png') }}" width="31"
								alt="{{ Auth::user()->name }}">
						</span>
					</a>
					<div class="dropdown-menu">
						<div class="user-header">
							<div class="avatar avatar-sm">
								<img src="{{ URL::to('assets/img/hotel_logo.png') }}" alt="{{ Auth::user()->name }}"
									class="avatar-img rounded-circle">
							</div>
							<div class="user-text">
								<h6>{{ Auth::user()->name }}</h6>
								<p class="text-muted mb-0">{{ Auth::user()->position ?? 'Staff' }}</p>
							</div>
						</div>
						<a class="dropdown-item" href="{{ route('profile') }}">My Profile</a>
						<a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
					</div>
				</li>
			</ul>

			<div class="top-nav-search">
				<form>
					<input type="text" class="form-control" placeholder="Search here">
					<button class="btn" type="submit"><i class="fas fa-search"></i></button>
				</form>
			</div>
		</div>

		@include('sidebar.menusidebar')

		@yield('content')
	</div>

	<script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="{{ URL::to('assets/js/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/popper.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ URL::to('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ URL::to('assets/plugins/raphael/raphael.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/moment.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ URL::to('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::to('assets/plugins/datatables/datatables.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/script.js') }}"></script>
	<script src="{{ URL::to('assets/js/moment.min.js') }}"></script>
	<script src="{{ URL::to('assets/plugins/morris/morris.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/chart.morris.js') }}"></script>

	@yield('script')

</body>

</html>