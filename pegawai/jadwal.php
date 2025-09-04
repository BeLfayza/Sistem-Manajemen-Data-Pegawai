<?php
include '../inc/auth.php';
include '../inc/db.php';
include '../inc/header.php';
include '../inc/navbar.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
  // Tampilkan jadwal pegawai tertentu
  $pegawai = mysqli_query($conn, "SELECT * FROM pegawai WHERE id=$id");
  $data_pegawai = mysqli_fetch_assoc($pegawai);
  
  if (!$data_pegawai) {
    header('Location: list.php'); exit;
  }
  
  $jadwal_result = mysqli_query($conn, "
    SELECT * FROM jadwal_kerja 
    WHERE pegawai_id=$id 
    ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')
  ");
  
  $jadwal_data = [];
  while ($jadwal = mysqli_fetch_assoc($jadwal_result)) {
    $jadwal_data[$jadwal['hari']] = $jadwal;
  }
  
  $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
} else {
  // Tampilkan semua jadwal kerja
  $result = mysqli_query($conn, "
    SELECT p.*, 
           GROUP_CONCAT(
             CONCAT(j.hari, ' (', TIME_FORMAT(j.jam_masuk, '%H:%i'), '-', TIME_FORMAT(j.jam_keluar, '%H:%i'), ' ', j.shift, ')')
             ORDER BY FIELD(j.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')
             SEPARATOR '<br>'
           ) as jadwal_kerja
    FROM pegawai p 
    LEFT JOIN jadwal_kerja j ON p.id = j.pegawai_id 
    GROUP BY p.id
  ");
}
?>

<?php if ($id > 0): ?>
  <!-- Detail jadwal pegawai tertentu -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold text-dark mb-1">
        <i class="fas fa-calendar-alt text-info me-2"></i>
        Jadwal Kerja: <?= htmlspecialchars($data_pegawai['nama']) ?>
      </h2>
      <p class="text-muted mb-0">Detail jadwal kerja mingguan pegawai</p>
    </div>
    <a href="list.php" class="btn btn-secondary">
      <i class="fas fa-arrow-left me-2"></i>
      Kembali ke Daftar
    </a>
  </div>
  
  <div class="row">
    <!-- Informasi Pegawai Card -->
    <div class="col-lg-4 mb-4">
      <div class="card shadow-lg h-100">
        <div class="card-header bg-gradient-primary text-white">
          <h5 class="mb-0">
            <i class="fas fa-user me-2"></i>
            Informasi Pegawai
          </h5>
        </div>
        <div class="card-body">
          <div class="text-center mb-4">
            <div class="avatar-lg bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
              <i class="fas fa-user fa-2x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-1"><?= htmlspecialchars($data_pegawai['nama']) ?></h5>
            <span class="badge bg-primary"><?= htmlspecialchars($data_pegawai['jabatan']) ?></span>
          </div>
          
          <div class="info-item mb-3">
            <div class="d-flex align-items-center mb-2">
              <i class="fas fa-id-card text-primary me-2"></i>
              <span class="fw-semibold">NIP:</span>
            </div>
            <p class="mb-0 text-muted"><?= htmlspecialchars($data_pegawai['nip']) ?></p>
          </div>
          
          <div class="info-item mb-3">
            <div class="d-flex align-items-center mb-2">
              <i class="fas fa-map-marker-alt text-primary me-2"></i>
              <span class="fw-semibold">Alamat:</span>
            </div>
            <p class="mb-0 text-muted"><?= htmlspecialchars($data_pegawai['alamat']) ?></p>
          </div>
          
          <div class="info-item">
            <div class="d-flex align-items-center mb-2">
              <i class="fas fa-phone text-primary me-2"></i>
              <span class="fw-semibold">Telepon:</span>
            </div>
            <a href="tel:<?= htmlspecialchars($data_pegawai['telepon']) ?>" class="text-decoration-none">
              <?= htmlspecialchars($data_pegawai['telepon']) ?>
            </a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Jadwal Kerja Card -->
    <div class="col-lg-8 mb-4">
      <div class="card shadow-lg h-100">
        <div class="card-header bg-gradient-info text-white">
          <h5 class="mb-0">
            <i class="fas fa-calendar-week me-2"></i>
            Jadwal Kerja Mingguan
          </h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-borderless mb-0">
              <thead>
                <tr class="border-bottom">
                  <th class="text-center">
                    <i class="fas fa-calendar-day text-muted me-1"></i>
                    Hari
                  </th>
                  <th class="text-center">
                    <i class="fas fa-clock text-success me-1"></i>
                    Jam Masuk
                  </th>
                  <th class="text-center">
                    <i class="fas fa-clock text-danger me-1"></i>
                    Jam Keluar
                  </th>
                  <th class="text-center">
                    <i class="fas fa-moon text-warning me-1"></i>
                    Shift
                  </th>
                  <th class="text-center">
                    <i class="fas fa-hourglass-half text-info me-1"></i>
                    Durasi
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($hari_list as $hari): ?>
                  <?php $jadwal = isset($jadwal_data[$hari]) ? $jadwal_data[$hari] : null; ?>
                  <tr class="jadwal-row <?= $jadwal ? 'table-success' : 'table-light' ?>">
                    <td class="text-center">
                      <div class="d-flex align-items-center justify-content-center">
                        <div class="day-icon me-2">
                          <i class="fas fa-calendar-day fa-lg text-primary"></i>
                        </div>
                        <span class="fw-bold"><?= $hari ?></span>
                      </div>
                    </td>
                    <?php if ($jadwal): ?>
                      <td class="text-center">
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">
                          <i class="fas fa-clock me-1"></i>
                          <?= date('H:i', strtotime($jadwal['jam_masuk'])) ?>
                        </span>
                      </td>
                      <td class="text-center">
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2">
                          <i class="fas fa-clock me-1"></i>
                          <?= date('H:i', strtotime($jadwal['jam_keluar'])) ?>
                        </span>
                      </td>
                      <td class="text-center">
                        <?php
                        $shift_colors = [
                          'Pagi' => 'bg-primary',
                          'Siang' => 'bg-warning',
                          'Malam' => 'bg-dark'
                        ];
                        $shift_color = $shift_colors[$jadwal['shift']] ?? 'bg-secondary';
                        ?>
                        <span class="badge <?= $shift_color ?> px-3 py-2">
                          <i class="fas fa-moon me-1"></i>
                          <?= $jadwal['shift'] ?>
                        </span>
                      </td>
                      <td class="text-center">
                        <?php
                        $masuk = strtotime($jadwal['jam_masuk']);
                        $keluar = strtotime($jadwal['jam_keluar']);
                        $durasi = $keluar - $masuk;
                        $jam = floor($durasi / 3600);
                        $menit = floor(($durasi % 3600) / 60);
                        ?>
                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2">
                          <i class="fas fa-hourglass-half me-1"></i>
                          <?= $jam ?>j <?= $menit ?>m
                        </span>
                      </td>
                    <?php else: ?>
                      <td colspan="4" class="text-center">
                        <div class="text-muted py-3">
                          <i class="fas fa-umbrella-beach fa-2x mb-2"></i>
                          <br>
                          <span class="fw-semibold">Libur</span>
                        </div>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          
          <!-- Summary Card -->
          <div class="mt-4 p-3 bg-light rounded">
            <div class="row text-center">
              <div class="col-4">
                <div class="summary-item">
                  <h4 class="text-primary mb-1"><?= count($jadwal_data) ?></h4>
                  <small class="text-muted">Hari Kerja</small>
                </div>
              </div>
              <div class="col-4">
                <div class="summary-item">
                  <h4 class="text-success mb-1">
                    <?php
                    $total_hours = 0;
                    foreach ($jadwal_data as $jadwal) {
                      $masuk = strtotime($jadwal['jam_masuk']);
                      $keluar = strtotime($jadwal['jam_keluar']);
                      $total_hours += ($keluar - $masuk) / 3600;
                    }
                    echo round($total_hours, 1);
                    ?>
                  </h4>
                  <small class="text-muted">Total Jam</small>
                </div>
              </div>
              <div class="col-4">
                <div class="summary-item">
                  <h4 class="text-info mb-1"><?= count(array_unique(array_column($jadwal_data, 'shift'))) ?></h4>
                  <small class="text-muted">Jenis Shift</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
<?php else: ?>
  <!-- Daftar semua jadwal kerja -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold text-dark mb-1">
        <i class="fas fa-calendar-alt text-info me-2"></i>
        Daftar Jadwal Kerja Pegawai
      </h2>
      <p class="text-muted mb-0">Overview jadwal kerja seluruh pegawai</p>
    </div>
    <a href="list.php" class="btn btn-secondary">
      <i class="fas fa-arrow-left me-2"></i>
      Kembali ke Daftar Pegawai
    </a>
  </div>
  
  <!-- Statistics Cards -->
  <div class="row mb-4">
    <div class="col-md-3 mb-3">
      <div class="card bg-gradient-primary text-white h-100">
        <div class="card-body text-center">
          <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
            <i class="fas fa-users fa-2x"></i>
          </div>
          <h4 class="fw-bold mb-1"><?= mysqli_num_rows($result) ?></h4>
          <p class="mb-0 opacity-75">Total Pegawai</p>
        </div>
      </div>
    </div>
    
    <div class="col-md-3 mb-3">
      <div class="card bg-gradient-success text-white h-100">
        <div class="card-body text-center">
          <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
            <i class="fas fa-calendar-check fa-2x"></i>
          </div>
          <h4 class="fw-bold mb-1">7</h4>
          <p class="mb-0 opacity-75">Hari Kerja</p>
        </div>
      </div>
    </div>
    
    <div class="col-md-3 mb-3">
      <div class="card bg-gradient-warning text-white h-100">
        <div class="card-body text-center">
          <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
            <i class="fas fa-clock fa-2x"></i>
          </div>
          <h4 class="fw-bold mb-1">3</h4>
          <p class="mb-0 opacity-75">Shift Tersedia</p>
        </div>
      </div>
    </div>
    
    <div class="col-md-3 mb-3">
      <div class="card bg-gradient-info text-white h-100">
        <div class="card-body text-center">
          <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
            <i class="fas fa-chart-line fa-2x"></i>
          </div>
          <h4 class="fw-bold mb-1">100%</h4>
          <p class="mb-0 opacity-75">Coverage</p>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Main Table Card -->
  <div class="card shadow-lg">
    <div class="card-header bg-white border-0 py-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-dark">
          <i class="fas fa-table text-primary me-2"></i>
          Daftar Jadwal Kerja
        </h5>
        <div class="d-flex gap-2">
          <div class="input-group" style="width: 250px;">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Cari pegawai...">
          </div>
        </div>
      </div>
    </div>
    
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0" id="jadwalTable">
          <thead>
            <tr>
              <th class="border-0">
                <i class="fas fa-hashtag text-muted me-1"></i>
                No
              </th>
              <th class="border-0">
                <i class="fas fa-user text-muted me-1"></i>
                Nama
              </th>
              <th class="border-0">
                <i class="fas fa-id-card text-muted me-1"></i>
                NIP
              </th>
              <th class="border-0">
                <i class="fas fa-briefcase text-muted me-1"></i>
                Jabatan
              </th>
              <th class="border-0">
                <i class="fas fa-clock text-muted me-1"></i>
                Jadwal Kerja
              </th>
              <th class="border-0 text-center">
                <i class="fas fa-cogs text-muted me-1"></i>
                Aksi
              </th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
            <tr class="align-middle">
              <td>
                <span class="badge bg-light text-dark rounded-pill"><?= $no++ ?></span>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                    <i class="fas fa-user text-primary"></i>
                  </div>
                  <div>
                    <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($row['nama']) ?></h6>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">
                  <?= htmlspecialchars($row['nip']) ?>
                </span>
              </td>
              <td>
                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                  <?= htmlspecialchars($row['jabatan']) ?>
                </span>
              </td>
              <td>
                <div class="jadwal-kerja-cell">
                  <?php if ($row['jadwal_kerja']): ?>
                    <div class="text-success">
                      <i class="fas fa-check-circle me-1"></i>
                      <small><?= $row['jadwal_kerja'] ?></small>
                    </div>
                  <?php else: ?>
                    <div class="text-muted">
                      <i class="fas fa-times-circle me-1"></i>
                      <em>Tidak ada jadwal</em>
                    </div>
                  <?php endif; ?>
                </div>
              </td>
              <td>
                <div class="d-flex justify-content-center">
                  <a href="jadwal.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm" title="Detail Jadwal">
                    <i class="fas fa-eye me-1"></i>
                    Detail Jadwal
                  </a>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <!-- Search Functionality -->
  <script>
  document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.getElementById('jadwalTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
      const row = rows[i];
      const text = row.textContent.toLowerCase();
      
      if (text.includes(searchTerm)) {
        row.style.display = '';
        row.style.animation = 'fadeIn 0.3s ease-in';
      } else {
        row.style.display = 'none';
      }
    }
  });
  </script>
