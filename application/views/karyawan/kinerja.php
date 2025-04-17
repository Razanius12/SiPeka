<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Kinerja Kerja Anda</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Kinerja Kerja</li>
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
							<h3 class="card-title">Kinerja Kerja</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="info-box bg-purple">
										<span class="info-box-icon"><i class="fas fa-star"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Average Jobs Score</span>
											<span class="info-box-number">
												<?php if ($performance['completed_jobs'] > 0): ?>
													<?= $performance['average_nilai'] ?>
												<?php else: ?>
													N/A
												<?php endif; ?>
											</span>
										</div>
									</div>
									<div class="info-box bg-info">
										<span class="info-box-icon"><i class="fas fa-tasks"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Total Jobs</span>
											<span class="info-box-number"><?= $performance['total_jobs'] ?></span>
										</div>
									</div>
									<div class="info-box bg-success">
										<span class="info-box-icon"><i class="fas fa-check"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Completed Jobs</span>
											<span class="info-box-number"><?= $performance['completed_jobs'] ?></span>
										</div>
									</div>
									<div class="info-box bg-warning">
										<span class="info-box-icon"><i class="fas fa-clock"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Pending Jobs</span>
											<span class="info-box-number"><?= $performance['pending_jobs'] ?></span>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card card-primary">
										<div class="card-header">
											<h3 class="card-title">Performance Metrics</h3>
										</div>
										<div class="card-body">
											<div class="progress-group">
												Completion Rate
												<span class="float-right"><?= $performance['completion_rate'] ?>%</span>
												<div class="progress">
													<div class="progress-bar bg-primary"
														style="width: <?= $performance['completion_rate'] ?>%"></div>
												</div>
											</div>
											<div class="progress-group mt-4">
												On-time Completion Rate
												<span class="float-right"><?= $performance['ontime_rate'] ?>%</span>
												<div class="progress">
													<div class="progress-bar bg-success"
														style="width: <?= $performance['ontime_rate'] ?>%"></div>
												</div>
											</div>
											<div class="progress-group mt-4">
												Average Jobs Score
												<span class="float-right"><?= $performance['average_nilai'] ?></span>
												<div class="progress">
													<div class="progress-bar bg-purple"
														style="width: <?= $performance['average_nilai'] ?>%">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card mt-4">
								<div class="card-header">
									<h3 class="card-title">Recent Job History</h3>
								</div>
								<div class="card-body table-responsive p-0">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Title</th>
												<th>Status</th>
												<th>Assigned</th>
												<th>Deadline</th>
												<th>Days Left</th>
												<th>Score</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($recent_jobs as $job): ?>
												<tr>
													<td><?= $job['title'] ?></td>
													<td><span
															class="badge badge-<?= $job['status'] == 'COMPLETED' ? 'success' : ($job['status'] == 'ON PROGRESS' ? 'warning' : 'info') ?>"><?= $job['status'] ?></span>
													</td>
													<td><?= date('Y-m-d', strtotime($job['tasked_at'])) ?></td>
													<td><?= date('Y-m-d', strtotime($job['deadline'])) ?></td>
													<td><?= $job['days_left'] ?></td>
													<td>
														<?php if ($job['nilai'] == 0): ?>
															<span class="badge badge-danger">Belum Dinilai</span>
														<?php elseif ($job['nilai'] <= 60): ?>
															<span class="badge badge-warning"><?= $job['nilai'] ?></span>
														<?php else: ?>
															<span class="badge badge-success"><?= $job['nilai'] ?></span>
														<?php endif; ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
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
