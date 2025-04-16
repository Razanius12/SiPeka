<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Data Jobsheet On Progress</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Jobsheet On Progress</li>
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
						<a href="<?= base_url() . 'C_Penilai/formTambahJobsheet?from=onprogress' ?>">
							<button type="button" class="btn btn-primary btn-round">
								Tambah Data Jobsheet
							</button>
						</a>
					</div>
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Jobsheet On Progress</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<?php if (empty($jobsheet)): ?>
								<div role="alert">
									Data jobsheet on progress masih kosong,
									tunggulah karyawan	yang anda tugaskan untuk mengerjakan tugasnya
								</div>
							<?php else: ?>
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Judul</th>
											<th>Tanggal Mulai</th>
											<th>Deadline</th>
											<th>Hari Tersisa</th>
											<th>Dikerjakan Oleh</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($jobsheet as $j): ?>
											<tr>
												<td><?= $j['title'] ?></td>
												<td><?= $j['tasked_at'] ?></td>
												<td><?= $j['deadline'] ?></td>
												<td>
													<?php if ($j['days_left'] <= 0): ?>
														<span class="badge badge-danger"><?= $j['days_left'] ?> Hari</span>
													<?php elseif ($j['days_left'] <= 2): ?>
														<span class="badge badge-warning"><?= $j['days_left'] ?> Hari</span>
													<?php else: ?>
														<span class="badge badge-success"><?= $j['days_left'] ?> Hari</span>
													<?php endif; ?>
												</td>
												<td><?= $j['nama'] ?></td>
												<td>
													<a href="<?= base_url() . 'C_Penilai/formEditJobsheet/' . $j['id_jobsheet'] ?>?from=onprogress"
														class="btn btn-warning btn-sm">
														<i class="fas fa-edit text-light"></i>
													</a>
               <button type="button" class="btn btn-danger btn-sm"
                onclick="hapus(<?= $j['id_jobsheet'] ?>)">
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
    window.location.href = "<?= base_url() . 'C_Penilai/hapusJobsheet/' ?>" + id + '?from=onprogress';
   }
  });
 }
</script>
