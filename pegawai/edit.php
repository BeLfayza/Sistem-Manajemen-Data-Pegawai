<?php
include '../inc/auth.php';
if ($_SESSION['user']['role'] !== 'admin') {
  header('Location: list.php'); exit;
}
include '../inc/db.php';
$id = intval($_GET['id']);
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $nip = mysqli_real_escape_string($conn, $_POST['nip']);
  $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
  $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
  $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
  
  // Update pegawai
  $sql = "UPDATE pegawai SET nama='$nama', nip='$nip', jabatan='$jabatan', alamat='$alamat', telepon='$telepon' WHERE id=$id";
  if (mysqli_query($conn, $sql)) {
    // Delete existing jadwal kerja
    mysqli_query($conn, "DELETE FROM jadwal_kerja WHERE pegawai_id=$id");
    
    // Insert new jadwal kerja
    $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    foreach ($hari_list as $hari) {
      if (isset($_POST['jadwal_' . $hari]) && $_POST['jadwal_' . $hari] == '1') {
        $jam_masuk = mysqli_real_escape_string($conn, $_POST['jam_masuk_' . $hari]);
        $jam_keluar = mysqli_real_escape_string($conn, $_POST['jam_keluar_' . $hari]);
        $shift = mysqli_real_escape_string($conn, $_POST['shift_' . $hari]);
        
        $sql_jadwal = "INSERT INTO jadwal_kerja (pegawai_id, hari, jam_masuk, jam_keluar, shift) 
                       VALUES ('$id', '$hari', '$jam_masuk', '$jam_keluar', '$shift')";
        mysqli_query($conn, $sql_jadwal);
      }
    }
    
    header('Location: list.php'); exit;
  } else {
    $error = 'Gagal mengedit data!';
  }
}
$q = mysqli_query($conn, "SELECT * FROM pegawai WHERE id=$id");
$data = mysqli_fetch_assoc($q);

// Get existing jadwal kerja
$jadwal_result = mysqli_query($conn, "SELECT * FROM jadwal_kerja WHERE pegawai_id=$id");
$jadwal_data = [];
while ($jadwal = mysqli_fetch_assoc($jadwal_result)) {
  $jadwal_data[$jadwal['hari']] = $jadwal;
}

include '../inc/header.php';
include '../inc/navbar.php';
?>

<!-- Page Header -->
<div class="page-header mb-5">
  <div class="d-flex justify-content-between align-items-center">
    <div class="header-content">
      <div class="header-icon">
        <i class="fas fa-user-edit"></i>
      </div>
      <div class="header-text">
        <h1 class="page-title">Edit Pegawai</h1>
        <p class="page-subtitle">Ubah informasi dan jadwal kerja pegawai</p>
      </div>
    </div>
    
    <div class="header-actions">
      <a href="list.php" class="btn btn-outline-secondary me-2">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
      </a>
    </div>
  </div>
</div>

<!-- Error Alert -->
<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <i class="fas fa-exclamation-triangle me-2"></i>
  <?= $error ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Edit Form -->
