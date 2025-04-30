<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dasbor</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="gambar/logo-lintasbenua.png">
</head>
<body style="background-image: url('gambar/bg.png'); background-size: cover; background-position: center; background-attachment: fixed;">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="gambar/logo-lintasbenua.png" alt="Logo Lintas Benua" class="logo">
        </div>
        <ul>
            <li><a href="dashboard.php" class="active">Dasbor</a></li>
            <li><a href="list_account.php">List account</a></li>
            <li><a href="history.php">Riwayat</a></li>
            <li><a href="account.php">Akun Saya</a></li>
        </ul>
        <!-- Tombol Logout -->
        <div class="logout-container">
            <a href="../logout.php" class="logout">Keluar</a>
        </div>
    </nav>

    <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Anda adalah admin <b>lintasbromo.com!</b></p>
    
    <!-- Konten tambahan bisa ditambahkan di sini -->
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
                <ul>
                    <li><a href="contactus.php">Hubungi Kami</a></li>
                </ul>
            </div>
        </div>
        <div class="footerBottom">
            <p>Hak Cipta &copy;2025 Dirancang oleh <span class="designer">Lintas Benua Projects</span></p>
        </div>
    </footer>
</body>
</html>
