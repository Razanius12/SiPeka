<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Data Jobsheet Completed</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Jobsheet Completed</li>
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
							<h3 class="card-title">Jobsheet Completed</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<?php if (empty($jobsheet)): ?>
								<div role="alert">
									Anda belum menyelesaikan jobsheet sama sekali
								</div>
							<?php else: ?>
								<table id="jobsheetTable" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Judul</th>
											<th>Tanggal Mulai</th>
											<th>Tanggal Selesai</th>
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
												<td><?= date('Y-m-d', strtotime($j['tasked_at'])) ?></td>
												<td><?= date('Y-m-d', strtotime($j['finished_at'])) ?></td>
												<td><?= date('Y-m-d', strtotime($j['deadline'])) ?></td>
												<td>
													<?php if ($j['days_left'] <= 0): ?>
														<span class="badge badge-danger"><?= $j['days_left'] ?>	Hari</span>
													<?php elseif ($j['days_left'] <= 2): ?>
														<span class="badge badge-warning"><?= $j['days_left'] ?>	Hari</span>
													<?php else: ?>
														<span class="badge badge-success"><?= $j['days_left'] ?>	Hari</span>
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
													<a href="<?= base_url() . 'C_Karyawan/detailJobsheetCompleted/' . $j['id_jobsheet'] ?>"
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
	const urlParams = new URLSearchParams(window.location.search);
	const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
	if (urlParams.get('status') === 'selesai') {
		Swal.fire({
			icon: 'success',
			title: 'Berhasil',
			text: 'Jobsheet telah	diselesaikan',
		}).then(() => {
			window.history.replaceState({ path: newUrl }, '', newUrl);
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		$(document).ready(function () {
			$('#jobsheetTable').DataTable({
				"pageLength": 10,
				"order": [[2, "desc"]],
				responsive: true,
				language: {
					search: "_INPUT_",
					searchPlaceholder: "Search...",
					lengthMenu: "Show _MENU_ entries"
				},
			});
		});
	});
</script>