<div class="row">
  <div class="col-lg-8">
    <form method="post" class="edit-form">
      <!-- Data Pegawai Section -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">
            <i class="fas fa-user me-2 text-primary"></i>
            Data Pegawai
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="form-label fw-semibold">
                  <i class="fas fa-user me-1 text-muted"></i>
                  Nama Lengkap
                </label>
                <input type="text" name="nama" class="form-control" 
                       value="<?= htmlspecialchars($data['nama']) ?>" 
                       placeholder="Masukkan nama lengkap" required>
              </div>
              
              <div class="form-group mb-3">
                <label class="form-label fw-semibold">
                  <i class="fas fa-id-card me-1 text-muted"></i>
                  NIP
                </label>
                <input type="text" name="nip" class="form-control" 
                       value="<?= htmlspecialchars($data['nip']) ?>" 
                       placeholder="Masukkan NIP" required>
              </div>
              
              <div class="form-group mb-3">
                <label class="form-label fw-semibold">
                  <i class="fas fa-briefcase me-1 text-muted"></i>
                  Jabatan
                </label>
                <input type="text" name="jabatan" class="form-control" 
                       value="<?= htmlspecialchars($data['jabatan']) ?>" 
                       placeholder="Masukkan jabatan" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="form-label fw-semibold">
                  <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                  Alamat
                </label>
                <textarea name="alamat" class="form-control" rows="4" 
                          placeholder="Masukkan alamat lengkap"><?= htmlspecialchars($data['alamat']) ?></textarea>
              </div>
              
              <div class="form-group mb-3">
                <label class="form-label fw-semibold">
                  <i class="fas fa-phone me-1 text-muted"></i>
                  Nomor Telepon
                </label>
                <input type="text" name="telepon" class="form-control" 
                       value="<?= htmlspecialchars($data['telepon']) ?>" 
                       placeholder="Masukkan nomor telepon">
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Jadwal Kerja Section -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">
            <i class="fas fa-calendar-alt me-2 text-primary"></i>
            Jadwal Kerja
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <?php
            $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            foreach ($hari_list as $hari):
              $jadwal = isset($jadwal_data[$hari]) ? $jadwal_data[$hari] : null;
            ?>
            <div class="col-md-6 mb-3">
              <div class="schedule-card">
                <div class="schedule-header">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="jadwal_<?= $hari ?>" value="1" id="jadwal_<?= $hari ?>" 
                           <?= $jadwal ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="jadwal_<?= $hari ?>">
                      <i class="fas fa-calendar-day me-2 text-primary"></i>
                      <?= $hari ?>
                    </label>
                  </div>
                </div>
                
                <div class="schedule-body">
                  <div class="row g-2">
                    <div class="col-4">
                      <label class="form-label small">Jam Masuk</label>
                      <input type="time" name="jam_masuk_<?= $hari ?>" class="form-control form-control-sm" 
                             value="<?= $jadwal ? $jadwal['jam_masuk'] : '' ?>">
                    </div>
                    <div class="col-4">
                      <label class="form-label small">Jam Keluar</label>
                      <input type="time" name="jam_keluar_<?= $hari ?>" class="form-control form-control-sm" 
                             value="<?= $jadwal ? $jadwal['jam_keluar'] : '' ?>">
                    </div>
                    <div class="col-4">
                      <label class="form-label small">Shift</label>
                      <select name="shift_<?= $hari ?>" class="form-control form-control-sm">
                        <option value="Pagi" <?= ($jadwal && $jadwal['shift'] == 'Pagi') ? 'selected' : '' ?>>Pagi</option>
                        <option value="Siang" <?= ($jadwal && $jadwal['shift'] == 'Siang') ? 'selected' : '' ?>>Siang</option>
                        <option value="Malam" <?= ($jadwal && $jadwal['shift'] == 'Malam') ? 'selected' : '' ?>>Malam</option>
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
      
      <!-- Form Actions -->
      <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="fas fa-save me-2"></i>
          Update Data
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
          Informasi
        </h6>
      </div>
      <div class="card-body">
        <div class="info-item">
          <i class="fas fa-user text-primary me-2"></i>
          <span class="fw-semibold">Nama:</span>
          <span class="text-muted"><?= htmlspecialchars($data['nama']) ?></span>
        </div>
        <div class="info-item">
          <i class="fas fa-id-card text-primary me-2"></i>
          <span class="fw-semibold">NIP:</span>
          <span class="text-muted"><?= htmlspecialchars($data['nip']) ?></span>
        </div>
        <div class="info-item">
          <i class="fas fa-briefcase text-primary me-2"></i>
          <span class="fw-semibold">Jabatan:</span>
          <span class="text-muted"><?= htmlspecialchars($data['jabatan']) ?></span>
        </div>
        
        <hr>
        
        <div class="alert alert-info">
          <i class="fas fa-lightbulb me-2"></i>
          <strong>Tips:</strong> Centang hari kerja yang aktif dan isi jam kerja sesuai kebutuhan.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Page Styles -->
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

.info-item {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
  padding: 0.5rem 0;
}

.info-item:last-child {
  margin-bottom: 0;
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

/* Responsive */
@media (max-width: 768px) {
  .form-actions {
    padding: 1.5rem;
  }
  
  .schedule-card {
    padding: 0.75rem;
  }
  
  .info-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.25rem;
  }
}
</style>

<script>
// Enhanced form functionality
document.addEventListener('DOMContentLoaded', function() {
  // Enable/disable time inputs based on checkbox
  document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
      const scheduleCard = this.closest('.schedule-card');
      const inputs = scheduleCard.querySelectorAll('input[type="time"], select');
      
      inputs.forEach(input => {
        input.disabled = !this.checked;
        if (!this.checked) {
          input.value = '';
        }
      });
      
      // Add visual feedback
      if (this.checked) {
        scheduleCard.style.transform = 'scale(1.02)';
        setTimeout(() => {
          scheduleCard.style.transform = 'scale(1)';
        }, 200);
      }
    });
    
    // Trigger change event on page load
    checkbox.dispatchEvent(new Event('change'));
  });
  
  // Form validation
  const form = document.querySelector('.edit-form');
  form.addEventListener('submit', function(e) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        field.style.borderColor = 'var(--danger-color)';
        isValid = false;
      } else {
        field.style.borderColor = 'var(--border-color)';
      }
    });
    
    if (!isValid) {
      e.preventDefault();
      alert('Mohon lengkapi semua field yang wajib diisi!');
    }
  });
  
  // Auto-save draft (optional)
  const inputs = form.querySelectorAll('input, textarea, select');
  inputs.forEach(input => {
    input.addEventListener('input', function() {
      // Save to localStorage as draft
      const formData = new FormData(form);
      const data = {};
      for (let [key, value] of formData.entries()) {
        data[key] = value;
      }
      localStorage.setItem('edit_pegawai_draft', JSON.stringify(data));
    });
  });
});
</script>

<?php include '../inc/footer.php'; ?> 