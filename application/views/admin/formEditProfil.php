<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Edit Profil</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Profil</li>
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
						<form action="<?= base_url() . 'C_Admin/updateProfil' ?>" method="post" id="formEditKaryawan">
							<div class="card-header">
								<h3 class="card-title">Edit Profil</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="form-group">
									<label for="username">Username <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="username" id="username"
										maxlength="255" required minlength="8" pattern="\S(.*\S)?"
										value="<?= $user['username'] ?>">
									<small class="text-danger" id="username_error"></small>
								</div>
								<div class="form-group">
									<label for="password">Password <span class="text-danger">*</span></label>
									<input type="password" class="form-control" name="password" id="password"
										maxlength="255" required minlength="8" pattern="\S(.*\S)?"
										value="<?= $user['password'] ?>">
									<small class="text-danger" id="password_error"></small>
								</div>
								<div class="form-group">
									<label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="nama" id="nama" maxlength="255"
										required minlength="1" pattern="\S(.*\S)?" value="<?= $user['nama'] ?>">
									<small class="text-danger" id="nama_error"></small>
								</div>
								<div class="form-group">
									<label for="no_telp">Nomor Telepon <span class="text-danger">*</span></label>
									<input type="number" class="form-control" name="no_telp" id="no_telp"
										maxlength="255" required minlength="11" pattern="\S(.*\S)?"
										value="<?= $user['no_telp'] ?>">
									<small class=" text-danger" id="no_telp_error"></small>
								</div>
							</div>
							<input type="hidden" name="id_user" id="id_user" value="<?= $user['id_user'] ?>">
							<input type="hidden" name="role" id="role" value="<?= $user['role'] ?>">
							<div class="card-footer">
								<div class="row">
									<div class="col">
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
	
 const urlParams = new URLSearchParams(window.location.search);
 const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;

	if (urlParams.get('status') === 'updated') {
  Swal.fire({
   icon: 'success',
   title: 'Berhasil',
   text: 'Data berhasil diubah',
  }).then(() => {
   window.history.replaceState({ path: newUrl }, '', newUrl);
  });
 }

	const inputFields = ['username', 'password', 'nama_karyawan', 'no_telp'];
	const role =	document.getElementById('role').value;
	var redirecUrl = null;
	if (role === 'Karyawan') {
		redirecUrl = '<?= base_url() . 'C_Karyawan' ?>';
	} else if (role === 'Admin') {
		redirecUrl = '<?= base_url() . 'C_Admin' ?>';
	} else	if (role === 'Tim Penilai') {
		redirecUrl = '<?= base_url() . 'C_Penilai' ?>';
	} else if (role === 'KepSek') {
		redirecUrl = '<?= base_url() . 'C_KepSek' ?>';
	} else {
		redirecUrl = '<?= base_url() . 'C_Auth/Logout' ?>';
	}

	inputFields.forEach(fieldId => {
		document.getElementById(fieldId).addEventListener('input', function () {
			document.getElementById(`${fieldId}_error`).innerText = '';
		});
	});

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
				document.getElementById('formEditKaryawan').reset();
			}
		})
	};

	// -------------------------------------------------------------------
	// simpan
	function simpan(event) {
		event.preventDefault();

		const username = document.getElementById('username').value.trim();
		const password = document.getElementById('password').value.trim();
		const nama = document.getElementById('nama').value.trim();
		const no_telp = document.getElementById('no_telp').value.trim();

		if (!username) {
			document.getElementById('username_error').innerText = 'Username tidak boleh kosong';
			return;
		}
		if (username.length < 8) {
			document.getElementById('username_error').innerText = 'Username minimal 8 karakter';
			return;
		}

		if (!password) {
			document.getElementById('password_error').innerText = 'Password tidak boleh kosong';
			return;
		}
		if (password.length < 8) {
			document.getElementById('password_error').innerText = 'Password minimal 8 karakter';
			return;
		}

		if (!nama) {
			document.getElementById('nama_error').innerText = 'Nama karyawan tidak boleh kosong';
			return;
		}

		if (!no_telp) {
			document.getElementById('no_telp_error').innerText = 'Nomor telepon tidak boleh kosong';
			return;
		}
		if (no_telp.length < 11) {
			document.getElementById('no_telp_error').innerText = 'Nomor telepon minimal 11 digit';
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
				document.getElementById('formEditKaryawan').submit();
			}
		})
	};

</script>
