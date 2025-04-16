<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Dashboard</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Dashboard v1</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-lg-3 col-6">
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?= $performance['total_jobs'] ?></h3>
							<p>Total Jobs</p>
						</div>
						<div class="icon">
							<i class="fas fa-tasks"></i>
						</div>
						<a href="<?= base_url('C_Karyawan/kinerja') ?>" class="small-box-footer">More info <i
								class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?= $performance['completion_rate'] ?><sup style="font-size: 20px">%</sup></h3>
							<p>Completion Rate</p>
						</div>
						<div class="icon">
							<i class="fas fa-chart-line"></i>
						</div>
						<a href="<?= base_url('C_Karyawan/kinerja') ?>" class="small-box-footer">More info <i
								class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-warning">
						<div class="inner">
							<h3><?= $performance['onprogress_jobs'] ?></h3>
							<p>Tasks In Progress</p>
						</div>
						<div class="icon">
							<i class="fas fa-spinner"></i>
						</div>
						<a href="<?= base_url('C_Karyawan/jobsheetOnProgress') ?>" class="small-box-footer">More info <i
								class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?= $performance['pending_jobs'] ?></h3>
							<p>Pending Tasks</p>
						</div>
						<div class="icon">
							<i class="fas fa-clock"></i>
						</div>
						<a href="<?= base_url('C_Karyawan/jobsheetPending') ?>" class="small-box-footer">More info <i
								class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Revisi Tugas</h3>
						</div>
						<div class="card-body">
							<table class="table table-hover">
								<?php if (empty($revised_jobs)): ?>
									<div role="alert">
										Tidak ada tugas yang direvisi untuk sekarang
									</div>
								<?php else: ?>
									<thead>
										<tr>
											<th>Judul</th>
											<th>Revisi ke</th>
											<th>Di Revisi Oleh</th>
											<th>Tanggal Revisi</th>
											<th>Catatan</th>
											<th>Deadline Baru</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										// Limit to 3 items
										$limited_revisions = array_slice($revised_jobs, 0, 3);
										foreach ($limited_revisions as $job):
										?>
											<tr>
												<td><?= $job['title'] ?></td>
												<td>
													<?php if ($job['revision_count'] == 1): ?>
														<span class="badge badge-info">Revisi no <?= $job['revision_count'] ?></span>
													<?php elseif ($job['revision_count'] == 2): ?>
														<span class="badge badge-warning">Revisi no <?= $job['revision_count'] ?></span>
													<?php else: ?>
														<span class="badge badge-danger">Revisi no <?= $job['revision_count'] ?></span>
													<?php endif; ?>
												</td>
												<td><?= $job['revised_by_name'] ?></td>
												<td><?= date('Y-m-d H:i', strtotime($job['revised_at'])) ?></td>
												<td><?= $job['revision_note'] ?></td>
												<td><?= date('Y-m-d', strtotime($job['deadline'])) ?></td>
												<td>
													<a href="<?= base_url('C_Karyawan/detailJobsheet/' . $job['id_jobsheet']) ?>"
														class="btn btn-primary btn-sm">
														<i class="fas fa-eye"></i> Lihat
													</a>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
									<?php if (count($revised_jobs) > 3): ?>
										<tfoot>
											<tr>
												<td colspan="7" class="text-center">
													<a href="<?= base_url('C_Karyawan/jobsheetRevisions') ?>" class="btn btn-link">
														Lihat semua <?= count($revised_jobs) ?> revisi jobsheet
													</a>
												</td>
											</tr>
										</tfoot>
									<?php endif; ?>
								<?php endif; ?>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Jobsheet Selesai Terbaru</h3>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Judul</th>
										<th>Status</th>
										<th>Deadline</th>
										<th>Hari Tersisa</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($recent_jobs as $job): ?>
										<tr>
											<td><?= $job['title'] ?></td>
											<td><span
													class="badge badge-<?= $job['status'] == 'COMPLETED' ? 'success' : ($job['status'] == 'ON PROGRESS' ? 'warning' : 'info') ?>"><?= $job['status'] ?></span>
											</td>
											<td><?= date('Y-m-d', strtotime($job['deadline'])) ?></td>
											<td><?= $job['days_left'] ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- /.row -->
			<!-- Main row -->
			<div class="row">
				<!-- <?= '<pre>';
									print_r($this->session->all_userdata()); ?>	-->
			</div>
			<!-- /.row (main row) -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
