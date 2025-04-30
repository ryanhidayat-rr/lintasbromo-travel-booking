<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

include "../service/database.php"; // Menyertakan file untuk koneksi ke database

// Pastikan koneksi berhasil
if ($db === false) {
    die("Koneksi ke database gagal.");
}

// Mendapatkan username dari session
$username = $_SESSION['username'];

// Query untuk mengambil data pengguna berdasarkan username
$stmt = $db->prepare("SELECT email, profile_picture, phone_number FROM user WHERE username = ?");
if ($stmt === false) {
    die('Query gagal dijalankan: ' . $db->error);  // Menampilkan error jika query gagal dipersiapkan
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    die("Data pengguna tidak ditemukan.");
}

$email = $data['email'];
$profile_picture = $data['profile_picture']; // Foto profil pengguna
$phone_number = $data['phone_number']; // Nomor telepon pengguna

// Proses upload foto profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $target_dir = "uploads/";  // Folder tempat menyimpan foto
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi jenis file
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    $max_file_size = 5 * 1024 * 1024; // 5MB

    // Validasi ekstensi file
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "Maaf, hanya file dengan format JPG, JPEG, PNG & GIF yang diperbolehkan.";
    }
    // Validasi ukuran file
    elseif ($_FILES["profile_picture"]["size"] > $max_file_size) {
        echo "Maaf, ukuran file terlalu besar. Maksimal 5MB.";
    } else {
        // Cek apakah file sudah ada
        if (!file_exists($target_file)) {
            // Upload file
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                // Update database dengan foto profil yang baru
                $update_stmt = $db->prepare("UPDATE user SET profile_picture = ? WHERE username = ?");
                if ($update_stmt === false) {
                    die('Query update gagal dijalankan: ' . $db->error); // Menampilkan error jika update gagal
                }
                $update_stmt->bind_param("ss", basename($_FILES["profile_picture"]["name"]), $username);
                $update_stmt->execute();
                $update_stmt->close();

                // Redirect untuk memuat ulang halaman
                header("Location: account.php");
                exit();
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file Anda.";
            }
        } else {
            echo "Maaf, file sudah ada.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya</title>
    <link rel="stylesheet" href="css/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="gambar/logo-lintasbenua.png">
</head>
<body style="background-image: url('gambar/bg.png'); background-size: cover; background-position: center; background-attachment: fixed;">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="gambar/logo-lintasbenua.png" alt="Logo Universitas Pamulang" class="logo">
        </div>
        <ul>
            <li><a href="dashboard.php">Beranda</a></li>
            <li><a href="booking.php">Pesan Sekarang</a></li>
            <li><a href="history.php">Riwayat</a></li>
            <li><a href="account.php" class="active">Akun Saya</a></li>
        </ul>
        <div class="logout-container">
            <a href="logout.php" class="logout">Keluar</a>
        </div>
    </nav>

    <!-- Kontainer Akun -->
    <div class="account-container">
        <h1>Akun Saya</h1>
        
        <!-- Foto Profil -->
        <div class="profile-picture">
            <?php if ($profile_picture): ?>
                <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Foto Profil" class="profile-img">
            <?php else: ?>
                <img src="gambar/default_profile.jpg" alt="Foto Profil Default" class="profile-img">
            <?php endif; ?>
        </div>

        <!-- Informasi Akun -->
        <p>Nama Pengguna: <?php echo htmlspecialchars($username); ?></p>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <p>Nomor Telepon: <?php echo htmlspecialchars($phone_number ? $phone_number : "Belum diatur"); ?></p>

        <!-- Form Upload Foto Profil -->
        <form action="account.php" method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Unggah Foto Profil:</label>
            <input type="file" id="profile_picture" name="profile_picture" required><br><br>
            <button type="submit" name="upload_picture">Unggah Foto</button>
        </form>

        <!-- Ganti Password -->
        <form action="change_password.php" method="POST">
            <button type="submit" name="change_password">Ganti Kata Sandi</button>
        </form>

        <!-- Tombol Logout -->
        <a href="logout.php" class="logout-btn">Keluar</a>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footerContainer">
            <div class="socialIcons">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href="https://www.instagram.com/ryanhidayat.rr?igsh=emszbzVxazFtdnhs"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://x.com/Rayennrr"><i class="fa-brands fa-twitter"></i></a>
                <a href=""><i class="fa-brands fa-google-plus"></i></a>
                <a href=""><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="footerNav">
                <ul><li><a href="contactus.php">Hubungi Kami</a></li></ul>
            </div>
        </div>
        <div class="footerBottom">
            <p>Hak Cipta &copy;2025 Dirancang oleh <span class="designer">Lintas Benua Projects</span></p>
        </div>
    </footer>

</body>
</html>
