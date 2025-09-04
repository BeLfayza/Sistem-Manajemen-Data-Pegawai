CREATE DATABASE `manajemen`;

USE manajemen;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','user') NOT NULL
);

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('admin', '0192023a7bbd73250516f069df18b500', 'admin'),
('user1', '6ad14ba9986e3615423dfca256d04e3f', 'user');

CREATE TABLE `pegawai` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `nip` VARCHAR(20) NOT NULL UNIQUE,
  `jabatan` VARCHAR(50) NOT NULL,
  `alamat` TEXT,
  `telepon` VARCHAR(15)
);

INSERT INTO `pegawai` (`nama`, `nip`, `jabatan`, `alamat`, `telepon`) VALUES
('Budi Santoso', '123456', 'Manager', 'Jl. Merdeka No.1', '08123456789'),
('Siti Aminah', '654321', 'Staff', 'Jl. Sudirman No.2', '08234567890');

CREATE TABLE `jadwal_kerja` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `pegawai_id` INT NOT NULL,
  `hari` ENUM('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_masuk` TIME NOT NULL,
  `jam_keluar` TIME NOT NULL,
  `shift` ENUM('Pagi','Siang','Malam') NOT NULL,
  FOREIGN KEY (pegawai_id) REFERENCES pegawai(id) ON DELETE CASCADE
);

INSERT INTO `jadwal_kerja` (`pegawai_id`, `hari`, `jam_masuk`, `jam_keluar`, `shift`) VALUES
(1, 'Senin', '08:00:00', '17:00:00', 'Pagi'),
(1, 'Selasa', '08:00:00', '17:00:00', 'Pagi'),
(1, 'Rabu', '08:00:00', '17:00:00', 'Pagi'),
(1, 'Kamis', '08:00:00', '17:00:00', 'Pagi'),
(1, 'Jumat', '08:00:00', '17:00:00', 'Pagi'),
(2, 'Senin', '09:00:00', '18:00:00', 'Siang'),
(2, 'Selasa', '09:00:00', '18:00:00', 'Siang'),
(2, 'Rabu', '09:00:00', '18:00:00', 'Siang'),
(2, 'Kamis', '09:00:00', '18:00:00', 'Siang'),
(2, 'Jumat', '09:00:00', '18:00:00', 'Siang'); 
