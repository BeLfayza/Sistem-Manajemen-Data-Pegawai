<?php
include '../inc/auth.php';
include '../inc/db.php';
include '../inc/header.php';
include '../inc/navbar.php';
$role = $_SESSION['user']['role'];
$pegawai_id = isset($_SESSION['user']['pegawai_id']) ? $_SESSION['user']['pegawai_id'] : null;

// Get search parameter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Filter data berdasarkan role
if ($role === 'admin') {
  // Admin melihat semua data
  $search_condition = !empty($search) ? "WHERE p.nama LIKE '%$search%'" : '';
$result = mysqli_query($conn, "
  SELECT p.*, 
         GROUP_CONCAT(
           CONCAT(j.hari, ' (', TIME_FORMAT(j.jam_masuk, '%H:%i'), '-', TIME_FORMAT(j.jam_keluar, '%H:%i'), ' ', j.shift, ')')
           ORDER BY FIELD(j.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')
           SEPARATOR '<br>'
         ) as jadwal_kerja
  FROM pegawai p 
  LEFT JOIN jadwal_kerja j ON p.id = j.pegawai_id 
  $search_condition
  GROUP BY p.id
");
} else {
  // User biasa hanya melihat data pribadi
  if ($pegawai_id) {
    $result = mysqli_query($conn, "
      SELECT p.*, 
             GROUP_CONCAT(
               CONCAT(j.hari, ' (', TIME_FORMAT(j.jam_masuk, '%H:%i'), '-', TIME_FORMAT(j.jam_keluar, '%H:%i'), ' ', j.shift, ')')
               ORDER BY FIELD(j.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')
               SEPARATOR '<br>'
             ) as jadwal_kerja
      FROM pegawai p 
      LEFT JOIN jadwal_kerja j ON p.id = j.pegawai_id 
      WHERE p.id = $pegawai_id
      GROUP BY p.id
    ");
  } else {
    // Jika tidak ada pegawai_id, tampilkan kosong
    $result = mysqli_query($conn, "SELECT NULL as id WHERE 1=0");
  }
}

// Hitung total pegawai
$total_pegawai = mysqli_num_rows($result);
$data_pegawai = null;
if ($role !== 'admin' && $total_pegawai > 0) {
  mysqli_data_seek($result, 0);
  $data_pegawai = mysqli_fetch_assoc($result);
  mysqli_data_seek($result, 0);
}
?>

<?php if ($role === 'admin'): ?>
<!-- UI ADMIN -->
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
    
    <a href="tambah.php" class="btn btn-primary btn-lg header-action">
      <i class="fas fa-user-plus me-2"></i>
      Tambah Pegawai
    </a>
  </div>
</div>

<!-- Statistics Cards (Admin Only) -->
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
<?php else: ?>
<!-- UI USER BIASA - PROFILE CARD -->
<div class="container-fluid px-3 px-md-4 py-4">
  <?php if ($data_pegawai): ?>
    <!-- Profile Header Card -->
    <div class="card profile-header-card shadow-lg mb-4">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-12 col-md-auto text-center text-md-start mb-3 mb-md-0">
            <div class="profile-avatar-wrapper">
              <div class="profile-avatar">
                <i class="fas fa-user"></i>
              </div>
              <div class="profile-status-badge">
                <i class="fas fa-circle"></i>
              </div>
            </div>
          </div>
          <div class="col-12 col-md">
            <h2 class="profile-name mb-2"><?= htmlspecialchars($data_pegawai['nama']) ?></h2>
            <div class="profile-badges mb-3">
              <span class="badge profile-badge-primary">
                <i class="fas fa-briefcase me-1"></i>
                <?= htmlspecialchars($data_pegawai['jabatan']) ?>
              </span>
              <span class="badge profile-badge-secondary">
                <i class="fas fa-id-card me-1"></i>
                <?= htmlspecialchars($data_pegawai['nip']) ?>
              </span>
            </div>
            <div class="profile-actions">
              <a href="jadwal.php?id=<?= $data_pegawai['id'] ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-calendar-alt me-1"></i>
                Lihat Jadwal Kerja
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Info Cards Grid -->
    <div class="row g-3 mb-4">
      <!-- Personal Info Card -->
      <div class="col-12 col-md-6">
        <div class="card info-card h-100">
          <div class="card-header info-card-header">
            <h5 class="mb-0">
              <i class="fas fa-user-circle me-2"></i>
              Informasi Pribadi
            </h5>
          </div>
          <div class="card-body">
            <div class="info-item">
              <div class="info-label">
                <i class="fas fa-id-card text-primary"></i>
                <span>NIP</span>
              </div>
              <div class="info-value"><?= htmlspecialchars($data_pegawai['nip']) ?></div>
            </div>
            <div class="info-item">
              <div class="info-label">
                <i class="fas fa-birthday-cake text-primary"></i>
                <span>Tanggal Lahir</span>
              </div>
              <div class="info-value">
                <?php if (!empty($data_pegawai['tanggal_lahir'])): ?>
                  <?php 
                  $tgl_lahir = new DateTime($data_pegawai['tanggal_lahir']);
                  echo $tgl_lahir->format('d F Y');
                  ?>
                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif; ?>
              </div>
            </div>
            <div class="info-item">
              <div class="info-label">
                <i class="fas fa-briefcase text-primary"></i>
                <span>Jabatan</span>
              </div>
              <div class="info-value"><?= htmlspecialchars($data_pegawai['jabatan']) ?></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Info Card -->
      <div class="col-12 col-md-6">
        <div class="card info-card h-100">
          <div class="card-header info-card-header">
            <h5 class="mb-0">
              <i class="fas fa-address-book me-2"></i>
              Informasi Kontak
            </h5>
          </div>
          <div class="card-body">
            <?php if (!empty($data_pegawai['alamat'])): ?>
            <div class="info-item">
              <div class="info-label">
                <i class="fas fa-map-marker-alt text-danger"></i>
                <span>Alamat</span>
              </div>
              <div class="info-value"><?= htmlspecialchars($data_pegawai['alamat']) ?></div>
            </div>
            <?php endif; ?>
            <?php if (!empty($data_pegawai['telepon'])): ?>
            <div class="info-item">
              <div class="info-label">
                <i class="fas fa-phone text-success"></i>
                <span>Telepon</span>
              </div>
              <div class="info-value">
                <a href="tel:<?= htmlspecialchars($data_pegawai['telepon']) ?>" class="text-decoration-none">
                  <?= htmlspecialchars($data_pegawai['telepon']) ?>
                </a>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Jadwal Kerja Card -->
    <div class="card jadwal-card shadow-lg mb-4">
      <div class="card-header jadwal-card-header">
        <h5 class="mb-0">
          <i class="fas fa-calendar-week me-2"></i>
          Jadwal Kerja
        </h5>
        <a href="jadwal.php?id=<?= $data_pegawai['id'] ?>" class="btn btn-sm btn-outline-light">
          <i class="fas fa-eye me-1"></i>
          Detail
        </a>
      </div>
      <div class="card-body">
        <?php if (!empty($data_pegawai['jadwal_kerja'])): ?>
          <div class="jadwal-preview">
            <?= $data_pegawai['jadwal_kerja'] ?>
          </div>
        <?php else: ?>
          <div class="text-center text-muted py-4">
            <i class="fas fa-calendar-times fa-3x mb-3"></i>
            <p class="mb-0">Belum ada jadwal kerja</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php else: ?>
    <!-- No Data -->
    <div class="card shadow-lg">
      <div class="card-body text-center py-5">
        <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
        <h5 class="text-muted">Data tidak ditemukan</h5>
        <p class="text-muted">Silakan hubungi administrator untuk mengaktifkan akun Anda.</p>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php if ($role === 'admin'): ?>
<!-- Main Table Card (Admin Only) -->
<div class="card shadow-lg">
  <div class="card-header bg-white border-0 py-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h5 class="mb-0 fw-bold text-dark">
        <i class="fas fa-table text-primary me-2"></i>
        Daftar Pegawai
      </h5>
      <form method="GET" class="d-flex gap-2 mt-2 mt-md-0">
        <div class="input-group" style="min-width: 200px; max-width: 250px;">
          <span class="input-group-text bg-light border-end-0">
            <i class="fas fa-search text-muted"></i>
          </span>
          <input type="text" name="search" class="form-control border-start-0" id="searchInput" placeholder="Cari nama pegawai..." value="<?= htmlspecialchars($search) ?>">
          <button class="btn btn-outline-secondary" type="submit">
            <i class="fas fa-search"></i>
          </button>
          <?php if (!empty($search)): ?>
            <a href="list.php" class="btn btn-outline-secondary">
              <i class="fas fa-times"></i>
            </a>
          <?php endif; ?>
        </div>
      </form>
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
            <th class="border-0 d-none d-md-table-cell">
              <i class="fas fa-id-card text-muted me-1"></i>
              NIP
            </th>
            <th class="border-0 d-none d-lg-table-cell">
              <i class="fas fa-briefcase text-muted me-1"></i>
              Jabatan
            </th>
            <th class="border-0 d-none d-lg-table-cell">
              <i class="fas fa-map-marker-alt text-muted me-1"></i>
              Alamat
            </th>
            <th class="border-0 d-none d-md-table-cell">
              <i class="fas fa-phone text-muted me-1"></i>
              Telepon
            </th>
            <th class="border-0 d-none d-xl-table-cell">
              <i class="fas fa-birthday-cake text-muted me-1"></i>
              Tanggal Lahir
            </th>
            <th class="border-0 d-none d-lg-table-cell">
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
                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2 me-md-3" style="width: 40px; height: 40px;">
                  <i class="fas fa-user text-primary"></i>
                </div>
                <div>
                  <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($row['nama']) ?></h6>
                  <small class="text-muted d-md-none"><?= htmlspecialchars($row['nip']) ?> | <?= htmlspecialchars($row['jabatan']) ?></small>
                </div>
              </div>
            </td>
            <td class="d-none d-md-table-cell">
              <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">
                <?= htmlspecialchars($row['nip']) ?>
              </span>
            </td>
            <td class="d-none d-lg-table-cell">
              <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                <?= htmlspecialchars($row['jabatan']) ?>
              </span>
            </td>
            <td class="d-none d-lg-table-cell">
              <div class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($row['alamat']) ?>">
                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                <?= htmlspecialchars($row['alamat']) ?>
              </div>
            </td>
            <td class="d-none d-md-table-cell">
              <a href="tel:<?= htmlspecialchars($row['telepon']) ?>" class="text-decoration-none">
                <i class="fas fa-phone text-success me-1"></i>
                <?= htmlspecialchars($row['telepon']) ?>
              </a>
            </td>
            <td class="d-none d-xl-table-cell">
              <?php if (!empty($row['tanggal_lahir'])): ?>
                <?php 
                $tgl_lahir = new DateTime($row['tanggal_lahir']);
                echo $tgl_lahir->format('d/m/Y');
                ?>
              <?php else: ?>
                <span class="text-muted">-</span>
              <?php endif; ?>
            </td>
            <td class="d-none d-lg-table-cell">
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
              <div class="d-flex gap-1 justify-content-center">
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                  <i class="fas fa-edit"></i>
                  <span class="d-none d-lg-inline ms-1">Edit</span>
                </a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" 
                   onclick="return confirm('Yakin ingin menghapus pegawai ini?')" title="Hapus">
                  <i class="fas fa-trash"></i>
                  <span class="d-none d-lg-inline ms-1">Hapus</span>
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
<?php endif; ?>

<!-- Search Functionality (Admin Only) -->
<script>
<?php if ($role === 'admin'): ?>
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
<?php endif; ?>
</script>

<!-- Additional CSS for this page -->
<style>
/* Admin Styles */
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

/* User Profile Styles - Mobile Friendly */
.profile-header-card {
  background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
  border: none;
  border-radius: 20px;
  color: white;
  overflow: hidden;
}

.profile-avatar-wrapper {
  position: relative;
  display: inline-block;
}

.profile-avatar {
  width: 100px;
  height: 100px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  color: white;
  border: 4px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
}

.profile-status-badge {
  position: absolute;
  bottom: 5px;
  right: 5px;
  width: 24px;
  height: 24px;
  background: #10b981;
  border-radius: 50%;
  border: 3px solid white;
  display: flex;
  align-items: center;
  justify-content: center;
}

.profile-status-badge i {
  font-size: 0.6rem;
  color: white;
}

.profile-name {
  font-size: 1.75rem;
  font-weight: 700;
  color: white;
  margin: 0;
}

.profile-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.profile-badge-primary,
.profile-badge-secondary {
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-weight: 500;
  font-size: 0.875rem;
}

.profile-badge-primary {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(10px);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.profile-badge-secondary {
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.profile-actions .btn {
  border-radius: 25px;
  padding: 0.5rem 1.5rem;
  font-weight: 500;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.info-card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  height: 100%;
}

.info-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.info-card-header {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-bottom: 2px solid #4f46e5;
  border-radius: 15px 15px 0 0 !important;
  padding: 1rem 1.5rem;
}

.info-card-header h5 {
  color: #4f46e5;
  font-weight: 600;
  margin: 0;
}

.info-item {
  padding: 1rem 0;
  border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
  border-bottom: none;
}

.info-label {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #6b7280;
  font-size: 0.875rem;
}

.info-label i {
  width: 20px;
  text-align: center;
}

.info-value {
  color: #1f2937;
  font-size: 1rem;
  padding-left: 2rem;
  word-break: break-word;
}

.jadwal-card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.jadwal-card-header {
  background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
  color: white;
  border-radius: 15px 15px 0 0 !important;
  padding: 1.25rem 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.jadwal-card-header h5 {
  color: white;
  font-weight: 600;
  margin: 0;
}

.jadwal-preview {
  padding: 1rem;
  line-height: 2;
  color: #374151;
}

.jadwal-preview br {
  margin-bottom: 0.5rem;
}

/* Mobile Responsive */
@media (max-width: 768px) {
  .profile-header-card .card-body {
    padding: 1.5rem !important;
  }
  
  .profile-avatar {
    width: 80px;
    height: 80px;
    font-size: 2.5rem;
  }
  
  .profile-name {
    font-size: 1.5rem;
  }
  
  .profile-badges {
    margin-bottom: 1rem !important;
  }
  
  .info-card-header {
    padding: 0.75rem 1rem;
  }
  
  .info-card-header h5 {
    font-size: 1rem;
  }
  
  .info-item {
    padding: 0.75rem 0;
  }
  
  .info-value {
    padding-left: 1.5rem;
    font-size: 0.9rem;
  }
  
  .jadwal-card-header {
    padding: 1rem;
    flex-direction: column;
    align-items: flex-start;
    gap: 0.75rem;
  }
  
  .jadwal-card-header .btn {
    width: 100%;
  }
  
  .container-fluid {
    padding-left: 1rem;
    padding-right: 1rem;
  }
}

@media (max-width: 576px) {
  .profile-avatar {
    width: 70px;
    height: 70px;
    font-size: 2rem;
  }
  
  .profile-name {
    font-size: 1.25rem;
  }
  
  .profile-badge-primary,
  .profile-badge-secondary {
    font-size: 0.75rem;
    padding: 0.4rem 0.8rem;
  }
  
  .info-label {
    font-size: 0.8rem;
  }
  
  .info-value {
    font-size: 0.85rem;
    padding-left: 1.25rem;
  }
}
</style>

<?php include '../inc/footer.php'; ?> 