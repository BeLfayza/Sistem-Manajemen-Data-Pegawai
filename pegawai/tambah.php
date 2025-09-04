<?php
include '../inc/auth.php';
if ($_SESSION['user']['role'] !== 'admin') {
  header('Location: list.php'); exit;
}
include '../inc/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $nip = mysqli_real_escape_string($conn, $_POST['nip']);
  $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
  $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
  $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
  
  // Insert pegawai
  $sql = "INSERT INTO pegawai (nama, nip, jabatan, alamat, telepon) VALUES ('$nama', '$nip', '$jabatan', '$alamat', '$telepon')";
  if (mysqli_query($conn, $sql)) {
    $pegawai_id = mysqli_insert_id($conn);
    
    // Insert jadwal kerja
    $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    foreach ($hari_list as $hari) {
      if (isset($_POST['jadwal_' . $hari]) && $_POST['jadwal_' . $hari] == '1') {
        $jam_masuk = mysqli_real_escape_string($conn, $_POST['jam_masuk_' . $hari]);
        $jam_keluar = mysqli_real_escape_string($conn, $_POST['jam_keluar_' . $hari]);
        $shift = mysqli_real_escape_string($conn, $_POST['shift_' . $hari]);
        
        $sql_jadwal = "INSERT INTO jadwal_kerja (pegawai_id, hari, jam_masuk, jam_keluar, shift) 
                       VALUES ('$pegawai_id', '$hari', '$jam_masuk', '$jam_keluar', '$shift')";
        mysqli_query($conn, $sql_jadwal);
      }
    }
    
    header('Location: list.php'); exit;
  } else {
    $error = 'Gagal menambah data!';
  }
}
include '../inc/header.php';
include '../inc/navbar.php';
?>

<!-- Page Header -->
<div class="page-header mb-5">
  <div class="d-flex justify-content-between align-items-center">
    <div class="header-content">
      <div class="header-icon">
        <i class="fas fa-user-plus"></i>
      </div>
      <div class="header-text">
        <h1 class="page-title">Tambah Pegawai Baru</h1>
        <p class="page-subtitle">Isi informasi lengkap pegawai dan jadwal kerjanya</p>
      </div>
    </div>
    
    <div class="header-actions">
      <a href="list.php" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
      </a>
    </div>
  </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <i class="fas fa-exclamation-triangle me-2"></i>
  <?= $error ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Add Form -->
