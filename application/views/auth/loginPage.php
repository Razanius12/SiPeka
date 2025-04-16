<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SiPeka | Log in</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url() ?>alte/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url() ?>alte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url() ?>alte/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page dark-mode accent-info" style="
 background-color:rgb(25, 26, 32) !important;
	background-image: url('<?= base_url() ?>assets/ALFSolutionCOMPRESSED.webp');
	background-size: cover;
	background-position: center;
	background-blend-mode: overlay;

	background-repeat: no-repeat !important;
	background-attachment: fixed !important;
	transition: background-position 0.5s ease-in-out, background-size 0.5s ease-in-out !important;">
	<div class="login-box elevation-3">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<img src="<?= base_url('assets/sipeka-logo-text.svg') ?>" class="img-fluid"
					alt="SiPeka Logo">
			</div>
			<div class="card-body">
				<p class="login-box-msg">Silahkan login untuk masuk ke aplikasi</p>
				<?php if ($this->session->flashdata('error')): ?>
					<div class="alert alert-danger alert-dismissable">
						<button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?= $this->session->flashdata('error'); ?>
					</div>
				<?php endif; ?>

				<form action="<?= base_url() . 'C_Auth/LoginProcess' ?>" method="post">
					<div class="input-group mb-3 elevation-1">
						<input type="username" class="form-control" placeholder="Username" id="username"
							name="username">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3 elevation-1">
						<input type="password" class="form-control" placeholder="Password" id="password"
							name="password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<a href="<?= base_url() ?>" class="btn btn-primary elevation-1">Kembali</a>
						</div>
						<div class="col text-right">
							<button type="submit" class="btn btn-primary elevation-1">Login</button>
						</div>
					</div>
				</form>

				<!-- <p class="mb-0">
					<a href="register.html" class="text-center">Register a new membership</a>
				</p> -->
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="<?= base_url() ?>alte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url() ?>alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url() ?>alte/dist/js/adminlte.min.js"></script>
</body>

</html>
