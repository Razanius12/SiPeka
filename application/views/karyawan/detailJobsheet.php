<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Detail Jobsheet</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Detail Jobsheet</li>
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
							<h3 class="card-title"><?= $jobsheet['title'] ?></h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<p><strong>Tanggal Mulai:</strong> <?= $jobsheet['tasked_at'] ?></p>
									<p><strong>Deadline:</strong> <?= $jobsheet['deadline'] ?></p>
									<p><strong>Status:</strong> <?= $jobsheet['status'] ?></p>
									<p><strong>Hari Tersisa:</strong>
										<?php if ($jobsheet['days_left'] < 0): ?>
											<span class="badge badge-danger"><?= $jobsheet['days_left'] ?>	Hari</span>
										<?php elseif ($jobsheet['days_left'] <= 2): ?>
											<span class="badge badge-warning"><?= $jobsheet['days_left'] ?>	Hari</span>
										<?php else: ?>
											<span class="badge badge-success"><?= $jobsheet['days_left'] ?>	Hari</span>
										<?php endif; ?>
								</div>
								<div class="col-md-6">
									<p><strong>Deskripsi:</strong></p>
									<p><?= nl2br(htmlspecialchars($jobsheet['description'])) ?></p>
								</div>
								<?php if ($jobsheet['is_revision']): ?>
									<div class="col-12">
										<div class="card card-warning">
											<div class="card-header">
												<h3 class="card-title">Informasi Revisi</h3>
											</div>
											<div class="card-body">
												<div class="timeline">
													<?php foreach ($revisions as $r): ?>
														<div>
															<i class="fas fa-history bg-yellow"></i>
															<div class="timeline-item">
																<span class="time">
																	<i class="fas fa-clock"></i>
																	<?= date('Y-m-d H:i', strtotime($r['revised_at'])) ?>
																</span>
																<h3 class="timeline-header">
																	Revisi no <?= $r['revision_count'] ?> oleh <?= $r['revised_by_name'] ?>
																</h3>
																<div class="timeline-body">
																	<p><strong>Revision Note:</strong> <?= $r['revision_note'] ?></p>
																	<?php if (!empty($r['karyawan_comment'])): ?>
																		<p><strong>Karyawan Response:</strong> <?= $r['karyawan_comment'] ?></p>
																	<?php endif; ?>
																</div>
															</div>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<div class="col-md-6">
									<?php if ($jobsheet['references_id']): ?>
										<label>Attachments:</label>
										<div class="list-group mb-2">
											<?php
											for ($i = 1; $i <= 5; $i++):
												$field = 'atch' . $i;
												if (!empty($ref_attachments[$field])):
													?>
													<div class="list-group-item d-flex justify-content-between align-items-center">
														<a href="<?= base_url('uploads/jobsheet/' . $ref_attachments[$field]) ?>"
															target="_blank" class="btn btn-link">
															<?php if (in_array(pathinfo($ref_attachments[$field], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])): ?>
																<img src="<?= base_url('uploads/jobsheet/' . $ref_attachments[$field]) ?>"
																	alt="Attachment" height="50">
															<?php else: ?>
																<i class="fas fa-file"></i> <?= $ref_attachments[$field] ?>
															<?php endif; ?>
														</a>
													</div>
													<?php
												endif;
											endfor;
											?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col">
									<a href="<?= base_url('C_Karyawan/jobsheetPending') ?>"
										class="btn btn-primary">Kembali</a>
								</div>
								<div class="col text-right">
									<a href="<?= base_url() . 'C_Karyawan/ambilJobsheet/' . $jobsheet['id_jobsheet'] ?>"
										class="btn btn-success">Ambil</a>
								</div>
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
