<?php
include '../inc/auth.php';
if ($_SESSION['user']['role'] !== 'admin') {
  header('Location: list.php'); exit;
}
include '../inc/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = md5($_POST['password']);
  $role = $_POST['role'] === 'admin' ? 'admin' : 'user';
  $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
  if (mysqli_query($conn, $sql)) {
    header('Location: list.php'); exit;
  } else {
    $error = 'Gagal menambah user!';
  }
}
include '../inc/header.php';
include '../inc/navbar.php';
?>
<div class="container mt-4">
  <h3>Tambah User</h3>
  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Role</label>
      <select name="role" class="form-control">
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="list.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
<?php include '../inc/footer.php'; ?> 