<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Nilai Jobsheet</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Nilai Jobsheet</li>
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
						<form action="<?= base_url() . 'C_Penilai/updateNilaiJobsheet' ?>" method="post"
							id="formNilaiJobsheet" enctype="multipart/form-data">
							<div class="card-header">
								<h3 class="card-title">Nilai Data Jobsheet</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<p><strong>Judul:</strong> <?= $jobsheet['title'] ?></p>
										<?php foreach ($karyawan as $k): ?>
											<?php if ($k['id_user'] == $jobsheet['id_user']): ?>
												<p><strong>Dikerjakan Oleh:</strong> <?= $k['nama'] ?></p>
											<?php endif; ?>
										<?php endforeach; ?>
										<p><strong>Tanggal Mulai:</strong> <?= $jobsheet['tasked_at'] ?></p>
										<p><strong>Deadline:</strong> <?= $jobsheet['deadline'] ?></p>
										<p><strong>Status:</strong> <?= $jobsheet['status'] ?></p>
									</div>
									<div class="col-md-6">
										<p><strong>Deskripsi:</strong></p>
										<p><?= $jobsheet['description'] ?></p>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<?php if ($jobsheet['references_id']): ?>
											<div class="form-group">
												<label>Reference Attachments:</label>
												<div class="list-group mb-2">
													<?php
													$ref_attachments = $this->Penilai_model->getAttachments($jobsheet['references_id']);
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
											</div>
										<?php endif; ?>
									</div>
									<div class="col-md-6">
										<?php if ($jobsheet['attach_result_id']): ?>
											<div class="form-group">
												<label>Result Attachments:</label>
												<div class="list-group mb-2">
													<?php
													$result_attachments = $this->Penilai_model->getAttachments($jobsheet['attach_result_id']);
													for ($i = 1; $i <= 5; $i++):
														$field = 'atch' . $i;
														if (!empty($result_attachments[$field])):
													?>
															<div class="list-group-item d-flex justify-content-between align-items-center">
																<a href="<?= base_url('uploads/jobsheet/' . $result_attachments[$field]) ?>"
																	target="_blank" class="btn btn-link">
																	<?php if (in_array(pathinfo($result_attachments[$field], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])): ?>
																		<img src="<?= base_url('uploads/jobsheet/' . $result_attachments[$field]) ?>"
																			alt="Attachment" height="50">
																	<?php else: ?>
																		<i class="fas fa-file"></i> <?= $result_attachments[$field] ?>
																	<?php endif; ?>
																</a>
															</div>
													<?php
														endif;
													endfor;
													?>
												</div>
											</div>
										<?php endif; ?>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="nilai">Nilai <span class="text-danger">*</span></label>
											<input type="number" class="form-control" name="nilai" id="nilai" min="0" max="100" step="1" value="<?= $jobsheet['nilai'] ?>" onkeyup="validateNilai(this)" oninput="validateNilai(this)" required>
											<small class="text-danger" id="nilai_error"></small>
										</div>
									</div>
								</div>
								<input type="hidden" name="id_jobsheet" value="<?= $jobsheet['id_jobsheet'] ?>">
								<!-- /.card-body -->
							</div>
							<div class="card-footer">
								<div class="row">
									<div class="col">
										<button type="button" class="btn btn-danger"
											onclick="batal()">Batal</button>
										<button type="button" class="btn btn-warning"
											onclick="resetForm()">Reset</button>
									</div>
									<div class="col text-right">
										<button type="submit" class="btn btn-primary"
											onclick="simpanJobsheet(event)">Submit</button>
									</div>
								</div>
							</div>
						</form>

					</div>
					<!-- /.card -->

					<?php if (!empty($revisions)): ?>
						<div class="card mt-3">
							<div class="card-header">
								<h3 class="card-title">History Revisi</h3>
							</div>
							<div class="card-body">
								<div class="timeline">
									<?php foreach ($revisions as $r): ?>
										<div>
											<i class="fas fa-history bg-yellow"></i>
											<div class="timeline-item elevation-1">
												<span class="time">
													<i class="fas fa-clock"></i>
													<?= date('Y-m-d H:i', strtotime($r['revised_at'])) ?>
												</span>
												<h3 class="timeline-header">
													Revisi no <?= $r['revision_count'] ?> oleh <?= $r['revised_by_name'] ?>
												</h3>
												<div class="timeline-body">
													<p><strong>Catatan dari Tim Penilai:</strong> <?= $r['revision_note'] ?></p>
													<?php if (!empty($r['karyawan_comment'])): ?>
														<p><strong>Respon Karyawan:</strong> <?= $r['karyawan_comment'] ?></p>
													<?php endif; ?>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($jobsheet): ?>
						<div class="card mt-3">
							<form id="formRevisiJobsheet" action="<?= base_url('C_Penilai/reviseJobsheet/' . $jobsheet['id_jobsheet']) ?>" method="post">
								<div class="card-header">
									<h3 class="card-title">Minta Revisi</h3>
								</div>
								<div class="card-body">
									<div class="form-group">
										<label for="revision_note">Catatan <span class="text-danger">*</span></label>
										<textarea class="form-control" name="revision_note" required></textarea>
										<small class="text-danger" id="revision_note_error"></small>
									</div>
									<div class="form-group">
										<label for="new_deadline">Deadline Baru <span class="text-danger">*</span></label>
										<input type="datetime-local" class="form-control" name="new_deadline" required>
										<small class="text-danger" id="new_deadline_error"></small>
									</div>
								</div>
								<div class="card-footer">
									<div class="row">
										<div class="col">
										</div>
										<div class="col text-right">
											<button type="submit" class="btn btn-warning"
												onclick="submitRevisi(event)">Revisi!</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					<?php endif; ?>
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
	var redirecUrl = null;
	if (urlParams.get('from') === 'pending') {
		redirecUrl = '<?= base_url() . 'C_Penilai/jobsheetPending' ?>';
	} else if (urlParams.get('from') === 'onprogress') {
		redirecUrl = '<?= base_url() . 'C_Penilai/jobsheetOnProgress' ?>';
	} else if (urlParams.get('from') === 'completed') {
		redirecUrl = '<?= base_url() . 'C_Penilai/jobsheetCompleted' ?>';
	} else {
		redirecUrl = '<?= base_url() . 'C_Penilai' ?>';
	}

	const inputFields = ['nilai', 'revision_note', 'new_deadline'];

	inputFields.forEach(fieldId => {
		document.getElementById(fieldId).addEventListener('input', function() {
			document.getElementById(`${fieldId}_error`).innerText = '';
		});
	});


	function batal(event) {
		Swal.fire({
			title: 'Apakah anda yakin?',
			text: "Data yang diinputkan tidak akan tersimpan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, tetap kembali!',
			cancelButtonText: 'Tidak, tetap dihalaman ini!'
		}).then((result) => {
			if (result.isConfirmed) {
				document.location.href = redirecUrl;
			}
		})
	};

	function resetForm(event) {
		Swal.fire({
			title: 'Apakah anda yakin?',
			text: "Data yang diinputkan akan dikosongkan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, tetap reset!',
			cancelButtonText: 'Tidak, jangan reset!'
		}).then((result) => {
			if (result.isConfirmed) {
				document.getElementById('formNilaiJobsheet').reset();
			}
		})
	};

	function submitRevisi(event) {
		event.preventDefault();

		const revisionNote = document.querySelector('textarea[name="revision_note"]').value.trim();
		const newDeadline = document.querySelector('input[name="new_deadline"]').value.trim();

		if (!revisionNote) {
			document.getElementById('revision_note_error').innerText = 'Catatan tidak boleh kosong';
			return;
		}

		if (!newDeadline) {
			document.getElementById('new_deadline_error').innerText = 'Tanggal deadline tidak boleh kosong';
			return;
		}

		if (new Date(newDeadline) < new Date()) {
			document.getElementById('new_deadline_error').innerText = 'Tanggal deadline tidak boleh lebih kecil dari tanggal sekarang';
			return;
		}

		Swal.fire({
			title: 'Apakah anda yakin?',
			text: "Data yang diinputkan akan tersimpan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, tetap simpan!',
			cancelButtonText: 'Tidak, tetap dihalaman ini!'
		}).then((result) => {
			if (result.isConfirmed) {
				document.getElementById('formRevisiJobsheet').submit();
			}
		})
	}

	function simpanJobsheet(event) {
		event.preventDefault();
		const nilai = document.getElementById('nilai').value.trim();

		if (!nilai) {
			document.getElementById('nilai_error').innerText = 'Nilai tidak boleh kosong';
			return;
		}

		Swal.fire({
			title: 'Apakah anda yakin?',
			text: "Data yang diinputkan akan tersimpan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, tetap simpan!',
			cancelButtonText: 'Tidak, tetap dihalaman ini!'
		}).then((result) => {
			if (result.isConfirmed) {
				document.getElementById('formNilaiJobsheet').submit();
			}
		})
	};

	function validateNilai(input) {
		input.value = input.value.replace(/^0+|[^0-9]/g, '');

		let value = parseInt(input.value);

		if (isNaN(value)) {
			input.value = 0;
			return;
		}

		if (value < 0) {
			input.value = 0;
		} else if (value > 100) {
			input.value = 100;
		}
	}
</script>
