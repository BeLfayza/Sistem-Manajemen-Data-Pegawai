# 📋 Sistem Manajemen Data Pegawai

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.0-purple.svg)](https://getbootstrap.com)
[![Font Awesome](https://img.shields.io/badge/Font%20Awesome-6.4.0-orange.svg)](https://fontawesome.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Mobile Friendly](https://img.shields.io/badge/Mobile-Friendly-brightgreen.svg)](https://github.com)

Sistem manajemen data pegawai yang modern dan user-friendly dengan fitur lengkap untuk mengelola informasi pegawai, jadwal kerja, dan user management. **Fully Responsive & Mobile-Optimized!** 📱

## ✨ Fitur Utama

### 👥 Manajemen Pegawai
- **CRUD Pegawai** - Tambah, edit, hapus, dan lihat data pegawai
- **Informasi Lengkap** - Nama, NIP, jabatan, alamat, dan kontak
- **Pencarian** - Fitur pencarian pegawai yang cepat dan akurat
- **Statistik** - Dashboard dengan statistik pegawai

### 📅 Jadwal Kerja
- **Jadwal Harian** - Kelola jadwal kerja untuk setiap hari
- **Multiple Shift** - Support shift Pagi, Siang, dan Malam
- **Fleksibel** - Bisa mengatur hari kerja yang berbeda untuk setiap pegawai
- **Visual Schedule** - Tampilan jadwal yang mudah dipahami

### 👤 User Management
- **Role-based Access** - Sistem role Admin dan User
- **Session Management** - Keamanan session yang baik
- **Authentication** - Sistem login yang aman

### 🎨 Modern UI/UX
- **Responsive Design** - Tampilan optimal di semua device (Desktop, Tablet, Mobile)
- **Glassmorphism** - Desain modern dengan efek kaca
- **Interactive Elements** - Animasi dan transisi yang smooth
- **Dark/Light Theme** - Tema yang nyaman untuk mata
- **Off-Canvas Sidebar** - Menu hamburger untuk mobile dengan overlay

### 📱 Mobile Features
- **Hamburger Menu** - Navigasi collapse untuk layar kecil
- **Off-Canvas Sidebar** - Sidebar slide-in dari kiri
- **Touch Friendly** - Button dan elemen yang mudah diklik
- **Optimized Grid** - Layout card yang responsive di semua ukuran layar
- **Compact Tables** - Tabel yang tidak scroll horizontal di mobile
- **No Horizontal Scroll** - Konten 100% fit di layar

## 📦 Instalasi

### Prerequisites
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web server (Apache/Nginx)
- XAMPP/LARAGON/WAMP (untuk development)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/manajemen-pegawai.git
   cd manajemen-pegawai
   ```

2. **Setup Database**
   - Import file `database.sql` ke MySQL
   - Atau jalankan query SQL yang ada di file tersebut

3. **Konfigurasi Database**
   - Edit file `inc/db.php`
   - Sesuaikan dengan konfigurasi database Anda:
   ```php
   $host = 'localhost';
   $username = 'your_username';
   $password = 'your_password';
   $database = 'manajemen_pegawai';
   ```

4. **Setup Web Server**
   - Copy folder ke web server directory
   - Atau gunakan XAMPP/LARAGON untuk development

5. **Akses Aplikasi**
   - Buka browser dan akses `http://localhost/manajemen`
   - Login dengan kredensial default (lihat bagian Default Login)

## 🔐 Default Login

Setelah instalasi, Anda bisa login dengan kredensial berikut:

### Admin
- **Username:** `admin`
- **Password:** `admin123`

### User
- **Username:** `user`
- **Password:** `user123`

> ⚠️ **Penting:** Ganti password default setelah instalasi untuk keamanan!

## 📁 Struktur Project

```
manajemen/
├── inc/                    # Include files
│   ├── auth.php           # Authentication check
│   ├── db.php             # Database connection
│   ├── header.php         # HTML head & global styles
│   ├── navbar.php         # Navigation sidebar
│   └── footer.php         # Footer & scripts
├── pegawai/               # Employee management
│   ├── list.php          # Employee list
│   ├── tambah.php        # Add employee
│   ├── edit.php          # Edit employee
│   ├── hapus.php         # Delete employee
│   └── jadwal.php        # Schedule management
├── user/                  # User management
│   ├── list.php          # User list
│   ├── tambah.php        # Add user
│   ├── edit.php          # Edit user
│   └── hapus.php         # Delete user
├── index.php             # Dashboard
├── login.php             # Login page
├── logout.php            # Logout handler
├── database.sql          # Database schema
└── README.md             # Documentation
```

## 🎯 Cara Penggunaan

### 1. Login
- Akses halaman login
- Masukkan username dan password
- Pilih role sesuai kebutuhan

### 2. Dashboard
- Lihat statistik pegawai
- Akses menu utama
- Navigasi ke fitur yang diinginkan

### 3. Manajemen Pegawai
- **Tambah Pegawai:** Klik "Tambah Pegawai" → Isi form → Simpan
- **Edit Pegawai:** Klik icon edit → Ubah data → Update
- **Hapus Pegawai:** Klik icon hapus → Konfirmasi
- **Lihat Jadwal:** Klik "Lihat Jadwal" untuk melihat jadwal kerja

### 4. Jadwal Kerja
- Pilih pegawai
- Centang hari kerja yang aktif
- Isi jam masuk, jam keluar, dan shift
- Simpan perubahan

### 5. User Management (Admin Only)
- Kelola user sistem
- Tambah/edit/hapus user
- Atur role dan permission

## 📱 Responsive Design

### Mobile First Approach
Aplikasi ini didesain dengan **mobile-first approach** menggunakan:
- **CSS Media Queries** - Breakpoint di 768px (mobile/desktop)
- **Flexbox & Grid** - Layout modern yang adaptif
- **Touch-Friendly UI** - Button dan elemen yang besar untuk touch

### Fitur Mobile

#### Hamburger Menu
- **Toggle Button** - Tombol hamburger di mobile header
- **Off-Canvas Sidebar** - Sidebar slide-in dari kiri
- **Overlay Backdrop** - Dark overlay saat sidebar terbuka
- **Smooth Animation** - Transisi 0.35s cubic-bezier
- **Auto Close** - Sidebar otomatis tutup saat klik menu atau tekan ESC

#### Responsive Components
- **Cards** - Ukuran font dan padding otomatis disesuaikan
- **Grid Layout** - Kolom otomatis menjadi 1 per baris di mobile
- **Tables** - Kolom non-essential disembunyikan di mobile
- **Buttons** - Ukuran dan font lebih kecil untuk mobile
- **Icons** - Ukuran icon dikecilkan untuk konsistensi

#### Breakpoints
```css
/* Mobile (< 768px) */
- Hamburger menu visible
- Sidebar off-canvas
- 1 kolom layout
- Compact font sizes
- Smaller padding/margin

/* Desktop (>= 768px) */
- Sidebar fixed di kiri
- Multi-column layout
- Normal font sizes
- Standard padding/margin
```

### Testing Responsiveness

1. **Browser DevTools**
   - Buka DevTools (F12)
   - Klik Device Toolbar (Ctrl+Shift+M)
   - Test di berbagai ukuran: 320px, 768px, 1024px

2. **Real Device**
   - Test di smartphone actual
   - Test landscape dan portrait orientation
   - Test dengan slow network (DevTools > Network)

3. **Browser Compatibility**
   - Chrome 90+
   - Firefox 88+
   - Safari 14+
   - Edge 90+

## 🔧 Konfigurasi

### Database Configuration
Edit file `inc/db.php` untuk mengatur koneksi database:

```php
<?php
$host = 'localhost';
$username = 'your_username';
$password = 'your_password';
$database = 'manajemen_pegawai';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

## 🐛 Troubleshooting

### Masalah Umum

**1. Database Connection Error**
- Pastikan MySQL service berjalan
- Cek konfigurasi di `inc/db.php`
- Pastikan database sudah dibuat

**2. Session Error**
- Pastikan session_start() dipanggil
- Cek konfigurasi PHP session
- Pastikan folder writable

**3. CSS/JS Tidak Load**
- Cek koneksi internet untuk CDN
- Pastikan path file benar
- Cek browser console untuk error

**4. Permission Denied**
- Pastikan folder memiliki permission yang tepat
- Cek ownership file dan folder
- Pastikan web server bisa akses file

**5. Sidebar Tidak Keluar di Mobile**
- Buka DevTools Console
- Periksa apakah ada JavaScript error
- Pastikan elemen `#hamburgerBtn` dan `#sidebarMenu` ada
- Cek apakah media query 767.98px trigger dengan benar

## 📝 CSS Structure

### File: `inc/header.php`

Semua styling ada di dalam file ini dengan struktur:

```css
/* Global Styles */
:root { --variables }
* { reset }
html, body { general }

/* Component Styles */
.sidebar { styling }
.main-content-wrapper { styling }
.card, .btn, etc { styling }

/* Responsive Media Queries */
@media (max-width: 767.98px) { mobile }
@media (min-width: 768px) { desktop }
```

### JavaScript: `inc/footer.php`

Sidebar toggle logic menggunakan vanilla JavaScript:
- Event listener pada hamburger button
- Toggle class `.active` pada sidebar
- Show/hide overlay dengan class `.show`
- Auto-close sidebar saat klik menu atau overlay
- ESC key support untuk close

```javascript
// Contoh penggunaan
document.getElementById('hamburgerBtn').addEventListener('click', () => {
  sidebar.classList.toggle('active');
});
```

---

<div align="center">
  <p>Dibuat dengan ❤️ untuk memudahkan manajemen data pegawai</p>
  <p>⭐ Jangan lupa berikan star jika project ini membantu Anda!</p>
</div>
