<?php
include '../inc/auth.php';
if ($_SESSION['user']['role'] !== 'admin') {
  header('Location: list.php'); exit;
}
include '../inc/db.php';
$id = intval($_GET['id']);
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $role = $_POST['role'] === 'admin' ? 'admin' : 'user';
  $sql = "UPDATE users SET username='$username', role='$role'";
  if (!empty($_POST['password'])) {
    $password = md5($_POST['password']);
    $sql .= ", password='$password'";
  }
  $sql .= " WHERE id=$id";
  if (mysqli_query($conn, $sql)) {
    header('Location: list.php'); exit;
  } else {
    $error = 'Gagal mengedit user!';
  }
}
$q = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$data = mysqli_fetch_assoc($q);
include '../inc/header.php';
include '../inc/navbar.php';
?>
<div class="container mt-4">
  <h3>Edit User</h3>
  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Password (kosongkan jika tidak diubah)</label>
      <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
      <label>Role</label>
      <select name="role" class="form-control">
        <option value="user" <?= $data['role']==='user'?'selected':'' ?>>User</option>
        <option value="admin" <?= $data['role']==='admin'?'selected':'' ?>>Admin</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="list.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
<?php include '../inc/footer.php'; ?> 