<?php endif; ?>

<!-- Additional CSS -->
<style>
.bg-gradient-primary {
  background: linear-gradient(135deg, #4f46e5, #3730a3);
}

.bg-gradient-info {
  background: linear-gradient(135deg, #06b6d4, #0891b2);
}

.bg-gradient-success {
  background: linear-gradient(135deg, #10b981, #059669);
}

.bg-gradient-warning {
  background: linear-gradient(135deg, #f59e0b, #d97706);
}

.avatar-lg {
  width: 80px;
  height: 80px;
}

.avatar-sm {
  width: 40px;
  height: 40px;
}

.jadwal-kerja-cell {
  max-width: 300px;
}

.jadwal-kerja-cell small {
  font-size: 0.8rem;
  line-height: 1.4;
}

.jadwal-row {
  transition: all 0.3s ease;
}

.jadwal-row:hover {
  transform: scale(1.02);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.day-icon {
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.summary-item h4 {
  font-size: 1.5rem;
}

.info-item {
  padding: 0.75rem;
  border-radius: 8px;
  background: rgba(79, 70, 229, 0.05);
}

.table tbody tr {
  transition: all 0.2s ease;
}

.table tbody tr:hover {
  background: rgba(79, 70, 229, 0.05);
  transform: scale(1.01);
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.badge {
  font-size: 0.75rem;
  font-weight: 500;
}
</style>

<?php include '../inc/footer.php'; ?>
