<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Tambah Jobsheet</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Tambah Jobsheet</li>
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
						<form action="<?= base_url() . 'C_Penilai/tambahJobsheet' ?>" method="post"
							id="formTambahJobsheet" enctype="multipart/form-data">
							<div class="card-header">
								<h3 class="card-title">Tambah Data Jobsheet</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="form-group">
									<label for="title">Judul <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="title" id="title" maxlength="255"
										required minlength="1" pattern="\S(.*\S)?">
									<small class="text-danger" id="title_error"></small>
								</div>
								<div class="form-group">
									<label for="description">Deskripsi</label>
									<textarea class="form-control" name="description" id="description"
										rows="3"></textarea>
									<small class="text-danger" id="description_error"></small>
								</div>
								<div class="form-group">
									<label for="tasked_at">Ditugaskan pada Tanggal</label>
									<input type="datetime-local" class="form-control" name="tasked_at" id="tasked_at"
										readonly value="<?= date('Y-m-d H:i:s') ?>" required>
									<small class="text-danger" id="tasked_at_error"></small>
								</div>
								<div class="form-group">
									<label for="deadline">Deadline <span class="text-danger">*</span></label>
									<input type="datetime-local" class="form-control" name="deadline" id="deadline"
										required>
									<small class="text-danger" id="deadline_error"></small>
								</div>
								<div class="card-footer">
									<div class="form-group">
										<label for="filter_divisi">Filter Divisi</label>
										<select class="form-control" name="filter_divisi" id="filter_divisi">
											<option value="">-- Semua Divisi --</option>
											<?php
											$divisi_list = array();
											foreach ($karyawan as $k) {
												if (!in_array($k['id_divisi'], $divisi_list)) {
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
												<option value="<?= $k['id_user'] ?>" data-divisi="<?= $k['id_divisi'] ?>"><?= $k['nama'] ?></option>
											<?php endforeach; ?>
										</select>
										<small class="text-danger" id="id_user_error"></small>
									</div>
								</div>
								<div class="form-group">
									<label for="attachments">Attachments (Max 5 files)</label>
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="attachments"
											name="attachments[]" multiple
											accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip,.rar"
											onchange="validateFiles(this)">
										<label class="custom-file-label" for="attachments">Choose files</label>
									</div>
									<small class="text-muted">Allowed files: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG,
										ZIP, RAR
										(Max 32MB each)</small>
									<div id="fileList" class="mt-2"></div>
								</div>
							</div>
							<div class="card-footer">
								<div class="row">
									<div class="col">
										<button type="button" class="btn btn-danger" onclick="batal()">Batal</button>
										<button type="button" class="btn btn-warning"
											onclick="resetForm()">Reset</button>
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
	// Add/update this function in both formTambahJobsheet.php and formEditJobsheet.php
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

		// Add change event listener for karyawan select
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

		// Set initial divisi filter value if karyawan is already selected
		if (karyawanSelect.value) {
			const selectedOption = karyawanSelect.options[karyawanSelect.selectedIndex];
			const karyawanDivisi = selectedOption.getAttribute('data-divisi');
			if (karyawanDivisi) {
				filterSelect.value = karyawanDivisi;
				filterKaryawan();
			}
		}
	}

	// Initialize when document is ready
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

	const inputFields = ['title', 'tasked_at', 'deadline', 'id_user'];

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
				document.getElementById('formTambahJobsheet').reset();
			}
		})
	};

	function simpan(event) {
		event.preventDefault();

		const title = document.getElementById('title').value.trim();
		const tasked_at = document.getElementById('tasked_at').value.trim();
		const deadline = document.getElementById('deadline').value.trim();
		const id_user = document.getElementById('id_user').value.trim();
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
				document.getElementById('formTambahJobsheet').submit();
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
