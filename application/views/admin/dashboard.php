<div class="content-wrapper">
 <div class="content-header">
  <div class="container-fluid">
   <div class="row mb-2">
    <div class="col-sm-6">
     <h1 class="m-0">Dashboard Admin</h1>
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
       <p>Total Karyawan</p>
      </div>
      <div class="icon">
       <i class="fas fa-users"></i>
      </div>
      <a href="<?= base_url('C_Admin/karyawan') ?>" class="small-box-footer">
       Kelola Karyawan <i class="fas fa-arrow-circle-right"></i>
      </a>
     </div>
    </div>
    <div class="col-lg-3 col-6">
     <div class="small-box bg-success">
      <div class="inner">
       <h3><?= $total_divisi ?></h3>
       <p>Total Divisi</p>
      </div>
      <div class="icon">
       <i class="fas fa-sitemap"></i>
      </div>
      <a href="<?= base_url('C_Admin/divisi') ?>" class="small-box-footer">
       Kelola Divisi <i class="fas fa-arrow-circle-right"></i>
      </a>
     </div>
    </div>
    <div class="col-lg-3 col-6">
     <div class="small-box bg-warning">
      <div class="inner">
       <h3><?= $total_penilai ?></h3>
       <p>Tim Penilai</p>
      </div>
      <div class="icon">
       <i class="fas fa-user-tie"></i>
      </div>
      <a href="<?= base_url('C_Admin/penilai') ?>" class="small-box-footer">
       Kelola Tim Penilai <i class="fas fa-arrow-circle-right"></i>
      </a>
     </div>
    </div>
    <div class="col-lg-3 col-6">
     <div class="small-box bg-danger">
      <div class="inner">
       <h3><?= $total_jobsheet ?></h3>
       <p>Total Jobsheet</p>
      </div>
      <div class="icon">
       <i class="fas fa-tasks"></i>
      </div>
      <a href="<?= base_url('C_Penilai/laporan') ?>" class="small-box-footer">
       Lihat Detail <i class="fas fa-arrow-circle-right"></i>
      </a>
     </div>
    </div>
   </div>

   <div class="row">
    <div class="col-md-12">
     <div class="card">
      <div class="card-header">
       <h3 class="card-title">Distribusi Karyawan per Divisi</h3>
      </div>
      <div class="card-body">
       <canvas id="divisiChart" style="height: 300px;"></canvas>
      </div>
     </div>
    </div>

   </div>

   <div class="row">
    <div class="col-md-12">
     <div class="card">
      <div class="card-header">
       <h3 class="card-title">Ringkasan Data Pengguna</h3>
      </div>
      <div class="card-body table-responsive p-0">
       <table class="table table-hover text-nowrap">
        <thead>
         <tr>
          <th>Divisi</th>
          <th>Jumlah Karyawan</th>
          <th>Total Jobsheet</th>
          <th>Selesai</th>
          <th>Progress</th>
          <th>Rate Penyelesaian</th>
         </tr>
        </thead>
        <tbody>
         <?php foreach ($divisi_summary as $ds): ?>
          <tr>
           <td><?= $ds['nama_divisi'] ?></td>
           <td><?= $ds['jumlah_karyawan'] ?></td>
           <td><?= $ds['total_jobsheet'] ?></td>
           <td><?= $ds['completed_jobsheet'] ?></td>
           <td><?= $ds['ongoing_jobsheet'] ?></td>
           <td>
            <div class="progress">
             <div class="progress-bar bg-success" style="width: <?= $ds['completion_rate'] ?>%">
              <?= $ds['completion_rate'] ?>%
             </div>
            </div>
           </td>
          </tr>
         <?php endforeach; ?>
        </tbody>
       </table>
      </div>
     </div>
    </div>
   </div>
  </div>
 </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
 document.addEventListener('DOMContentLoaded', function () {
  var ctx = document.getElementById('divisiChart').getContext('2d');
  new Chart(ctx, {
   type: 'doughnut',
   data: {
    labels: <?= json_encode(array_column($divisi_data, 'nama_divisi')) ?>,
    datasets: [{
     data: <?= json_encode(array_column($divisi_data, 'jumlah_karyawan')) ?>,
     backgroundColor: [
      'rgba(60,141,188,0.9)',
      'rgba(255,99,132,0.9)',
      'rgba(255,206,86,0.9)',
      'rgba(75,192,192,0.9)',
      'rgba(153,102,255,0.9)',
     ],
     borderWidth: 1
    }]
   },
   options: {
    responsive: true,
    maintainAspectRatio: false
   }
  });
 });
</script>
