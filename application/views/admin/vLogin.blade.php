<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="baseUrl" content="{{ base_url() }}">
	<meta name="adminPath" content="{{ ADMIN_PATH }}">
	<title>IPDN | Login</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
    <link rel="stylesheet" href="{{ base_url('assets/admin/') }}dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ base_url('assets/modules/iziToast.min.css') }}">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="{{ base_url() }}"><b>IPDN</b></a>
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Masuk untuk melanjutkan</p>

				<form action="{{ base_url(ADMIN_PATH . '/login/action') }}" method="post" id="formLogin">
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="username" placeholder="Username" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password" placeholder="Password" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="w-100 align-right">
						<div class="row">
							<div class="col-4">
								<button type="submit" class="btn btn-primary btn-block">Sign In</button>
							</div>
						</div>
					</div>
				</form>

				{{-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> --}}
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="{{ base_url('assets/admin/') }}plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ base_url('assets/admin/') }}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
    <script src="{{ base_url('assets/admin/') }}dist/js/adminlte.min.js"></script>
    <script src="{{ base_url('assets/modules/iziToast.min.js') }}"></script>
    <script src="{{ base_url('assets/modules/sweetalert.min.js') }}"></script>
    <script src="{{ base_url('assets/js/page/admin.js') }}"></script>
    <script src="{{ base_url('assets/js/page/login.js') }}"></script>

</body>

</html>
