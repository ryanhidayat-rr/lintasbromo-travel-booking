<?php
session_start();
include "service/database.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
    if (!$stmt) {
        die("Query gagal disiapkan: " . $db->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        if (password_verify($password, $data['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $data['role'];

            // Arahkan sesuai role
            if ($data['role'] == 'admin') {
                $redirect = 'admin/dashboard.php';
            } elseif ($data['role'] == 'kasir') {
                $redirect = 'kasir/dashboard.php';
            } else {
                $redirect = 'user/dashboard.php';
            }

            $success = true;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Akun tidak ditemukan!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Masuk</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="gambar/logo-lintasbenua.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background-image: url('gambar/background.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">

<!-- Navbar -->
<nav class="navbar">
    <div class="logo-container">
        <img src="gambar/logo-lintasbenua.png" alt="Logo" class="logo">
    </div>
    <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="destinations.php">Paket Wisata</a></li>
        <li><a href="gallery.php">Galeri</a></li>
        <li><a href="book.php">Pemesanan</a></li>
        <li><a href="contact.php">Kontak</a></li>
    </ul>
</nav>

<!-- Login Form -->
<div class="utama">
    <form action="login.php" method="POST">
        <h2>Masuk</h2>
        <label for="username">Nama Pengguna:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Kata Sandi:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit" name="login">Masuk</button>
        <a href="register.php">Belum punya akun? Daftar di sini!</a>
    </form>
</div>

<!-- Footer -->
<footer>
    <div class="footerContainer">
        <div class="socialIcons">
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.instagram.com/ryanhidayat.rr?igsh=emszbzVxazFtdnhs"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-google-plus"></i></a>
            <a href="#"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <div class="footerNav">
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="destinations.php">Paket Wisata</a></li>
                <li><a href="gallery.php">Galeri</a></li>
                <li><a href="book.php">Pemesanan</a></li>
                <li><a href="contact.php">Kontak</a></li>
            </ul>
        </div>
    </div>
    <div class="footerBottom">
        <p>Hak Cipta &copy;2025 Dirancang oleh <span class="designer">Lintas Benua Projects</span></p>
    </div>
</footer>

<!-- SweetAlert -->
<?php if (isset($error)): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Login Gagal!',
    text: '<?php echo $error; ?>',
    confirmButtonColor: '#d66000'
});
</script>
<?php endif; ?>

<?php if (isset($success)): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Login Berhasil!',
    text: 'Anda akan diarahkan ke dashboard...',
    showConfirmButton: false,
    timer: 2000
}).then(() => {
    window.location.href = "<?php echo $redirect; ?>";
});
</script>
<?php endif; ?>

</body>
</html>

