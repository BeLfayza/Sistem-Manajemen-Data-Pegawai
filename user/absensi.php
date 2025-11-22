<?php
// Access control + processing must happen before any HTML output
include '../inc/auth.php';
include '../inc/db.php';

// Redirect admin away from this user-only page
if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
    header('Location: /manajemen/user/absensi_list.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$pegawai_id = isset($_SESSION['user']['pegawai_id']) ? $_SESSION['user']['pegawai_id'] : null;

// Handle POST (insert) and then redirect (PRG) to avoid duplicate submission on refresh
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipe = $_POST['tipe'] === 'Pulang' ? 'Pulang' : 'Masuk';
    // waktu dikirim dari device dalam format YYYY-MM-DD HH:MM:SS
    $waktu = mysqli_real_escape_string($conn, $_POST['waktu']);

    // cari jam masuk dari jadwal_kerja berdasarkan pegawai_id dan hari ini
    $expected_masuk = '08:00:00';
    if (!empty($pegawai_id)) {
        $hari_en = date('l', strtotime($waktu));
        $map = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $hari_id = isset($map[$hari_en]) ? $map[$hari_en] : '';
        if ($hari_id) {
            $q = mysqli_query($conn, "SELECT jam_masuk FROM jadwal_kerja WHERE pegawai_id=".intval($pegawai_id)." AND hari='".mysqli_real_escape_string($conn,$hari_id)."' LIMIT 1");
            if ($r = mysqli_fetch_assoc($q)) {
                $expected_masuk = $r['jam_masuk'];
            }
        }
    }

    $time_only = date('H:i:s', strtotime($waktu));
    $status = null;
    if ($tipe === 'Masuk') {
        if ($time_only > $expected_masuk) $status = 'Terlambat'; else $status = 'Tepat Waktu';
    } elseif ($tipe === 'Pulang') {
        // cari jam keluar dari jadwal_kerja
        $expected_keluar = '17:00:00';
        if (!empty($pegawai_id)) {
            $hari_en = date('l', strtotime($waktu));
            $map = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
            $hari_id = isset($map[$hari_en]) ? $map[$hari_en] : '';
            if ($hari_id) {
                $q = mysqli_query($conn, "SELECT jam_keluar FROM jadwal_kerja WHERE pegawai_id=".intval($pegawai_id)." AND hari='".mysqli_real_escape_string($conn,$hari_id)."' LIMIT 1");
                if ($r = mysqli_fetch_assoc($q)) {
                    $expected_keluar = $r['jam_keluar'];
                }
            }
        }
        if ($time_only < $expected_keluar) $status = 'Pulang Awal'; else $status = 'Tepat Waktu';
    }

    $sql = "INSERT INTO absensi (user_id, tipe, waktu, status) VALUES (".intval($user_id).", '".mysqli_real_escape_string($conn,$tipe)."', '".mysqli_real_escape_string($conn,$waktu)."', ".($status?"'".mysqli_real_escape_string($conn,$status)."'":"NULL").")";
    if (mysqli_query($conn, $sql)) {
        // Redirect to same page with a message to prevent duplicate POST on refresh
        header('Location: absensi.php?msg=' . urlencode('Absensi berhasil disimpan. Status: ' . ($status ?? '-')));
        exit;
    } else {
        $error_msg = 'Gagal menyimpan absensi: ' . mysqli_error($conn);
        header('Location: absensi.php?msg=' . urlencode($error_msg));
        exit;
    }
}

// After processing, include header/navbar and show page
include '../inc/header.php';
include '../inc/navbar.php';

// Load history for this user
$history_q = mysqli_query($conn, "SELECT * FROM absensi WHERE user_id=".intval($user_id)." ORDER BY waktu DESC LIMIT 50");

// show message if present via GET
$message = isset($_GET['msg']) ? urldecode($_GET['msg']) : '';
?>

<div class="container mt-4">
  <h3>Halaman Absensi</h3>
  <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>

  <div class="card p-3 mb-4">
    <div class="mb-3">
      <label class="form-label">Waktu Perangkat</label>
      <div id="deviceTime" class="fw-bold fs-5">--:--:--</div>
    </div>

    <form method="post" id="absenForm">
      <div class="mb-3">
        <label class="form-label">Tipe</label>
        <select name="tipe" class="form-control" required>
          <option value="Masuk">Masuk</option>
          <option value="Pulang">Pulang</option>
        </select>
      </div>
      <input type="hidden" name="waktu" id="waktuInput">
      <button type="submit" id="absenBtn" class="btn btn-primary">Absen</button>
    </form>
  </div>

  <div class="card p-3">
    <h5>Riwayat Absensi Anda (terbaru 50)</h5>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Tipe</th>
            <th>Waktu</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; while($row = mysqli_fetch_assoc($history_q)): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['tipe']) ?></td>
            <td><?= htmlspecialchars($row['waktu']) ?></td>
            <td><?= htmlspecialchars($row['status'] ?? '-') ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
// Update device time every second. Also ensure we set the current time right before submit.
function pad(n){return n<10?('0'+n):n}
function nowString(){
  const now = new Date();
  const y = now.getFullYear();
  const m = pad(now.getMonth()+1);
  const d = pad(now.getDate());
  const hh = pad(now.getHours());
  const mm = pad(now.getMinutes());
  const ss = pad(now.getSeconds());
  return y+'-'+m+'-'+d+' '+hh+':'+mm+':'+ss;
}
function updateTime(){
  const s = nowString();
  document.getElementById('deviceTime').textContent = s;
  document.getElementById('waktuInput').value = s;
}
setInterval(updateTime, 1000);
updateTime();

const form = document.getElementById('absenForm');
form.addEventListener('submit', function(e){
  // set exact current device time right before submit to avoid stale value or race condition
  document.getElementById('waktuInput').value = nowString();
  // disable button to prevent double submit
  document.getElementById('absenBtn').disabled = true;
});
</script>

<?php include '../inc/footer.php'; ?>
