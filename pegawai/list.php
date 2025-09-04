<?php
include '../inc/auth.php';
include '../inc/db.php';
include '../inc/header.php';
include '../inc/navbar.php';
$role = $_SESSION['user']['role'];
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

// Hitung total pegawai
$total_pegawai = mysqli_num_rows($result);
?>

<!-- Header Section -->
<div class="page-header mb-5">
  <div class="d-flex justify-content-between align-items-center">
    <div class="header-content">
      <div class="header-icon">
        <i class="fas fa-users"></i>
      </div>
      <div class="header-text">
        <h1 class="page-title">Data Pegawai</h1>
        <p class="page-subtitle">Kelola informasi dan jadwal kerja pegawai</p>
      </div>
    </div>
    
    <?php if ($role === 'admin'): ?>
      <a href="tambah.php" class="btn btn-primary btn-lg header-action">
        <i class="fas fa-user-plus me-2"></i>
        Tambah Pegawai
      </a>
    <?php endif; ?>
  </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-5">
  <div class="col-md-4 mb-3">
    <div class="card stats-card text-white h-100">
      <div class="card-body position-relative">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3 class="fw-bold mb-0"><?= $total_pegawai ?></h3>
            <p class="mb-0 opacity-75">Total Pegawai</p>
          </div>
          <div class="stats-icon">
            <i class="fas fa-users fa-2x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-4 mb-3">
    <div class="card stats-card success text-white h-100">
      <div class="card-body position-relative">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3 class="fw-bold mb-0"><?= $total_pegawai ?></h3>
            <p class="mb-0 opacity-75">Aktif</p>
          </div>
          <div class="stats-icon">
            <i class="fas fa-user-check fa-2x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-4 mb-3">
    <div class="card stats-card info text-white h-100">
      <div class="card-body position-relative">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3 class="fw-bold mb-0">7</h3>
            <p class="mb-0 opacity-75">Hari Kerja</p>
          </div>
          <div class="stats-icon">
            <i class="fas fa-calendar-week fa-2x"></i>
          </div>
        </div>
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
        Daftar Pegawai
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
      <table class="table table-hover mb-0" id="pegawaiTable">
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
              <i class="fas fa-map-marker-alt text-muted me-1"></i>
              Alamat
            </th>
            <th class="border-0">
              <i class="fas fa-phone text-muted me-1"></i>
              Telepon
            </th>
            <th class="border-0">
              <i class="fas fa-clock text-muted me-1"></i>
              Jadwal Kerja
            </th>
            <?php if ($role === 'admin'): ?>
              <th class="border-0 text-center">
                <i class="fas fa-cogs text-muted me-1"></i>
                Aksi
              </th>
            <?php endif; ?>
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
              <div class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($row['alamat']) ?>">
                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                <?= htmlspecialchars($row['alamat']) ?>
              </div>
            </td>
            <td>
              <a href="tel:<?= htmlspecialchars($row['telepon']) ?>" class="text-decoration-none">
                <i class="fas fa-phone text-success me-1"></i>
                <?= htmlspecialchars($row['telepon']) ?>
              </a>
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
            <?php if ($role === 'admin'): ?>
            <td>
              <div class="d-flex gap-1 justify-content-center">
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" 
                   onclick="return confirm('Yakin ingin menghapus pegawai ini?')" title="Hapus">
                  <i class="fas fa-trash"></i>
                </a>
              </div>
            </td>
            <?php else: ?>
            <td>
              <div class="d-flex justify-content-center">
                <a href="jadwal.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm" title="Lihat Jadwal">
                  <i class="fas fa-eye me-1"></i>
                  Lihat Jadwal
                </a>
              </div>
            </td>
            <?php endif; ?>
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
  const table = document.getElementById('pegawaiTable');
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

<!-- Additional CSS for this page -->
<style>
.bg-gradient-primary {
  background: linear-gradient(135deg, #4f46e5, #3730a3);
}

.bg-gradient-success {
  background: linear-gradient(135deg, #10b981, #059669);
}

.bg-gradient-info {
  background: linear-gradient(135deg, #06b6d4, #0891b2);
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
</style>

<?php include '../inc/footer.php'; ?> 