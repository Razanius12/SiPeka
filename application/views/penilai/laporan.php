<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Generate Laporan Penilaian</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Generate Laporan</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<form action="<?= base_url('C_Penilai/generateLaporan') ?>" method="post">
							<div class="card-header">
								<h3 class="card-title">Generate Laporan Penilaian</h3>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label for="jenis_laporan">Jenis Laporan</label>
									<select class="form-control" id="jenis_laporan" name="jenis_laporan" required>
										<option value="bulanan">Laporan Bulanan</option>
										<option value="semester">Laporan Semester</option>
										<option value="tahunan">Laporan Tahunan</option>
									</select>
								</div>

								<div class="form-group" id="bulan-group">
									<label for="bulan">Bulan</label>
									<select class="form-control" id="bulan" name="bulan">
										<option value="1">Januari</option>
										<option value="2">Februari</option>
										<option value="3">Maret</option>
										<option value="4">April</option>
										<option value="5">Mei</option>
										<option value="6">Juni</option>
										<option value="7">Juli</option>
										<option value="8">Agustus</option>
										<option value="9">September</option>
										<option value="10">Oktober</option>
										<option value="11">November</option>
										<option value="12">Desember</option>
									</select>
								</div>

								<div class="form-group" id="semester-group" style="display:none;">
									<label for="semester">Semester</label>
									<select class="form-control" id="semester" name="semester">
										<option value="1">Semester 1 (Januari-Juni)</option>
										<option value="2">Semester 2 (Juli-Desember)</option>
									</select>
								</div>

								<div class="form-group">
									<label for="tahun">Tahun</label>
									<select class="form-control" id="tahun" name="tahun" required>
										<?php
										$currentYear = date('Y');
										for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
											echo "<option value='$i'>$i</option>";
										}
										?>
									</select>
								</div>

								<div class="form-group">
									<label for="divisi">Divisi (Opsional)</label>
									<select class="form-control" id="divisi" name="divisi">
										<option value="">Semua Divisi</option>
										<?php foreach ($divisi as $d): ?>
											<option value="<?= $d['id_divisi'] ?>"><?= $d['nama_divisi'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="card-footer">
								<div class="row">
									<div class="col text-right">
										<button type="submit" class="btn btn-primary">Generate Laporan</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>

	document.getElementById('jenis_laporan').addEventListener('change', function () {
		var jenis = this.value;
		if (jenis == 'bulanan') {
			document.getElementById('bulan-group').style.display = 'block';
			document.getElementById('semester-group').style.display = 'none';
		} else if (jenis == 'semester') {
			document.getElementById('bulan-group').style.display = 'none';
			document.getElementById('semester-group').style.display = 'block';
		} else {
			document.getElementById('bulan-group').style.display = 'none';
			document.getElementById('semester-group').style.display = 'none';
		}
	});

</script>
