<?php
include '../inc/auth.php';
if ($_SESSION['user']['role'] !== 'admin') {
  header('Location: /manajemen/index.php'); exit;
}
include '../inc/db.php';
include '../inc/header.php';
include '../inc/navbar.php';

$q = mysqli_query($conn, "SELECT a.*, u.username FROM absensi a LEFT JOIN users u ON a.user_id=u.id ORDER BY a.waktu DESC");
?>
<div class="container mt-4">
  <h3>Daftar Absensi</h3>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Username</th>
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
        <td><?= htmlspecialchars($row['tipe']) ?></td>
        <td><?= htmlspecialchars($row['waktu']) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../inc/footer.php'; ?>
