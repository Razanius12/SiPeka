<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Data Divisi</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Divisi</li>
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
						<a href="<?= base_url() . 'C_Admin/formTambahDivisi' ?>">
							<button type="button" class="btn btn-primary btn-round">
								Tambah Data Divisi
							</button>
						</a>
					</div>
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Divisi</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<?php if (empty($divisi)): ?>
								<div role="alert">
									Data divisi masih kosong,
									cobalah klik tambah data divisi untuk menambahkan divisi
								</div>
							<?php else: ?>
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>ID Divisi</th>
											<th>Nama Divisi</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($divisi as $d): ?>
											<tr>
												<td><?= $d['id_divisi'] ?></td>
												<td><?= $d['nama_divisi'] ?></td>
												<td>
													<a href="<?= base_url() . 'C_Admin/formEditDivisi/' . $d['id_divisi'] ?>"
														class="btn btn-warning btn-sm">
														<i class="fas fa-edit text-light"></i>
													</a>
               <button type="button" class="btn btn-danger btn-sm"
                onclick="hapus(<?= $d['id_divisi'] ?>)">
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
    window.location.href = "<?= base_url() . 'C_Admin/hapusDivisi/' ?>" + id;
   }
  });
 }
</script>
