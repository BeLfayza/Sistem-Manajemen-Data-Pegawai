<?php
include '../inc/auth.php';
if ($_SESSION['user']['role'] !== 'admin') {
  header('Location: list.php'); exit;
}
include '../inc/db.php';
$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM pegawai WHERE id=$id");
header('Location: list.php');
exit; 