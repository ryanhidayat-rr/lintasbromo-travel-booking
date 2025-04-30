CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
id: ID unik untuk setiap pengguna.
email: Alamat email pengguna (untuk keperluan komunikasi, verifikasi, dsb).
username: Nama pengguna yang digunakan untuk login.
password: Password yang sudah di-hash menggunakan password_hash.
created_at: Waktu pembuatan akun.

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    service VARCHAR(255) NOT NULL,
    travel_date DATE NOT NULL,
    num_people INT NOT NULL,
    total_cost INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES user(username)
);
id: ID unik untuk setiap booking.
username: Mengacu pada pengguna yang melakukan pemesanan, terkait dengan tabel user.
service: Nama layanan yang dipilih (misalnya, "Jalan-jalan biasa di Bromo").
travel_date: Tanggal perjalanan yang dipilih oleh pengguna.
num_people: Jumlah orang yang ikut dalam perjalanan.
total_cost: Total biaya yang harus dibayar oleh pengguna.
created_at: Waktu pembuatan pemesanan.

CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
email: Alamat email yang dimaksud untuk mereset password.
token: Token unik yang akan digunakan untuk mereset password.
created_at: Waktu pembuatan permintaan reset password.

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price INT NOT NULL
);
id: ID unik untuk setiap layanan.
name: Nama layanan (misalnya, "Jalan-jalan biasa di Bromo").
description: Deskripsi layanan.
price: Harga untuk layanan tersebut.

CREATE TABLE user_activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    activity_type VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES user(username)
);
id: ID unik untuk setiap catatan aktivitas.
username: Nama pengguna yang melakukan aktivitas.
activity_type: Jenis aktivitas yang dilakukan (misalnya, "login", "ubah password", dsb.).
description: Deskripsi tambahan terkait aktivitas.
created_at: Waktu aktivitas dilakukan.


Relasi antar tabel:
user → bookings: Relasi antara pengguna dan riwayat pemesanan menggunakan kolom username.
user → user_activity_logs: Relasi antara pengguna dan catatan aktivitas pengguna menggunakan kolom username.
user → password_resets: Relasi antara pengguna dan reset password.
bookings → services: Relasi yang bisa ditambahkan untuk menampilkan layanan yang dipilih, namun dalam contoh ini, service disimpan sebagai string di tabel bookings dan bisa disesuaikan dengan ID layanan dari tabel services.
