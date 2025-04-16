<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Laporan Penilaian Karyawan</title>
	<style>
		body {
			font-family: Arial, sans-serif;
		}

		.header {
			text-align: center;
			margin-bottom: 20px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 15px;
		}

		th,
		td {
			border: 1px solid #ddd;
			padding: 8px;
			text-align: left;
		}

		th {
			background-color: #f2f2f2;
		}

		.summary {
			margin-top: 20px;
		}

		.footer {
			margin-top: 30px;
			text-align: right;
		}

		.subtitle {
			font-style: italic;
			color: #666;
		}
	</style>
</head>

<body>
	<div class="header">
		<h2>Laporan Penilaian Karyawan</h2>
		<p class="subtitle">
			<?php
			$bulan = [
				'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			];

			if ($jenis_laporan == 'bulanan') {
				echo "Periode: " . $bulan[$periode - 1] . " " . $tahun;
			} else if ($jenis_laporan == 'semester') {
				echo "Periode: Semester " . $periode . " Tahun " . $tahun;
			} else {
				echo "Periode: Tahun " . $tahun;
			}

			if ($divisi_name) {
				echo " - Divisi: " . $divisi_name;
			}
			?>
		</p>
	</div>

	<h3>A. Ringkasan Kinerja Karyawan</h3>
	<table>
		<thead>
			<tr>
				<th>Nama Karyawan</th>
				<th>Divisi</th>
				<th>Total Tugas</th>
				<th>Selesai</th>
				<th>Pending</th>
				<th>Progress</th>
				<th>% Tepat Waktu</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($kinerja as $k): ?>
				<tr>
					<td><?= $k['nama'] ?></td>
					<td><?= $k['nama_divisi'] ?></td>
					<td><?= $k['total_tugas'] ?></td>
					<td><?= $k['tugas_selesai'] ?></td>
					<td><?= $k['tugas_pending'] ?></td>
					<td><?= $k['tugas_progress'] ?></td>
					<td><?= $k['total_tugas'] > 0 ? round(($k['tepat_waktu'] / $k['total_tugas']) * 100) : 0 ?>%</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<h3>B. Detail Tugas</h3>
	<table>
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Judul Tugas</th>
				<th>Karyawan</th>
				<th>Status</th>
				<th>Deadline</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($detail_tugas as $t): ?>
				<tr>
					<td><?= date('d/m/Y', strtotime($t['tasked_at'])) ?></td>
					<td><?= $t['title'] ?></td>
					<td><?= $t['nama'] ?></td>
					<td><?= $t['status'] ?></td>
					<td><?= date('d/m/Y', strtotime($t['deadline'])) ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="footer">
		<p>Dicetak pada: <?= date('d/m/Y H:i:s') ?></p>
		<!-- <p>Mengetahui,</p>
		<br><br><br>
		<p>(_________________)</p>
		<p>Kepala Departemen</p> -->
	</div>
</body>

</html>
