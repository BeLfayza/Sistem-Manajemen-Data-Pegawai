<?php
session_start();
include 'inc/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        if (md5($password) === $row['password']) {
            $_SESSION['user'] = [
                'id' => $row['id'],
                'username' => $row['username'],
                'role' => $row['role']
            ];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Username tidak ditemukan!';
    }
}
include 'inc/header.php';
?>

<!-- Login Page Container -->
<div class="login-container">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-5 col-lg-4">
        <!-- Login Card -->
        <div class="login-card">
          <div class="text-center mb-4">
            <div class="login-logo mb-3">
              <i class="fas fa-users-cog fa-3x text-primary"></i>
            </div>
            <h2 class="fw-bold text-dark mb-1">Selamat Datang</h2>
            <p class="text-muted mb-0">Silakan login untuk melanjutkan</p>
          </div>
          
          <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-triangle me-2"></i>
              <?= $error ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
          
          <form method="post" class="needs-validation" novalidate>
            <div class="mb-3">
              <label class="form-label fw-semibold">
                <i class="fas fa-user text-primary me-1"></i>
                Username
              </label>
              <input type="text" name="username" class="form-control form-control-lg" 
                     placeholder="Masukkan username" required>
              <div class="invalid-feedback">
                Username harus diisi
              </div>
            </div>
            
            <div class="mb-4">
              <label class="form-label fw-semibold">
                <i class="fas fa-lock text-primary me-1"></i>
                Password
              </label>
              <input type="password" name="password" class="form-control form-control-lg" 
                     placeholder="Masukkan password" required>
              <div class="invalid-feedback">
                Password harus diisi
              </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
              <i class="fas fa-sign-in-alt me-2"></i>
              Login
            </button>
            
            <div class="text-center">
              <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Demo: admin/admin atau user1/user1
              </small>
            </div>
          </form>
        </div>
        
        <!-- Footer Info -->
        <div class="text-center mt-4">
          <small class="text-white opacity-75">
            <i class="fas fa-code me-1"></i>
            Sistem Manajemen Pegawai v1.0
          </small>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Login Page JavaScript -->
<script>
// Form validation
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

// Add loading state to login button
document.querySelector('form').addEventListener('submit', function() {
  const button = this.querySelector('button[type="submit"]');
  button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Logging in...';
  button.disabled = true;
});
</script>

<!-- Login Page Styles -->
<style>
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  position: relative;
  overflow: hidden;
}

.login-container::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
  opacity: 0.3;
  z-index: 1;
}

.login-container .container {
  position: relative;
  z-index: 2;
}

.login-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  border-radius: 20px;
  padding: 2.5rem;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  animation: slideInUp 0.8s ease-out;
}

.login-logo {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #4f46e5, #3730a3);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  color: white;
  box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
}

.form-control-lg {
  padding: 1rem 1.25rem;
  font-size: 1rem;
  border-radius: 12px;
  border: 2px solid #e2e8f0;
  transition: all 0.3s ease;
}

.form-control-lg:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
  transform: translateY(-2px);
}

.btn-lg {
  padding: 1rem 2rem;
  font-size: 1.1rem;
  font-weight: 500;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.btn-lg:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
}

.alert {
  border-radius: 12px;
  border: none;
}

@keyframes slideInUp {
  from {
    opacity: 0;
    transform: translateY(60px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive */
@media (max-width: 768px) {
  .login-card {
    padding: 2rem;
    margin: 1rem;
  }
  
  .login-logo {
    width: 60px;
    height: 60px;
  }
  
  .login-logo i {
    font-size: 2rem;
  }
}
</style>

<?php include 'inc/footer.php'; ?> 