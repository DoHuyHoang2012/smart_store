<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<title>Hệ thống quản trị cơ sở dữ liệu</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('admin/login/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin/login/css/my-login.css') }}">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper my-auto">
					<div class="brand">
						<h1>Smart Store</h1>
					</div>
					@yield('content')
					<div class="footer">
						Copyright &copy; Smart Store 2017
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{ asset('admin/login/js/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/login/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('admin/login/js/my-login.js') }}"></script>
</body>
</html>