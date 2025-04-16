<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Data Karyawan</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Karyawan</li>
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
					<div class="mb-4">
						<a href="<?= base_url() . 'C_Admin/formTambahKaryawan' ?>">
							<button type="button" class="btn btn-primary btn-round">
								Tambah Data Karyawan
							</button>
						</a>
					</div>
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Karyawan</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<?php if (empty($karyawan)): ?>
								<div role="alert">
									Data karyawan masih kosong,
									cobalah klik tambah data karyawan untuk menambahkan karyawan
								</div>
							<?php else: ?>
								<table id="karyawanTable" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Username</th>
											<th>Nama Karyawan</th>
											<th>No Telepon</th>
											<th>Divisi</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($karyawan as $k): ?>
											<tr>
												<td><?= $k['username'] ?></td>
												<td><?= $k['nama'] ?></td>
												<td><?= $k['no_telp'] ?></td>
												<td><?= $k['nama_divisi'] ?></td>
												<td>
													<a href="<?= base_url() . 'C_Admin/formEditKaryawan/' . $k['id_user'] ?>"
														class="btn btn-warning btn-sm">
														<i class="fas fa-edit text-light"></i>
													</a>
               <button type="button" class="btn btn-danger btn-sm"
                onclick="hapus(<?= $k['id_user'] ?>)">
																<i class="fas fa-trash text-light"></i>
															</button>
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

 // handle alert
 // ----------------------------------------

 const urlParams = new URLSearchParams(window.location.search);
 const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
 if (urlParams.get('status') === 'added') {
  Swal.fire({
   icon: 'success',
   title: 'Berhasil',
   text: 'Data berhasil ditambahkan',
  }).then(() => {
   window.history.replaceState({ path: newUrl }, '', newUrl);
  });
 }

 if (urlParams.get('status') === 'updated') {
  Swal.fire({
   icon: 'success',
   title: 'Berhasil',
   text: 'Data berhasil diubah',
  }).then(() => {
   window.history.replaceState({ path: newUrl }, '', newUrl);
  });
 }

 if (urlParams.get('status') === 'deleted') {
  Swal.fire({
   icon: 'success',
   title: 'Berhasil',
   text: 'Data berhasil dihapus',
  }).then(() => {
   window.history.replaceState({ path: newUrl }, '', newUrl);
  });
 }

 function hapus(id) {
  Swal.fire({
   title: 'Apakah Anda Yakin?',
   text: "Data yang dihapus tidak dapat dikembalikan!",
   icon: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Ya, Hapus!',
   cancelButtonText: 'Batal'
  }).then((result) => {
   if (result.isConfirmed) {
    window.location.href = "<?= base_url() . 'C_Admin/hapusKaryawan/' ?>" + id;
   }
  });
 }
	
	document.addEventListener('DOMContentLoaded', function () {
		$(document).ready(function () {
			$('#karyawanTable').DataTable({
				"pageLength": 10,
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
