<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Data Jobsheet Pending</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Jobsheet Pending</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Main row -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Jobsheet Pending</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<?php if (empty($jobsheet)): ?>
								<div role="alert">
									Tidak ada jobsheet yang pending untuk sekarang
								</div>
							<?php else: ?>
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Judul</th>
											<th>Tanggal Mulai</th>
											<th>Deadline</th>
											<th>Hari Tersisa</th>
											<th>Status Revisi</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($jobsheet as $j): ?>
											<tr>
												<td><?= $j['title'] ?></td>
												<td><?= $j['tasked_at'] ?></td>
												<td><?= $j['deadline'] ?></td>
												<td>
													<?php if ($j['days_left'] <= 0): ?>
														<span class="badge badge-danger"><?= $j['days_left'] ?> Hari</span>
													<?php elseif ($j['days_left'] <= 2): ?>
														<span class="badge badge-warning"><?= $j['days_left'] ?> Hari</span>
													<?php else: ?>
														<span class="badge badge-success"><?= $j['days_left'] ?> Hari</span>
													<?php endif; ?>
												</td>
												<td>
													<?php if ($j['current_revision'] == 0): ?>
														<span class="badge badge-secondary">Tidak ada Revisi</span>
													<?php else: ?>
														<span class="badge badge-info">Revisi no <?= $j['current_revision'] ?></span>
													<?php endif; ?>
												</td>
												<td>
													<a href="<?= base_url() . 'C_Karyawan/detailJobsheet/' . $j['id_jobsheet'] ?>"
														class="btn btn-primary btn-sm">
														<i class="fas fa-eye"></i> Lihat
													</a>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
								<div role="alert" class="mt-3">
									Segera klik tombol lihat dan kerjakan jobsheet yang sudah ditugaskan kepada anda.
								</div>
							<?php endif; ?>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</div>
			<!-- /.row (main row) -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
