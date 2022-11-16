<!doctype html>
<html lang="en">
  <head>
  	<title>{{ config('app.app_name') }} | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="{{ url('') }}/themes/login/login-form-18/css/style.css">
	<!--===============================================================================================-->
	<script src="{{url('themes/default/js/alert/sweetalert.min.js')}}"></script>
	</head>
	<body>
	@include('sweet::alert')
	<section class="ftco-section" style="padding: 6em 0!important;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-4">
					<h2 class="heading-section">Login Untuk Menggunakan Sistem</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
						<div class="d-flex align-items-center justify-content-center">
							<img src="{{url('themes/login/images/logo.png')}}" width="120" style="margin-top: 0px;margin-bottom: 15px">
							{{-- <span class="fa fa-user-o"></span> --}}
						</div>
						<br>
						<form action="{{url('/auth')}}" method="post" class="login-form">
							{{ csrf_field() }}
							<div class="form-group">
								<input type="text" class="form-control rounded-left" name="username" placeholder="Username"  required="" autofocus autocomplete="off">
							</div>
							<div class="form-group d-flex">
								<input type="password" class="form-control rounded-left" name="password" id="password" placeholder="Password" required>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary rounded submit p-3 px-5">LOGIN</button>
							</div>
						</form>
	        		</div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{ url('') }}/themes/login/login-form-18/js/jquery.min.js"></script>
  	<script src="{{ url('') }}/themes/login/login-form-18/js/popper.js"></script>
  	<script src="{{ url('') }}/themes/login/login-form-18/js/bootstrap.min.js"></script>
  	<script src="{{ url('') }}/themes/login/login-form-18/js/main.js"></script>

	</body>
</html>

