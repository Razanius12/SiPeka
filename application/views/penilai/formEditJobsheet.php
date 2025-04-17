<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Edit Jobsheet</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Jobsheet</li>
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
						<form action="<?= base_url() . 'C_Penilai/updateJobsheet' ?>" method="post"
							id="formEditJobsheet" enctype="multipart/form-data">
							<div class="card-header">
								<h3 class="card-title">Edit Data Jobsheet</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="form-group">
									<label for="title">Judul <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="title" id="title" maxlength="255"
										required minlength="1" pattern="\S(.*\S)?" value="<?= $jobsheet['title'] ?>">
									<small class="text-danger" id="title_error"></small>
								</div>
								<div class="form-group">
									<label for="description">Deskripsi</label>
									<textarea class="form-control" name="description" id="description"
										rows="3"><?= $jobsheet['description'] ?></textarea>
									<small class="text-danger" id="description_error"></small>
								</div>
								<div class="form-group">
									<label for="tasked_at">Ditugaskan pada Tanggal</label>
									<input type="datetime-local" class="form-control" name="tasked_at" id="tasked_at"
										readonly value="<?= $jobsheet['tasked_at'] ?>" required>
									<small class="text-danger" id="tasked_at_error"></small>
								</div>
								<div class="form-group">
									<label for="deadline">Deadline <span class="text-danger">*</span></label>
									<input type="datetime-local" class="form-control" name="deadline" id="deadline"
										required value="<?= $jobsheet['deadline'] ?>">
									<small class="text-danger" id="deadline_error"></small>
								</div>
								<div class="card-footer">
									<div class="form-group">
										<label for="filter_divisi">Filter Divisi</label>
										<select class="form-control" name="filter_divisi" id="filter_divisi">
											<option value="">Semua Divisi</option>
											<?php
											$divisi_list = array();
											foreach ($karyawan as $k) {
												if (!isset($divisi_list[$k['id_divisi']])) {
													$divisi_list[$k['id_divisi']] = $k['nama_divisi'];
												}
											}
											foreach ($divisi_list as $id => $nama): ?>
												<option value="<?= $id ?>"><?= $nama ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group">
										<label for="id_user">Ditugaskan Kepada <span class="text-danger">*</span></label>
										<select class="form-control" name="id_user" id="id_user" required>
											<option value="">-- Pilih Karyawan --</option>
											<?php foreach ($karyawan as $k): ?>
												<option value="<?= $k['id_user'] ?>"
													data-divisi="<?= $k['id_divisi'] ?>"
													<?= ($jobsheet['id_user'] == $k['id_user']) ? 'selected' : '' ?>>
													<?= $k['nama'] ?>
												</option>
											<?php endforeach; ?>
										</select>
										<small class="text-danger" id="id_user_error"></small>
									</div>
								</div>
								<div class="form-group">
									<label for="status">Status</label>
									<select class="form-control" name="status" id="status">
										<option value="PENDING" <?= ($jobsheet['status'] == 'PENDING') ? 'selected' : '' ?>>Pending
										</option>
										<option value="ON PROGRESS" <?= ($jobsheet['status'] == 'ON PROGRESS') ? 'selected' : '' ?>>On Progress
										</option>
										<option value="COMPLETED" <?= ($jobsheet['status'] == 'COMPLETED') ? 'selected' : '' ?>>Completed
										</option>
									</select>
								</div>
								<div class="form-group">
									<label for="new_attachments">Tambahkan Referensi (Max 5 files)</label>
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="new_attachments"
											name="new_attachments[]" multiple
											accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip,.rar"
											onchange="validateFiles(this)">
										<label class="custom-file-label" for="new_attachments">Choose files</label>
									</div>
									<small class="text-muted">Allowed files: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG,
										ZIP, RAR (Max 32MB each)</small>
									<div id="fileList" class="mt-2"></div>
									<small class="text-danger" id="new_attachments_error"></small>
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
																<?php if (in_array(pathinfo($ref_attachments[$field], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])): ?>
																	<a href="<?= base_url('uploads/jobsheet/' . $ref_attachments[$field]) ?>"
																		target="_blank" class="btn btn-link">
																		<img src="<?= base_url('uploads/jobsheet/' . $ref_attachments[$field]) ?>"
																			alt="Attachment" height="50">
																	</a>
																	<button type="button" class="btn btn-danger btn-sm"
																		onclick="confirmDeleteSingleReference(<?= $i - 1 ?>)">
																		<i class="fas fa-trash"></i>
																	</button>
																<?php else: ?>
																	<a href="<?= base_url('uploads/jobsheet/' . $ref_attachments[$field]) ?>"
																		target="_blank" class="btn btn-link">
																		<i class="fas fa-file"></i> <?= $ref_attachments[$field] ?>
																	</a>
																	<button type="button" class="btn btn-danger btn-sm"
																		onclick="confirmDeleteSingleReference(<?= $i - 1 ?>)">
																		<i class="fas fa-trash"></i>
																	</button>
																<?php endif; ?>
															</div>
													<?php
														endif;
													endfor;
													?>
												</div>
												<button type="button" class="btn btn-danger"
													onclick="confirmDeleteAllAttachments('references')">
													<i class="fas fa-trash"></i> Delete All Reference Attachments
												</button>
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
																<?php if (in_array(pathinfo($result_attachments[$field], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])): ?>
																	<a href="<?= base_url('uploads/jobsheet/' . $result_attachments[$field]) ?>"
																		target="_blank" class="btn btn-link">
																		<img src="<?= base_url('uploads/jobsheet/' . $result_attachments[$field]) ?>"
																			alt="Attachment" height="50">
																	</a>
																	<button type="button" class="btn btn-danger btn-sm"
																		onclick="confirmDeleteSingleReference(<?= $i - 1 ?>)">
																		<i class="fas fa-trash"></i>
																	</button>
																<?php else: ?>
																	<a href="<?= base_url('uploads/jobsheet/' . $result_attachments[$field]) ?>"
																		target="_blank" class="btn btn-link">
																		<i class="fas fa-file"></i> <?= $result_attachments[$field] ?>
																	</a>
																	<button type="button" class="btn btn-danger btn-sm"
																		onclick="confirmDeleteSingleReference(<?= $i - 1 ?>)">
																		<i class="fas fa-trash"></i>
																	</button>
																<?php endif; ?>
															</div>
													<?php
														endif;
													endfor;
													?>
												</div>
												<button type="button" class="btn btn-danger"
													onclick="confirmDeleteAllAttachments('attach_result')">
													<i class="fas fa-trash"></i> Delete All Result Attachments
												</button>
											</div>
										<?php endif; ?>
									</div>
								</div>
								<input type="hidden" name="id_jobsheet" value="<?= $jobsheet['id_jobsheet'] ?>">
								<input type="hidden" name="references_id" value="<?= $jobsheet['references_id'] ?>">
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
	function initDivisiFilter() {
		const filterSelect = document.getElementById('filter_divisi');
		const karyawanSelect = document.getElementById('id_user');

		function filterKaryawan() {
			const selectedDivisi = filterSelect.value;
			const options = karyawanSelect.getElementsByTagName('option');

			for (let option of options) {
				if (option.value === '') continue;

				const optionDivisi = option.getAttribute('data-divisi');
				if (!selectedDivisi || optionDivisi === selectedDivisi) {
					option.style.display = '';
				} else {
					option.style.display = 'none';
				}
			}
		}

		karyawanSelect.addEventListener('change', function() {
			const selectedOption = this.options[this.selectedIndex];
			if (selectedOption && selectedOption.value) {
				const karyawanDivisi = selectedOption.getAttribute('data-divisi');
				if (karyawanDivisi) {
					filterSelect.value = karyawanDivisi;
					filterKaryawan();
				}
			}
		});

		filterSelect.addEventListener('change', filterKaryawan);

		if (karyawanSelect.value) {
			const selectedOption = karyawanSelect.options[karyawanSelect.selectedIndex];
			const karyawanDivisi = selectedOption.getAttribute('data-divisi');
			if (karyawanDivisi) {
				filterSelect.value = karyawanDivisi;
				filterKaryawan();
			}
		}
	}

	document.addEventListener('DOMContentLoaded', initDivisiFilter);

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

	const inputFields = ['title', 'tasked_at', 'deadline', 'id_user', 'new_attachments', 'revision_note', 'new_deadline'];

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
				document.getElementById('formEditJobsheet').reset();
			}
		})
	};

	function simpanJobsheet(event) {
		event.preventDefault();

		const title = document.getElementById('title').value.trim();
		const tasked_at = document.getElementById('tasked_at').value.trim();
		const deadline = document.getElementById('deadline').value.trim();
		const id_user = document.getElementById('id_user').value.trim();
		const newAttachments = document.getElementById('new_attachments').files;

		if (!title) {
			document.getElementById('title_error').innerText = 'Judul tidak boleh kosong';
			return;
		}

		if (!tasked_at) {
			document.getElementById('tasked_at_error').innerText = 'Tanggal mulai tidak boleh kosong';
			return;
		}

		if (!deadline) {
			document.getElementById('deadline_error').innerText = 'Tanggal deadline tidak boleh kosong';
			return;
		}


		if (new Date(deadline) < new Date(tasked_at)) {
			document.getElementById('deadline_error').innerText = 'Tanggal deadline tidak boleh lebih kecil dari tanggal mulai';
			return;
		}
		if (new Date(tasked_at) > new Date()) {
			document.getElementById('tasked_at_error').innerText = 'Tanggal mulai tidak boleh lebih besar dari tanggal sekarang';
			return;
		}
		if (new Date(deadline) < new Date()) {
			document.getElementById('deadline_error').innerText = 'Tanggal deadline tidak boleh lebih kecil dari tanggal sekarang';
			return;
		}

		if (!id_user) {
			document.getElementById('id_user_error').innerText = 'Karyawan tidak boleh kosong';
			return;
		}

		for (let i = 0; i < newAttachments.length; i++) {
			if (newAttachments[i].name.length > 255) {
				document.getElementById('new_attachments_error').innerText = 'Nama file tidak boleh lebih dari 255 karakter';
				return;
			}
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
				document.getElementById('formEditJobsheet').submit();
			}
		})
	};

	function confirmDeleteSingleReference(fileIndex) {
		Swal.fire({
			title: 'Delete Attachment?',
			text: "This will permanently delete this attachment!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Yes, delete it!',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = '<?= base_url() ?>C_Penilai/deleteAttachment/<?= $jobsheet['id_jobsheet'] ?>/references/' + fileIndex;
			}
		});
	}

	function confirmDeleteSingleResult(fileIndex) {
		Swal.fire({
			title: 'Delete Result Attachment?',
			text: "This will permanently delete this result attachment!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Yes, delete it!',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = '<?= base_url() ?>C_Penilai/deleteAttachment/<?= $jobsheet['id_jobsheet'] ?>/attach_result/' + fileIndex;
			}
		});
	}

	function confirmDeleteAllAttachments(type) {
		Swal.fire({
			title: 'Delete All Attachments?',
			text: "This will permanently delete all " + type + " attachments!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Yes, delete all!',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = '<?= base_url() ?>C_Penilai/deleteAttachment/<?= $jobsheet['id_jobsheet'] ?>/' + type;
			}
		});
	}

	function validateFiles(input) {
		const existingFiles = document.querySelectorAll('.list-group-item');
		const existingFileCount = existingFiles.length;
		const newFileCount = input.files.length;
		const totalFiles = existingFileCount + newFileCount;
		// it needs to be above than maxFiles idk why
		// if it works, it works
		if (totalFiles > 6) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: `You can only upload a maximum of 5 files!`,
			});
			input.value = '';
			return false;
		}
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