<div class="row">
  <div class="col-lg-8">
    <form method="post" class="edit-form needs-validation" novalidate>
  <div class="row">
    <!-- Data Pegawai Card -->
    <div class="col-lg-6 mb-4">
      <div class="card shadow-lg h-100">
        <div class="card-header bg-gradient-primary text-white">
          <h5 class="mb-0">
            <i class="fas fa-user me-2"></i>
            Informasi Pegawai
          </h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">
              <i class="fas fa-user text-primary me-1"></i>
              Nama Lengkap
            </label>
            <input type="text" name="nama" class="form-control" required>
            <div class="invalid-feedback">
              Nama harus diisi
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label fw-semibold">
              <i class="fas fa-id-card text-primary me-1"></i>
              NIP
            </label>
            <input type="text" name="nip" class="form-control" required>
            <div class="invalid-feedback">
              NIP harus diisi
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label fw-semibold">
              <i class="fas fa-briefcase text-primary me-1"></i>
              Jabatan
            </label>
            <input type="text" name="jabatan" class="form-control" required>
            <div class="invalid-feedback">
              Jabatan harus diisi
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label fw-semibold">
              <i class="fas fa-map-marker-alt text-primary me-1"></i>
              Alamat
            </label>
            <textarea name="alamat" class="form-control" rows="3"></textarea>
          </div>
          
          <div class="mb-3">
            <label class="form-label fw-semibold">
              <i class="fas fa-phone text-primary me-1"></i>
              Nomor Telepon
            </label>
            <input type="text" name="telepon" class="form-control">
          </div>
        </div>
      </div>
    </div>
    
    <!-- Jadwal Kerja Card -->
    <div class="col-lg-6 mb-4">
      <div class="card shadow-lg h-100">
        <div class="card-header bg-gradient-info text-white">
          <h5 class="mb-0">
            <i class="fas fa-calendar-alt me-2"></i>
            Jadwal Kerja
          </h5>
        </div>
        <div class="card-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-1"></i>
            Centang hari kerja dan isi detail jadwalnya
          </p>
          
          <?php
          $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
          foreach ($hari_list as $hari):
            $hari_icon = [
              'Senin' => 'fa-calendar-day',
              'Selasa' => 'fa-calendar-day',
              'Rabu' => 'fa-calendar-day',
              'Kamis' => 'fa-calendar-day',
              'Jumat' => 'fa-calendar-day',
              'Sabtu' => 'fa-calendar-day',
              'Minggu' => 'fa-calendar-day'
            ];
          ?>
          <div class="jadwal-day-card mb-3">
            <div class="card border-0 bg-light">
              <div class="card-body p-3">
                <div class="form-check mb-3">
                  <input class="form-check-input jadwal-checkbox" type="checkbox" 
                         name="jadwal_<?= $hari ?>" value="1" id="jadwal_<?= $hari ?>">
                  <label class="form-check-label fw-semibold" for="jadwal_<?= $hari ?>">
                    <i class="fas <?= $hari_icon[$hari] ?> text-primary me-2"></i>
                    <?= $hari ?>
                  </label>
                </div>
                
                <div class="row g-2 jadwal-inputs">
                  <div class="col-4">
                    <label class="form-label small text-muted">
                      <i class="fas fa-clock text-success me-1"></i>
                      Jam Masuk
                    </label>
                    <input type="time" name="jam_masuk_<?= $hari ?>" 
                           class="form-control form-control-sm" disabled>
                  </div>
                  <div class="col-4">
                    <label class="form-label small text-muted">
                      <i class="fas fa-clock text-danger me-1"></i>
                      Jam Keluar
                    </label>
                    <input type="time" name="jam_keluar_<?= $hari ?>" 
                           class="form-control form-control-sm" disabled>
                  </div>
                  <div class="col-4">
                    <label class="form-label small text-muted">
                      <i class="fas fa-moon text-warning me-1"></i>
                      Shift
                    </label>
                    <select name="shift_<?= $hari ?>" class="form-select form-select-sm" disabled>
                      <option value="Pagi">Pagi</option>
                      <option value="Siang">Siang</option>
                      <option value="Malam">Malam</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  
      <!-- Form Actions -->
      <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="fas fa-save me-2"></i>
          Simpan Data
        </button>
        <a href="list.php" class="btn btn-outline-secondary btn-lg">
          <i class="fas fa-times me-2"></i>
          Batal
        </a>
      </div>
    </form>
  </div>
  
  <!-- Sidebar -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">
          <i class="fas fa-info-circle me-2 text-info"></i>
          Panduan
        </h6>
      </div>
      <div class="card-body">
        <div class="alert alert-info">
          <i class="fas fa-lightbulb me-2"></i>
          <strong>Tips:</strong> Pastikan semua field wajib diisi dengan benar.
        </div>
        
        <div class="alert alert-warning">
          <i class="fas fa-exclamation-triangle me-2"></i>
          <strong>Perhatian:</strong> NIP harus unik dan tidak boleh sama dengan pegawai lain.
        </div>
        
        <div class="info-section">
          <h6 class="fw-semibold mb-3">
            <i class="fas fa-calendar-alt me-2 text-primary"></i>
            Jadwal Kerja
          </h6>
          <ul class="list-unstyled">
            <li class="mb-2">
              <i class="fas fa-check text-success me-2"></i>
              Centang hari kerja yang aktif
            </li>
            <li class="mb-2">
              <i class="fas fa-check text-success me-2"></i>
              Isi jam masuk dan keluar
            </li>
            <li class="mb-2">
              <i class="fas fa-check text-success me-2"></i>
              Pilih shift yang sesuai
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Page Styles -->
<style>
.edit-form {
  animation: slideInUp 0.6s ease-out;
}

.form-group {
  position: relative;
}

.form-label {
  color: var(--dark-color);
  margin-bottom: 0.5rem;
  display: block;
}

.form-control {
  border: 2px solid var(--border-color);
  border-radius: 0.5rem;
  padding: 0.75rem 1rem;
  transition: var(--transition);
  background: rgba(255, 255, 255, 0.9);
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
  background: white;
}

.schedule-card {
  background: rgba(255, 255, 255, 0.8);
  border: 2px solid var(--border-color);
  border-radius: var(--border-radius);
  padding: 1rem;
  transition: var(--transition);
}

.schedule-card:hover {
  border-color: var(--primary-color);
  background: rgba(79, 70, 229, 0.02);
}

.schedule-header {
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid var(--border-color);
}

.schedule-body {
  opacity: 0.7;
  transition: var(--transition);
}

