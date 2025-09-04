<?php
include '../inc/auth.php';
if ($_SESSION['user']['role'] !== 'admin') {
  header('Location: /index.php'); exit;
}
include '../inc/db.php';
include '../inc/header.php';
include '../inc/navbar.php';
$result = mysqli_query($conn, "SELECT * FROM users");
?>
<div class="container mt-4">
  <h3>Data User</h3>
  <a href="tambah.php" class="btn btn-success mb-2">Tambah User</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Role</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['role']) ?></td>
        <td>
          <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus user?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include '../inc/footer.php'; ?> 