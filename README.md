# 📋 Sistem Manajemen Data Pegawai

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.0-purple.svg)](https://getbootstrap.com)
[![Font Awesome](https://img.shields.io/badge/Font%20Awesome-6.4.0-orange.svg)](https://fontawesome.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Sistem manajemen data pegawai yang modern dan user-friendly dengan fitur lengkap untuk mengelola informasi pegawai, jadwal kerja, dan user management.

## Progres 50%

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
- **Responsive Design** - Tampilan optimal di semua device
- **Glassmorphism** - Desain modern dengan efek kaca
- **Interactive Elements** - Animasi dan transisi yang smooth
- **Dark/Light Theme** - Tema yang nyaman untuk mata

## 🚀 Teknologi yang Digunakan

### Backend
- **PHP 7.4+** - Server-side programming
- **MySQL** - Database management
- **Session Management** - User authentication
- **SQL Injection Protection** - Keamanan database

### Frontend
- **Bootstrap 5.3.0** - CSS Framework
- **Font Awesome 6.4.0** - Icon library
- **Custom CSS** - Styling modern dengan CSS variables
- **Vanilla JavaScript** - Interactive functionality

### Design Features
- **CSS Grid & Flexbox** - Modern layout system
- **CSS Variables** - Consistent theming
- **Smooth Animations** - Enhanced user experience
- **Mobile-first** - Responsive design approach

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

### Security Settings
- Ubah password default setelah instalasi
- Gunakan HTTPS untuk production
- Regular backup database
- Update PHP dan MySQL secara berkala

## 🎨 Customization

### Mengubah Tema Warna
Edit CSS variables di `inc/header.php`:

```css
:root {
  --primary-color: #4f46e5;    /* Warna utama */
  --primary-dark: #3730a3;     /* Warna utama gelap */
  --success-color: #10b981;    /* Warna sukses */
  --warning-color: #f59e0b;    /* Warna peringatan */
  --danger-color: #ef4444;     /* Warna bahaya */
  --info-color: #06b6d4;       /* Warna info */
}
```

### Menambah Field Pegawai
1. Edit database schema di `database.sql`
2. Update form di `pegawai/tambah.php` dan `pegawai/edit.php`
3. Update query di `pegawai/list.php`

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

## 🤝 Contributing

Kontribusi sangat diterima! Silakan ikuti langkah berikut:

1. Fork repository ini
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### Guidelines
- Ikuti coding standard PHP
- Tambahkan komentar untuk kode yang kompleks
- Test fitur baru sebelum submit
- Update dokumentasi jika diperlukan

## 📝 Changelog

### Version 1.0.0 (Current)
- ✅ Sistem CRUD pegawai lengkap
- ✅ Manajemen jadwal kerja
- ✅ User management dengan role
- ✅ Modern UI/UX design
- ✅ Responsive layout
- ✅ Security features

### Planned Features
- 📊 Dashboard analytics
- 📧 Email notifications
- 📱 Mobile app
- 🔄 Data import/export
- 📈 Reporting system

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

## 👨‍💻 Author

**Your Name**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com
- LinkedIn: [Your LinkedIn](https://linkedin.com/in/yourprofile)

## 🙏 Acknowledgments

- [Bootstrap](https://getbootstrap.com) - CSS Framework
- [Font Awesome](https://fontawesome.com) - Icons
- [PHP](https://php.net) - Programming Language
- [MySQL](https://mysql.com) - Database

## 📞 Support

Jika Anda mengalami masalah atau memiliki pertanyaan:

- 📧 Email: support@example.com
- 🐛 Issues: [GitHub Issues](https://github.com/username/manajemen-pegawai/issues)
- 💬 Discussions: [GitHub Discussions](https://github.com/username/manajemen-pegawai/discussions)

---

<div align="center">
  <p>Dibuat dengan ❤️ untuk memudahkan manajemen data pegawai</p>
  <p>⭐ Jangan lupa berikan star jika project ini membantu Anda!</p>
</div>