.schedule-card:has(input[type="checkbox"]:checked) .schedule-body {
  opacity: 1;
}

.schedule-card:has(input[type="checkbox"]:checked) {
  border-color: var(--primary-color);
  background: rgba(79, 70, 229, 0.05);
}

.form-check-input:checked {
  background-color: var(--primary-color);
  border-color: var(--primary-color);
}

.form-actions {
  background: rgba(255, 255, 255, 0.9);
  border-radius: var(--border-radius-lg);
  padding: 2rem;
  margin-top: 2rem;
  text-align: center;
  border: 1px solid var(--border-color);
}

.alert {
  border: none;
  border-radius: var(--border-radius);
  padding: 1rem;
}

.alert-info {
  background: rgba(6, 182, 212, 0.1);
  color: var(--info-color);
  border-left: 4px solid var(--info-color);
}

.alert-warning {
  background: rgba(245, 158, 11, 0.1);
  color: var(--warning-color);
  border-left: 4px solid var(--warning-color);
}

.info-section {
  margin-top: 1rem;
}

.info-section ul li {
  display: flex;
  align-items: center;
  font-size: 0.9rem;
  color: var(--text-muted);
}

/* Responsive */
@media (max-width: 768px) {
  .form-actions {
    padding: 1.5rem;
  }
  
  .schedule-card {
    padding: 0.75rem;
  }
}
</style>

<!-- Enhanced JavaScript -->
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

// Enhanced jadwal functionality
document.querySelectorAll('.jadwal-checkbox').forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    const card = this.closest('.jadwal-day-card');
    const inputs = card.querySelectorAll('.jadwal-inputs input, .jadwal-inputs select');
    const dayCard = card.querySelector('.card');
    
    inputs.forEach(input => {
      input.disabled = !this.checked;
      if (!this.checked) {
        input.value = '';
      }
    });
    
    // Visual feedback
    if (this.checked) {
      dayCard.classList.remove('bg-light');
      dayCard.classList.add('bg-success', 'bg-opacity-10', 'border-success');
      card.style.animation = 'fadeInScale 0.3s ease-in';
    } else {
      dayCard.classList.remove('bg-success', 'bg-opacity-10', 'border-success');
      dayCard.classList.add('bg-light');
      card.style.animation = 'fadeOutScale 0.3s ease-out';
    }
  });
  
  // Trigger change event on page load
  checkbox.dispatchEvent(new Event('change'));
});

// Auto-save draft (optional feature)
let formData = {};
document.querySelectorAll('input, select, textarea').forEach(input => {
  input.addEventListener('input', function() {
    formData[this.name] = this.value;
    localStorage.setItem('pegawaiDraft', JSON.stringify(formData));
  });
});

// Load draft on page load
window.addEventListener('load', function() {
  const draft = localStorage.getItem('pegawaiDraft');
  if (draft) {
    formData = JSON.parse(draft);
    Object.keys(formData).forEach(key => {
      const input = document.querySelector(`[name="${key}"]`);
      if (input) {
        input.value = formData[key];
      }
    });
  }
});

// Clear draft on successful submit
document.querySelector('form').addEventListener('submit', function() {
  localStorage.removeItem('pegawaiDraft');
});
</script>

<!-- Additional CSS -->
<style>
.jadwal-day-card {
  transition: all 0.3s ease;
}

.jadwal-day-card .card {
  transition: all 0.3s ease;
  border-radius: 12px;
}

.jadwal-day-card:hover {
  transform: translateY(-2px);
}

.jadwal-inputs {
  opacity: 0.7;
  transition: opacity 0.3s ease;
}

.jadwal-checkbox:checked ~ .jadwal-inputs {
  opacity: 1;
}

@keyframes fadeInScale {
  from { 
    opacity: 0; 
    transform: scale(0.95); 
  }
  to { 
    opacity: 1; 
    transform: scale(1); 
  }
}

@keyframes fadeOutScale {
  from { 
    opacity: 1; 
    transform: scale(1); 
  }
  to { 
    opacity: 0.8; 
    transform: scale(0.98); 
  }
}

.bg-gradient-primary {
  background: linear-gradient(135deg, #4f46e5, #3730a3);
}

.bg-gradient-info {
  background: linear-gradient(135deg, #06b6d4, #0891b2);
}

.form-control:focus, .form-select:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

.btn-lg {
  padding: 0.875rem 2rem;
  font-size: 1.1rem;
  font-weight: 500;
}
</style>

<?php include '../inc/footer.php'; ?> 