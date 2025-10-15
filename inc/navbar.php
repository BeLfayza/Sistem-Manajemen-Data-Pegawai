<?php
if (!isset($_SESSION)) session_start();
$role = isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : '';
$username = isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '';
?>
<div class="container-fluid">
  <div class="row">
    <!-- Modern Sidebar -->
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse min-vh-100">
      <div class="position-sticky pt-3">
        <!-- Brand Logo -->
        <div class="text-center mb-5">
          <div class="brand-logo mb-3">
            <div class="brand-icon-container">
              <i class="fas fa-users-cog fa-2x text-white"></i>
            </div>
          </div>
          <a class="navbar-brand text-white d-block" href="/manajemen/index.php">
            <span class="fw-bold fs-4">Manajemen</span><br>
            <small class="text-light opacity-75">Pegawai</small>
          </a>
        </div>

        <!-- User Profile -->
        <div class="text-center mb-5">
          <div class="user-avatar-container mb-3">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($username) ?>&background=4f46e5&color=fff&size=100&font-size=0.4" 
                 class="user-avatar" alt="User Avatar" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="user-avatar-fallback" style="display: none; width: 100px; height: 100px; background: linear-gradient(135deg, #4f46e5, #3730a3); border-radius: 50%; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);">
              <i class="fas fa-user fa-2x text-white"></i>
            </div>
          </div>
          <div class="user-info">
            <h6 class="text-white mb-2 fw-semibold"><?= ucfirst($username) ?></h6>
          </div>
        </div>

        <!-- Navigation Menu -->
        <ul class="nav flex-column px-2">
          <li class="nav-item mb-2">
            <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'list.php') !== false ? 'active' : '' ?>" 
               href="/manajemen/pegawai/list.php">
              <i class="fas fa-users me-3"></i>
              <span>Data Pegawai</span>
            </a>
          </li>
          
          <li class="nav-item mb-2">
            <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'jadwal.php') !== false ? 'active' : '' ?>" 
               href="/manajemen/pegawai/jadwal.php">
              <i class="fas fa-calendar-alt me-3"></i>
              <span>Jadwal Kerja</span>
            </a>
          </li>
          
          <?php if ($role === 'admin'): ?>
          <li class="nav-item mb-2">
            <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'tambah.php') !== false ? 'active' : '' ?>" 
               href="/manajemen/pegawai/tambah.php">
              <i class="fas fa-user-plus me-3"></i>
              <span>Tambah Pegawai</span>
            </a>
          </li>
          
          <li class="nav-item mb-2">
            <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'user/list.php') !== false ? 'active' : '' ?>" 
               href="/manajemen/user/list.php">
              <i class="fas fa-user-shield me-3"></i>
              <span>Kelola User</span>
            </a>
          </li>
          <?php endif; ?>
          
          <li class="nav-item mt-4 pt-3 border-top border-secondary border-opacity-25">
            <a class="nav-link logout-link" href="/manajemen/logout.php">
              <i class="fas fa-sign-out-alt me-3"></i>
              <span>Logout</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main Content Area -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">
      <div class="main-content-wrapper"> 