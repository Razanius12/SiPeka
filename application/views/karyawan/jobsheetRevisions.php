<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Revised Jobsheets</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Revised Jobsheets</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Tasks Requiring Revision</h3>
						</div>
						<div class="card-body">
							<?php if (empty($revised_jobs)): ?>
								<div role="alert">
									No tasks requiring revision at the moment.
								</div>
							<?php else: ?>
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Judul</th>
											<th>Revisi ke</th>
											<th>Di revisi oleh</th>
											<th>Tanggal Revisi</th>
											<th>Catatan</th>
											<th>Deadline baru</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($revised_jobs as $job): ?>
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
								</table>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
