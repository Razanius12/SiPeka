<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Edit Divisi</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Divisi</li>
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
						<form action="<?= base_url() . 'C_Admin/updateDivisi' ?>" method="post" id="formEditDivisi">
							<div class="card-header">
								<h3 class="card-title">Edit Data Divisi</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="form-group">
									<label for="nama_divisi">Nama Divisi <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="nama_divisi" id="nama_divisi"
										maxlength="255" required minlength="1" pattern="\S(.*\S)?"
										oninvalid="this.setCustomValidity('Nama divisi tidak boleh kosong')"
										oninput="this.setCustomValidity('')" value="<?= $divisi['nama_divisi'] ?>">
									<small class="text-danger" id="nama_divisi_error"></small>
								</div>
							</div>
							<input type="hidden" name="id_divisi" id="id_divisi" value="<?= $divisi['id_divisi'] ?>">
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

	document.getElementById('nama_divisi').addEventListener('input', function () {
		document.getElementById('nama_divisi_error').innerText = '';
	});

	// -------------------------------------------------------------------
	// batal
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
				document.location.href = '<?= base_url() . 'C_Admin/divisi' ?>';
			}
		})
	};

	// -------------------------------------------------------------------
	// resetForm
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
				document.getElementById('formEditDivisi').reset();
			}
		})
	};

	// -------------------------------------------------------------------
	// simpan
	function simpan(event) {
		event.preventDefault();

		const nama_divisi = document.getElementById('nama_divisi').value.trim();
		if (!nama_divisi) {
			document.getElementById('nama_divisi_error').innerText = 'Nama divisi tidak boleh kosong';
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
				document.getElementById('formEditDivisi').submit();
			}
		})
	};

</script>
