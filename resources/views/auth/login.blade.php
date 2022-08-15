<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{config('app.app_name')}} | Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ url('') }}/themes/login/Login_v2/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/css/util.css">
	<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/login/Login_v2/css/main.css">
<!--===============================================================================================-->
<script src="{{url('themes/default/js/alert/sweetalert.min.js')}}"></script>
</head>
<body>
  @include('sweet::alert')
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
        <form action="{{url('/auth')}}" method="post" class="login100-form validate-form">
          {{ csrf_field() }}
					<span class="login100-form-title p-b-40"  style="font-size: 17px!important">
						BUMDESA SARINING WINANGUN DESA KUKUH - KERAMBITAN
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
            <input type="text" name="username" class="input100" required="" autofocus autocomplete="off">
						<span class="focus-input100" data-placeholder="Username"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
            <input type="password" name="password" id="password" class="input100" required="">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Login
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="{{ url('') }}/themes/login/Login_v2/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ url('') }}/themes/login/Login_v2/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ url('') }}/themes/login/Login_v2/vendor/bootstrap/js/popper.js"></script>
	<script src="{{ url('') }}/themes/login/Login_v2/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ url('') }}/themes/login/Login_v2/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="{{ url('') }}/themes/login/Login_v2/vendor/daterangepicker/moment.min.js"></script>
	<script src="{{ url('') }}/themes/login/Login_v2/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="{{ url('') }}/themes/login/Login_v2/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="{{ url('') }}/themes/login/Login_v2/js/main.js"></script>
</body>
</html>