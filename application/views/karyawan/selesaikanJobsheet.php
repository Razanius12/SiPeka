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
						<form action="<?= base_url() . 'C_Karyawan/submitJobsheet' ?>" method="post"
							id="formEditJobsheet" enctype="multipart/form-data">
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
												<span class="badge badge-danger"><?= $jobsheet['days_left'] ?> Hari</span>
											<?php elseif ($jobsheet['days_left'] <= 2): ?>
												<span class="badge badge-warning"><?= $jobsheet['days_left'] ?> Hari</span>
											<?php else: ?>
												<span class="badge badge-success"><?= $jobsheet['days_left'] ?> Hari</span>
											<?php endif; ?>
									</div>
									<div class="col-md-6">
										<p><strong>Deskripsi:</strong></p>
										<p><?= $jobsheet['description'] ?></p>
									</div>
									<div class="col-md-6">
										<?php if ($jobsheet['references_id']): ?>
											<label>Attachments:</label>
											<div class="list-group mb-2">
												<?php
												for ($i = 1; $i <= 5; $i++):
													$field = 'atch' . $i;
													if (!empty($ref_attachments[$field])):
												?>
														<div
															class="list-group-item d-flex justify-content-between align-items-center">
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
									<div class="col-md-6">
										<div class="form-group">
											<label for="attachments">Submit Attachments (Max 5 files)
												<span class="text-danger">*</span>
											</label>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="attachments"
													name="attachments[]" multiple
													accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip,.rar"
													onchange="validateFiles(this)" required>
												<label class="custom-file-label" for="attachments">Choose files</label>
											</div>
											<small class="text-muted">Allowed files: PDF, DOC, DOCX, XLS, XLSX, JPG,
												JPEG, PNG,
												ZIP, RAR (Max 32MB each)</small>
											<div id="fileList" class="mt-2"></div>
										</div>
									</div>
								</div>
							</div>
							<?php if ($jobsheet['is_revision']): ?>
								<div class="col-12">
									<div class="form-group">
										<label for="karyawan_comment">Komentar Anda <span class="text-danger">*</span></label>
										<textarea class="form-control" id="karyawan_comment" name="karyawan_comment" rows="3" required></textarea>
									</div>
								</div>
							<?php endif; ?>
							<input type="hidden" name="id_jobsheet" value="<?= $jobsheet['id_jobsheet'] ?>">
							<div class="card-footer">
								<div class="row">
									<div class="col">
										<a href="<?= base_url('C_Karyawan/jobsheetOnProgress') ?>"
											class="btn btn-danger">Kembali</a>
									</div>
									<div class="col text-right">
										<button type="submit" class="btn btn-primary"
											onclick="simpan(event)">Submit</button>
									</div>
								</div>
							</div>
							<!-- /.card-body -->
						</form>
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
	function simpan(event) {
		event.preventDefault();
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
				document.getElementById('formEditJobsheet').submit();
			}
		})
	};

	function validateFiles(input) {
		const maxFiles = 5;
		const maxSize = 32 * 1024 * 1024; // 32MB
		const allowedTypes = ['application/pdf', 'application/msword',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'application/vnd.ms-excel',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'image/jpeg', 'image/png', 'application/zip', 'application/x-rar-compressed'
		];

		if (input.files.length > maxFiles) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: `You can only upload a maximum of ${maxFiles} files!`,
			});
			input.value = '';
			return false;
		}

		const fileList = document.getElementById('fileList');
		fileList.innerHTML = '';

		for (let file of input.files) {
			if (file.size > maxSize) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: `File ${file.name} is too large!`,
				});
				input.value = '';
				return false;
			}
			if (!allowedTypes.includes(file.type)) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: `File ${file.name} is not allowed!`,
				});
				input.value = '';
				return false;
			}
			fileList.innerHTML += `<div class="mt-1"><i class="fas fa-file"></i> ${file.name}</div>`;
		}
		const label = input.nextElementSibling;
		label.textContent = input.files.length > 1 ? `${input.files.length} files selected` : input.files[0].name;
		return true;
	}
</script>
