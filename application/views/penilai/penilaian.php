<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Data Penilaian Kinerja Karyawan</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Penilaian Kinerja</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">

			<div class="card card-primary collapsed-card">
				<div class="card-header">
					<h3 class="card-title">Filter Penilaian</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-plus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<form id="filterForm" action="<?= base_url('C_Penilai/penilaian') ?>" method="get">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Divisi</label>
									<select class="form-control" name="divisi">
										<option value="">Semua Divisi</option>
										<?php foreach ($divisi_list as $div): ?>
											<option value="<?= $div['id_divisi'] ?>"
												<?= ($selected_divisi == $div['id_divisi']) ? 'selected' : '' ?>>
												<?= $div['nama_divisi'] ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Periode</label>
									<select class="form-control" name="periode">
										<option value="all" <?= ($selected_periode == 'all') ? 'selected' : '' ?>>Semua
											Waktu</option>
										<option value="month" <?= ($selected_periode == 'month') ? 'selected' : '' ?>>Bulan
											Ini</option>
										<option value="semester" <?= ($selected_periode == 'semester') ? 'selected' : '' ?>>Semester Ini</option>
										<option value="year" <?= ($selected_periode == 'year') ? 'selected' : '' ?>>Tahun
											Ini</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>&nbsp;</label>
									<button type="submit" class="btn btn-primary btn-block">
										<i class="fas fa-filter"></i> Terapkan Filter
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3 col-6">
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?= $summary['total_karyawan'] ?></h3>
							<p>Total Karyawan</p>
						</div>
						<div class="icon">
							<i class="fas fa-users"></i>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?= $summary['avg_completion_rate'] ?>%</h3>
							<p>Rata-rata Penyelesaian</p>
						</div>
						<div class="icon">
							<i class="fas fa-chart-line"></i>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-warning">
						<div class="inner">
							<h3><?= $summary['total_active_tasks'] ?></h3>
							<p>Tugas Aktif</p>
						</div>
						<div class="icon">
							<i class="fas fa-tasks"></i>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?= $summary['overdue_tasks'] ?></h3>
							<p>Tugas Terlambat</p>
						</div>
						<div class="icon">
							<i class="fas fa-clock"></i>
						</div>
					</div>
				</div>
			</div>

			<?php foreach ($performance_by_divisi as $divisi_name => $karyawan_list): ?>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Divisi: <?= $divisi_name ?></h3>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Nama Karyawan</th>
										<th>Total Tugas</th>
										<th>Selesai</th>
										<th>Dalam Proses</th>
										<th>Pending</th>
										<th>Ketepatan Waktu</th>
										<th>Progress</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($karyawan_list as $k): ?>
										<tr>
											<td><?= $k['nama'] ?></td>
											<td><?= $k['total_jobs'] ?></td>
											<td><?= $k['completed_jobs'] ?></td>
											<td><?= $k['onprogress_jobs'] ?></td>
											<td><?= $k['pending_jobs'] ?></td>
											<td>
												<div class="progress">
													<div class="progress-bar bg-success" role="progressbar"
														style="width: <?= $k['ontime_rate'] ?>%">
														<?= $k['ontime_rate'] ?>%
													</div>
												</div>
											</td>
											<td>
												<div class="progress">
													<div class="progress-bar bg-primary" role="progressbar"
														style="width: <?= $k['completion_rate'] ?>%">
														<?= $k['completion_rate'] ?>%
													</div>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
</div>
