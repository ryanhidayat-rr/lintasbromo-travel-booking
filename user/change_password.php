<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit;
}
include "../service/database.php";

$username = $_SESSION['username'];
$alert = "";

if (isset($_POST['submit'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $stmt = $db->prepare("SELECT password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if (password_verify($old_password, $data['password'])) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 6) {
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                $stmt = $db->prepare("UPDATE user SET password = ? WHERE username = ?");
                $stmt->bind_param("ss", $hashed_new_password, $username);
                if ($stmt->execute()) {
                    $alert = "success|Berhasil!|Password Anda berhasil diubah.";
                } else {
                    $alert = "error|Gagal!|Terjadi kesalahan saat mengubah password.";
                }
                $stmt->close();
            } else {
                $alert = "warning|Oops!|Password baru minimal harus 6 karakter.";
            }
        } else {
            $alert = "warning|Oops!|Password baru dan konfirmasi tidak cocok.";
        }
    } else {
        $alert = "error|Oops!|Password lama yang Anda masukkan salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Ubah Password</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="gambar/logo-lintasbenua.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo-container">
        <img src="gambar/logo-lintasbenua.png" alt="Logo Lintas Benua" class="logo">
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

<!-- Form Ubah Password -->
<form action="change_password.php" method="POST">
    <h1>Ubah Password</h1>

    <label for="old_password">Password Lama:</label>
    <input type="password" id="old_password" name="old_password" required><br>

    <label for="new_password">Password Baru:</label>
    <input type="password" id="new_password" name="new_password" required><br>

    <label for="confirm_password">Konfirmasi Password Baru:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>

    <button type="submit" name="submit">Ubah Password</button>
    <a href="account.php">Kembali ke Akun</a>
</form>

<!-- Footer -->
<footer>
    <div class="footerContainer">
        <div class="socialIcons">
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.instagram.com/ryanhidayat.rr?igsh=emszbzVxazFtdnhs"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://x.com/Rayennrr"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-google-plus"></i></a>
            <a href="#"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <div class="footerNav">
            <ul><li><a href="contactus.php">Hubungi Kami</a></li></ul>
        </div>
    </div>
    <div class="footerBottom">
        <p>&copy; 2025 Dirancang oleh <span class="designer">Lintas Benua Projects</span></p>
    </div>
</footer>

<!-- SweetAlert -->
<?php if (!empty($alert)): 
    list($icon, $title, $message) = explode('|', $alert);
?>
<script>
Swal.fire({
    icon: '<?= $icon ?>',
    title: '<?= $title ?>',
    text: '<?= $message ?>',
    confirmButtonColor: '#3085d6'
}).then(() => {
    window.location.href = "account.php";
});
</script>
<?php endif; ?>

</body>
</html>
