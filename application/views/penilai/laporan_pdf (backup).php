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
				<th>Selesai</th>\
				<th>% Tepat Waktu</th>
				<th>Nilai Jobsheet</th>
				<th>Nilai Revisi</th>
				<th>Total Nilai</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_nilai_keseluruhan = 0;
			$total_karyawan_dengan_nilai = 0;
			foreach ($kinerja as $k):
				$rata_nilai = $k['tugas_selesai'] > 0 ? round($k['total_nilai'] / $k['tugas_selesai'], 2) : 0;
				if ($k['tugas_selesai'] > 0) {
					$total_nilai_keseluruhan += $rata_nilai;
					$total_karyawan_dengan_nilai++;
				}
			?>
				<tr>
					<td><?= $k['nama'] ?></td>
					<td><?= $k['nama_divisi'] ?></td>
					<td><?= $k['total_tugas'] ?></td>
					<td><?= $k['tugas_selesai'] ?></td>
					<td><?= $k['total_tugas'] > 0 ? round(($k['tepat_waktu'] / $k['total_tugas']) * 100) : 0 ?>%</td>
					<td><?= $k['tugas_selesai'] > 0 ? $rata_nilai : 'N/A' ?></td>
					<td><?= $k['tugas_selesai'] > 0 ? round($k['total_revision_score'] / $k['tugas_selesai'], 2) : 'N/A' ?></td>
					<td>
						<?php
						$total_nilai = 0;
						if ($k['tugas_selesai'] > 0) {
							$total_nilai = ($rata_nilai + round($k['total_revision_score'] / $k['tugas_selesai'], 2)) / 2;
						}
						echo $total_nilai > 0 ? round($total_nilai, 2) : 'N/A';
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="5" style="text-align: right;"><strong>Rata-rata Nilai Keseluruhan:</strong></td>
				<td>
					<?= $total_karyawan_dengan_nilai > 0 ?
						round($total_nilai_keseluruhan / $total_karyawan_dengan_nilai, 2) :
						'N/A' ?>
				</td>
				<td>
					<?php
					$total_revision_score = 0;
					foreach ($kinerja as $k) {
						if ($k['tugas_selesai'] > 0) {
							$total_revision_score += round($k['total_revision_score'] / $k['tugas_selesai'], 2);
						}
					}
					echo $total_karyawan_dengan_nilai > 0 ?
						round($total_revision_score / $total_karyawan_dengan_nilai, 2) :
						'N/A';
					?>
				</td>
				<td>
					<?php
					$total_nilai = 0;
					if ($total_karyawan_dengan_nilai > 0) {
						$total_nilai = ($total_nilai_keseluruhan + $total_revision_score) / (2 * $total_karyawan_dengan_nilai);
					}
					echo $total_nilai > 0 ? round($total_nilai, 2) : 'N/A';
					?>
				</td>
			</tr>
		</tfoot>
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
				<th>Nilai</th>
				<th>Nilai Revisi</th>
				<th>Total Nilai</th>
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
					<td><?= $t['status'] == 'COMPLETED' ? $t['nilai'] : '-' ?></td>
					<td><?= $t['status'] == 'COMPLETED' ? (100 - ($t['current_revision'] * 10)) : '-' ?></td>
					<td><?= $t['status'] == 'COMPLETED' ? ($t['nilai'] + (100 - ($t['current_revision'] * 10))) / 2 : '-' ?></td>
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
