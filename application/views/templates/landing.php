<!doctype html>
<html lang="en-US">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

	<!-- Custom CSS -->
	<!-- <link rel="stylesheet" href="<?= base_url('seo/style.css') ?>" type="text/css" /> -->
	<link rel="stylesheet" href="<?= base_url('seo/dark-theme.css') ?>" type="text/css" />

	<!-- Ionic icons -->
	<link href="https://unpkg.com/ionicons@4.2.0/dist/css/ionicons.min.css" rel="stylesheet">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

	<title>SiPeka - Sistem Penilaian Kerja Karyawan</title>
</head>

<body>
	<!-- Navbar -->
	<nav class="navbar navbar-default navbar-expand-lg fixed-top custom-navbar">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="icon ion-md-menu"></span>
		</button>
		<img src="<?= base_url('assets/sipeka-logo-text.svg') ?>" class="img-fluid nav-logo-mobile" alt="SiPeka Logo">
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<div class="container">
				<img src="<?= base_url('assets/sipeka-logo-text.svg') ?>" class="img-fluid nav-logo-desktop"
					alt="SiPeka Logo">
				<ul class="navbar-nav ml-auto nav-right" data-easing="easeInOutExpo" data-speed="1250" data-offset="65">
					<li class="nav-item nav-custom-link">
						<a class="nav-link" href="#hero">Beranda <i class="icon ion-ios-arrow-forward icon-mobile"></i></a>
					</li>
					<li class="nav-item nav-custom-link">
						<a class="nav-link" href="#features">Fitur <i class="icon ion-ios-arrow-forward icon-mobile"></i></a>
					</li>
					<li class="nav-item nav-custom-link">
						<a class="nav-link" href="#testimonials">Karyawan <i class="icon ion-ios-arrow-forward icon-mobile"></i></a>
					</li>
					<li class="nav-item nav-custom-link">
						<a class="nav-link" href="#activities">Aktivitas <i class="icon ion-ios-arrow-forward icon-mobile"></i></a>
					</li>
					<li class="nav-item nav-custom-link btn btn-demo-small">
						<a class="nav-link" href="<?= base_url('C_Auth') ?>">Login <i class="icon ion-ios-arrow-forward icon-mobile"></i></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Hero Section -->
	<section id="hero">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 content-box hero-content">
					<span>Sistem Penilaian Kerja Karyawan</span>
					<h1>Tingkatkan Produktivitas dengan <b>Penilaian Kinerja Digital</b></h1>
					<p>Kelola dan monitor kinerja karyawan dengan lebih efisien dan transparan</p>
					<div class="stats-container mt-4">
						<div class="row">
							<div class="col-md-6 mb-3">
								<div class="stat-box">
									<h3><?= $stats['total_karyawan'] ?></h3>
									<p>Total Karyawan</p>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="stat-box">
									<h3><?= $stats['total_divisi'] ?></h3>
									<p>Divisi</p>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="stat-box">
									<h3><?= $stats['total_tasks'] ?></h3>
									<p>Total Tugas</p>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="stat-box">
									<h3><?= number_format(($stats['completed_tasks'] / $stats['total_tasks']) * 100, 1) ?>%
									</h3>
									<p>Tingkat Penyelesaian</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<!-- <img src="<?= base_url('assets/images/hero-illustration.png') ?>" class="img-fluid"
						alt="Hero Illustration"> -->
				</div>
			</div>
		</div>
	</section>

	<!-- Features Section -->
	<section id="features">
		<div class="container">
			<div class="title-block">
				<h2>Fitur Utama</h2>
				<p>Berbagai fitur yang memudahkan proses penilaian kinerja karyawan</p>
			</div>
			<div class="row">
				<div class="col-md-4 mb-4">
					<div class="feature-box">
						<i class="icon ion-md-analytics ion-md-large"></i>
						<h5>Monitoring Real-time</h5>
						<p>Pantau kinerja karyawan secara real-time dengan dashboard interaktif</p>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="feature-box">
						<i class="icon ion-md-list-box ion-md-large"></i>
						<h5>Manajemen Tugas</h5>
						<p>Kelola dan distribusikan tugas dengan sistem yang terorganisir</p>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="feature-box">
						<i class="icon ion-md-stats ion-md-large"></i>
						<h5>Laporan & Analisis</h5>
						<p>Generate laporan kinerja detail dengan visualisasi data yang informatif</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Top Performers Section -->
	<section id="testimonials">
		<div class="container">
			<div class="title-block">
				<h2>Karyawan Terbaik</h2>
				<p>Penghargaan untuk kinerja luar biasa dari tim kami</p>
			</div>
			<div class="row">
				<?php foreach ($top_performers as $performer): ?>
					<div class="col-md-4 mb-4">
						<div class="testimonial-box">
							<div class="personal-info">
								<h6><?= $performer['nama'] ?></h6>
								<small><?= $performer['nama_divisi'] ?></small>
							</div>
							<div class="performance-stats">
								<p>Total Tugas: <?= $performer['total_tasks'] ?><br>
									Tugas Selesai: <?= $performer['completed_tasks'] ?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Recent Activities Section -->
	<section id="activities">
		<div class="container">
			<div class="title-block">
				<h2>Aktivitas Terbaru</h2>
				<p>Update real-time dari aktivitas tim kami</p>
			</div>
			<div class="row">
				<?php foreach ($recent_activities as $activity): ?>
					<div class="col-md-6 mb-4">
						<div class="activity-box">
							<h5><?= $activity['title'] ?></h5>
							<p>Oleh: <?= $activity['nama'] ?>	(<?= $activity['nama_divisi'] ?>)<br>
								Selesai: <?= date('d M Y H:i', strtotime($activity['finished_at'])) ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Call to Action -->
	<section id="call-to-action">
		<div class="container text-center">
			<h2>Mulai Gunakan SiPeka Sekarang</h2>
			<div class="title-block">
				<p>Tingkatkan efisiensi penilaian kinerja karyawan dengan sistem yang terintegrasi</p>
				<a href="<?= base_url('C_Auth') ?>" class="btn btn-regular">Mulai Sekarang</a>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<h5>SiPeka</h5>
					<p>Sistem Penilaian Kerja Karyawan yang memudahkan proses monitoring dan evaluasi kinerja secara
						digital.</p>
				</div>
				<div class="col-md-4">
					<!-- <h5>Tautan</h5>
					<ul>
						<li><a href="#hero">Beranda</a></li>
						<li><a href="#features">Fitur</a></li>
						<li><a href="#statistics">Statistik</a></li>
						<li><a href="<?= base_url('C_Auth') ?>">Login</a></li>
					</ul> -->
				</div>
				<div class="col-md-4">
					<h5>Kontak</h5>
					<p>Email: razan.alfsolution@gmail.com<br></p>
				</div>
			</div>
			<div class="divider"></div>
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<!-- <a href="#"><i class="icon ion-logo-facebook"></i></a>
					<a href="#"><i class="icon ion-logo-instagram"></i></a>
					<a href="#"><i class="icon ion-logo-twitter"></i></a> -->
				</div>
				<div class="col-md-6 col-xs-12">
					<small>Template from: <a href="https://www.behance.net/gallery/67279127/The-Seo-Company-Free-PSD-Template">The Seo Company</a></small> <br>
					<small>&copy; <?= date('Y') ?>	SiPeka. All rights reserved.</small>
				</div>
			</div>
		</div>
	</footer>

	<!-- JavaScript -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>
