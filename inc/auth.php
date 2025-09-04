<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
// Untuk cek role: $_SESSION['user']['role']
?> 