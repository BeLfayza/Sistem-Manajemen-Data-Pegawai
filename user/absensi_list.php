<?php
include '../inc/auth.php';
if ($_SESSION['user']['role'] !== 'admin') {
  header('Location: /manajemen/index.php'); exit;
}
include '../inc/db.php';
include '../inc/header.php';
include '../inc/navbar.php';

// Get search parameter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Build query with search condition
$search_condition = !empty($search) ? "WHERE p.nama LIKE '%$search%'" : '';
$q = mysqli_query($conn, "
  SELECT a.*, u.username, p.nama as nama_pegawai 
  FROM absensi a 
  LEFT JOIN users u ON a.user_id=u.id 
  LEFT JOIN pegawai p ON u.pegawai_id=p.id 
  $search_condition
  ORDER BY a.waktu DESC
");
?>
<div class="container mt-4">
  <div class="card shadow-lg">
    <div class="card-header bg-white border-0 py-3">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h3 class="mb-0">
          <i class="fas fa-clock text-primary me-2"></i>
          Daftar Absensi
        </h3>
        <form method="GET" class="d-flex gap-2 mt-2 mt-md-0">
          <div class="input-group" style="min-width: 200px; max-width: 250px;">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama pegawai..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-outline-secondary" type="submit">
              <i class="fas fa-search"></i>
            </button>
            <?php if (!empty($search)): ?>
              <a href="absensi_list.php" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
              </a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Nama Pegawai</th>
              <th>Tipe</th>
              <th>Waktu</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($q)): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['nama_pegawai'] ?? '-') ?></td>
              <td><?= htmlspecialchars($row['tipe']) ?></td>
              <td><?= htmlspecialchars($row['waktu']) ?></td>
              <td><?= htmlspecialchars($row['status']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include '../inc/footer.php'; ?>
