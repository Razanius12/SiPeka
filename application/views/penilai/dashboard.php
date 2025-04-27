<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Dashboard Penilaian Karyawan</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-6">
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?= $total_karyawan ?></h3>
							<p>Total Karyawan Aktif</p>
						</div>
						<div class="icon">
							<i class="fas fa-users"></i>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?= $completion_rate ?>%</h3>
							<p>Rata-rata Penyelesaian</p>
						</div>
						<div class="icon">
							<i class="fas fa-chart-line"></i>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-warning">
						<div class="inner">
							<h3><?= $total_active_tasks ?></h3>
							<p>Tugas Aktif</p>
						</div>
						<div class="icon">
							<i class="fas fa-tasks"></i>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?= $overdue_tasks ?></h3>
							<p>Tugas Terlambat</p>
						</div>
						<div class="icon">
							<i class="fas fa-clock"></i>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Grafik Kinerja per Divisi</h3>
						</div>
						<div class="card-body">
							<canvas id="performanceChart"></canvas>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Aktivitas Terbaru</h3>
						</div>
						<div class="card-body">
							<div class="timeline timeline-inverse">
								<?php foreach ($recent_activities as $activity): ?>
									<div class="time-label">
										<span class="bg-success"><?= date('d M Y', strtotime($activity['date'])) ?></span>
									</div>
									<div>
										<i class="fas <?= $activity['icon'] ?> bg-primary"></i>
										<div class="timeline-item">
											<span class="time"><i class="far fa-clock"></i> <?= date('H:i', strtotime($activity['date'])) ?></span>
											<h3 class="timeline-header"><?= $activity['title'] ?></h3>
											<div class="timeline-body"><?= $activity['description'] ?></div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<!-- Task Status -->
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Status Tugas per Divisi</h3>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-hover text-nowrap">
								<thead>
									<tr>
										<th>Divisi</th>
										<th>Total Tugas</th>
										<th>Selesai</th>
										<th>Progress</th>
										<th>Pending</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($tasks_by_division as $division): ?>
										<tr>
											<td><?= $division['nama_divisi'] ?></td>
											<td><?= $division['total'] ?></td>
											<td><?= $division['completed'] ?></td>
											<td><?= $division['progress'] ?></td>
											<td><?= $division['pending'] ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Karyawan Terbaik Bulan Ini</h3>
						</div>
						<div class="card-body p-0">
							<ul class="users-list clearfix">
								<?php foreach ($top_performers as $performer): ?>
									<li>
										<span class="users-list-name"><strong><?= $performer['nama'] ?></strong></span>
										<span class="users-list-date"><?= $performer['divisi'] ?></span>
										<span class="badge bg-success"><?= $performer['completion_rate'] ?>% Selesai</span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var ctx = document.getElementById('performanceChart').getContext('2d');

		const labels = <?= json_encode(array_column($performance_data, 'divisi')) ?>;
		const data = <?= json_encode(array_column($performance_data, 'completion_rate')) ?>;

		const hiddenData = labels.map(() => 0);
		const hiddenDataMax = labels.map(() => 100);

		new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
						label: '',
						data: hiddenData,
						backgroundColor: 'rgba(0,0,0,0)',
						borderColor: 'rgba(0,0,0,0)',
						borderWidth: 0,
						barPercentage: 0.0001,
						categoryPercentage: 0.0001,
					},
					{
						label: 'Rata-rata Penyelesaian (%)',
						data: data,
						backgroundColor: 'rgba(60,141,188,0.9)',
						borderColor: 'rgba(60,141,188,0.8)',
						borderWidth: 1,
						// kalo barnya mau lebih lebar gedein aja valuenya
						barPercentage: 1.3,
						categoryPercentage: 1.3,
					},
					{
						label: '',
						data: hiddenDataMax,
						backgroundColor: 'rgba(0,0,0,0)',
						borderColor: 'rgba(0,0,0,0)',
						borderWidth: 0,
						barPercentage: 0.0001,
						categoryPercentage: 0.0001,
					}
				]
			},
			options: {
				responsive: true,
				scales: {
					y: {
						max: 100,
						ticks: {
							stepSize: 20
						}
					}
				},
			}
		});
	});
</script>
