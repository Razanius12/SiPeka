<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Data Tim Penilai</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Tim Penilai</li>
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
						<a href="<?= base_url() . 'C_Admin/formTambahTimPenilai' ?>">
							<button type="button" class="btn btn-primary btn-round">
								Tambah Data Tim Penilai
							</button>
						</a>
					</div>
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Tim Penilai</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<?php if (empty($penilai)): ?>
								<div role="alert">
									Data tim penilai masih kosong,
									cobalah klik tambah data tim penilai untuk menambahkan tim penilai
								</div>
							<?php else: ?>
								<table id="penilaiTable" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Username</th>
											<th>Nama Tim Penilai</th>
											<th>No Telepon</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($penilai as $p): ?>
											<tr>
												<td><?= $p['username'] ?></td>
												<td><?= $p['nama'] ?></td>
												<td><?= $p['no_telp'] ?></td>
												<td>
													<a href="<?= base_url() . 'C_Admin/formEditTimPenilai/' . $p['id_user'] ?>"
														class="btn btn-warning btn-sm">
														<i class="fas fa-edit text-light"></i>
													</a>
               <button type="button" class="btn btn-danger btn-sm"
                onclick="hapus(<?= $p['id_user'] ?>)">
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
    window.location.href = "<?= base_url() . 'C_Admin/hapusTimPenilai/' ?>" + id;
   }
  });
 }
	
	document.addEventListener('DOMContentLoaded', function () {
		$(document).ready(function () {
			$('#penilaiTable').DataTable({
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
