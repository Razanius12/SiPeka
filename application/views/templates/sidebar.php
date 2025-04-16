<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-2">
	<!-- Brand Logo -->
	<a href="#" class="brand-link">
	<img src="<?= base_url('assets/sipeka-logo.svg') ?>" class="brand-image"
					alt="SiPeka Logo">
		<span class="brand-text font-weight-light">SiPeka</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<!-- <div class="image">
				<img src="<?= base_url() ?>alte/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
					alt="User Image">
			</div> -->
			<div class="info">
				<a href="<?= base_url() . 'C_Admin/editProfil/' . $this->session->userdata('id_user') ?>"
					class="d-block"><?= $this->session->userdata('username') ?></a>
				<small class="d-block text-gray">
					<?= $this->session->userdata('role') ?>
				</small>
			</div>
		</div>

		<!-- SidebarSearch Form -->
		<!-- <div class="form-inline">
			<div class="input-group" data-widget="sidebar-search">
				<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
				<div class="input-group-append">
					<button class="btn btn-sidebar">
						<i class="fas fa-search fa-fw"></i>
					</button>
				</div>
			</div>
		</div> -->

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
						with font-awesome or any other icon font library -->

				<?php if ($this->session->userdata('role') == 'Tim Penilai'): ?>

					<li class="nav-item">
						<a href=" <?= base_url() . 'C_Penilai' ?>"
							class="nav-link <?= ($this->uri->segment(2) == '') ? 'active' : '' ?>">
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item">
						<a href=" <?= base_url() . 'C_Penilai/jobsheetPending' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'jobsheetPending') ? 'active' : '' ?>">
							<p>Data Jobsheet Pending</p>
						</a>
					</li>
					<li class="nav-item">
						<a href=" <?= base_url() . 'C_Penilai/jobsheetOnProgress' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'jobsheetOnProgress') ? 'active' : '' ?>">
							<p>Data Jobsheet On Progress</p>
						</a>
					</li>
					<li class="nav-item">
						<a href=" <?= base_url() . 'C_Penilai/jobsheetCompleted' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'jobsheetCompleted') ? 'active' : '' ?>">
							<p>Data Jobsheet Completed</p>
						</a>
					</li>
					<li class="nav-item">
						<a href=" <?= base_url() . 'C_Penilai/penilaian' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'penilaian') ? 'active' : '' ?>">
							<p>Penilaian Karyawan</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Penilai/laporan' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'laporan') ? 'active' : '' ?>">
							<p>Buat Laporan</p>
						</a>
					</li>


				<?php elseif ($this->session->userdata('role') == 'KepSek'): ?>

					<li class="nav-item">
						<a href=" <?= base_url() . 'C_KepSek' ?>"
							class="nav-link <?= ($this->uri->segment(2) == '') ? 'active' : '' ?>">
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item">
						<a href=" <?= base_url() . 'C_Penilai/penilaian' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'penilaian') ? 'active' : '' ?>">
							<p>Penilaian Karyawan</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Penilai/laporan' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'laporan') ? 'active' : '' ?>">
							<p>Buat Laporan</p>
						</a>
					</li>


				<?php elseif ($this->session->userdata('role') == 'Admin'): ?>

					<li class="nav-item">
						<a href=" <?= base_url() . 'C_Admin' ?>"
							class="nav-link <?= ($this->uri->segment(2) == '') ? 'active' : '' ?>">
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item">
						<a href=" <?= base_url() . 'C_Admin/divisi' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'divisi') ? 'active' : '' ?>">
							<p>Data Divisi</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Admin/karyawan' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'karyawan') ? 'active' : '' ?>">
							<p>Data Karyawan</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Admin/penilai' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'penilai') ? 'active' : '' ?>">
							<p>Data Tim Penilai</p>
						</a>
					</li>
					<!-- <li class="nav-item">
						<a href="<?= base_url() . 'C_Admin/kategori' ?>"
						class="nav-link <?= ($this->uri->segment(2) == 'kategori') ? 'active' : '' ?>">
							<p>Kelola Kategori Penilaian</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Admin/kinerja' ?>"
						class="nav-link <?= ($this->uri->segment(2) == 'kinerja') ? 'active' : '' ?>">
							<p>Kelola Pelaporan Kinerja</p>
						</a>
					</li> -->
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Penilai/laporan' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'laporan') ? 'active' : '' ?>">
							<p>Buat Laporan</p>
						</a>
					</li>


				<?php elseif ($this->session->userdata('role') == 'Karyawan'): ?>

					<li class="nav-item">
						<a href=" <?= base_url() . 'C_Karyawan' ?>"
							class="nav-link <?= ($this->uri->segment(2) == '') ? 'active' : '' ?>">
							<p>Dashboard</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Karyawan/jobsheetPending' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'jobsheetPending') ? 'active' : '' ?>">
							<p>Jobsheet Pending</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Karyawan/jobsheetOnProgress' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'jobsheetOnProgress') ? 'active' : '' ?>">
							<p>Jobsheet On Progress</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Karyawan/jobsheetCompleted' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'jobsheetCompleted') ? 'active' : '' ?>">
							<p>Jobsheet Completed</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Karyawan/jobsheetRevisions' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'jobsheetRevisions') ? 'active' : '' ?>">
							<p>Jobsheet Revisi</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url() . 'C_Karyawan/kinerja' ?>"
							class="nav-link <?= ($this->uri->segment(2) == 'kinerja') ? 'active' : '' ?>">
							<p>Kinerja Kerja</p>
						</a>
					</li>

				<?php endif; ?>

				<li class="nav-item">
					<a href="<?= base_url() . 'C_Auth/Logout' ?>" class="nav-link">
						<button class="btn btn-block btn-danger btn-sm">
							<p>Logout</p>
						</button>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
