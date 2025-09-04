<?php
include 'inc/auth.php';
include 'inc/header.php';
include 'inc/navbar.php';
$user = $_SESSION['user'];
?>

<!-- Welcome Section -->
<div class="welcome-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <!-- Welcome Card -->
        <div class="welcome-card">
          <div class="welcome-header text-center mb-5">
            <div class="welcome-avatar mb-4">
              <div class="avatar-circle">
                <i class="fas fa-user fa-3x text-white"></i>
              </div>
            </div>
            
            <h1 class="welcome-title">
              Selamat Datang, <?= htmlspecialchars($user['username']) ?>! 👋
            </h1>
            
            <p class="welcome-subtitle">
              Anda login sebagai <span class="role-badge"><?= htmlspecialchars($user['role']) ?></span>
            </p>
            
            <div class="welcome-description">
              <p class="text-muted">
                Gunakan menu di samping untuk mengelola data pegawai, jadwal kerja, dan user sistem.
              </p>
            </div>
          </div>
          
          <!-- Quick Actions -->
          <div class="quick-actions">
            <div class="row g-3">
              <div class="col-md-4">
                <a href="pegawai/list.php" class="quick-action-card">
                  <div class="quick-action-icon bg-primary">
                    <i class="fas fa-users"></i>
                  </div>
                  <h5>Data Pegawai</h5>
                  <p class="text-muted">Kelola informasi pegawai</p>
                </a>
              </div>
              
              <div class="col-md-4">
                <a href="pegawai/jadwal.php" class="quick-action-card">
                  <div class="quick-action-icon bg-success">
                    <i class="fas fa-calendar-alt"></i>
                  </div>
                  <h5>Jadwal Kerja</h5>
                  <p class="text-muted">Lihat jadwal kerja</p>
                </a>
              </div>
              
              <?php if ($user['role'] === 'admin'): ?>
              <div class="col-md-4">
                <a href="user/list.php" class="quick-action-card">
                  <div class="quick-action-icon bg-warning">
                    <i class="fas fa-user-shield"></i>
                  </div>
                  <h5>Kelola User</h5>
                  <p class="text-muted">Manajemen user sistem</p>
                </a>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        
        <!-- System Info -->
        <div class="system-info mt-5">
          <div class="row g-4">
            <div class="col-md-6">
              <div class="info-card">
                <div class="info-icon bg-info">
                  <i class="fas fa-info-circle"></i>
                </div>
                <div class="info-content">
                  <h6>Fitur Utama</h6>
                  <ul class="list-unstyled text-muted">
                    <li><i class="fas fa-check text-success me-2"></i>Manajemen data pegawai</li>
                    <li><i class="fas fa-check text-success me-2"></i>Jadwal kerja harian</li>
                    <li><i class="fas fa-check text-success me-2"></i>Sistem user & role</li>
                    <li><i class="fas fa-check text-success me-2"></i>Interface modern</li>
                  </ul>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="info-card">
                <div class="info-icon bg-success">
                  <i class="fas fa-shield-alt"></i>
                </div>
                <div class="info-content">
                  <h6>Keamanan</h6>
                  <ul class="list-unstyled text-muted">
                    <li><i class="fas fa-check text-success me-2"></i>Session management</li>
                    <li><i class="fas fa-check text-success me-2"></i>Role-based access</li>
                    <li><i class="fas fa-check text-success me-2"></i>SQL injection protection</li>
                    <li><i class="fas fa-check text-success me-2"></i>Input validation</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Welcome Page Styles -->
<style>
.welcome-section {
  padding: 2rem 0;
  min-height: calc(100vh - 200px);
}

.welcome-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  border-radius: var(--border-radius-lg);
  padding: 3rem 2rem;
  box-shadow: var(--shadow-xl);
  border: 1px solid rgba(255, 255, 255, 0.2);
  margin-bottom: 2rem;
}

.welcome-header {
  position: relative;
}

.welcome-avatar {
  display: flex;
  justify-content: center;
}

.avatar-circle {
  width: 120px;
  height: 120px;
  background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 15px 40px rgba(79, 70, 229, 0.3);
  transition: var(--transition);
}

.avatar-circle:hover {
  transform: scale(1.05);
  box-shadow: 0 20px 50px rgba(79, 70, 229, 0.4);
}

.welcome-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--dark-color);
  margin-bottom: 1rem;
  line-height: 1.2;
}

.welcome-subtitle {
  font-size: 1.1rem;
  color: var(--text-muted);
  margin-bottom: 1.5rem;
}

.role-badge {
  background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 2rem;
  font-weight: 600;
  font-size: 0.9rem;
  box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.quick-actions {
  margin-top: 2rem;
}

.quick-action-card {
  display: block;
  text-decoration: none;
  color: inherit;
  background: rgba(255, 255, 255, 0.8);
  border-radius: var(--border-radius-lg);
  padding: 2rem 1.5rem;
  text-align: center;
  transition: var(--transition);
  border: 1px solid rgba(255, 255, 255, 0.3);
  height: 100%;
}

.quick-action-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
  background: rgba(255, 255, 255, 0.95);
  color: inherit;
  text-decoration: none;
}

.quick-action-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  color: white;
  font-size: 1.75rem;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.quick-action-card h5 {
  margin-bottom: 0.75rem;
  font-weight: 600;
  color: var(--dark-color);
}

.quick-action-card p {
  color: var(--text-muted);
  font-size: 0.9rem;
  line-height: 1.5;
}

.system-info {
  margin-top: 3rem;
}

.info-card {
  background: rgba(255, 255, 255, 0.9);
  border-radius: var(--border-radius-lg);
  padding: 2rem;
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
  border: 1px solid rgba(255, 255, 255, 0.3);
  transition: var(--transition);
  height: 100%;
}

.info-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.info-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.5rem;
  flex-shrink: 0;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.info-content h6 {
  font-weight: 600;
  margin-bottom: 1rem;
  color: var(--dark-color);
  font-size: 1.1rem;
}

.info-content ul {
  list-style: none;
  padding: 0;
}

.info-content ul li {
  margin-bottom: 0.75rem;
  font-size: 0.95rem;
  color: var(--text-muted);
  display: flex;
  align-items: center;
}

.info-content ul li i {
  margin-right: 0.75rem;
  width: 16px;
}

/* Responsive */
@media (max-width: 768px) {
  .welcome-card {
    padding: 2rem 1.5rem;
  }
  
  .avatar-circle {
    width: 100px;
    height: 100px;
  }
  
  .avatar-circle i {
    font-size: 2.5rem;
  }
  
  .welcome-title {
    font-size: 2rem;
  }
  
  .quick-action-card {
    padding: 1.5rem 1rem;
  }
  
  .quick-action-icon {
    width: 60px;
    height: 60px;
    font-size: 1.5rem;
  }
  
  .info-card {
    padding: 1.5rem;
    flex-direction: column;
    text-align: center;
  }
  
  .info-icon {
    width: 50px;
    height: 50px;
    font-size: 1.25rem;
  }
}
</style>

<?php include 'inc/footer.php'; ?> 