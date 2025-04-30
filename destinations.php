<!DOCTYPE html>
<html lang="id">
<head>
    <title>Destinasi</title>
    <link rel="stylesheet" href="css/destinations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="gambar/logo-lintasbenua.png">
</head>
<body style="background-image: url('gambar/background2.png'); background-size: cover; background-position: center; background-attachment: fixed;">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="gambar/logo-lintasbenua.png" alt="Logo Lintas Benua" class="logo">
        </div>
        <ul>
            <li><a href="index.php">Beranda</a></li>
            <li><a href="destinations.php" class="active">Paket Wisata</a></li>
            <li><a href="gallery.php">Galeri</a></li>
            <li><a href="book.php">Pemesanan</a></li>
            <li><a href="contact.php">Kontak</a></li>
        </ul>
        <!-- Tombol Login -->
        <div class="logout-container">
            <a href="login.php" class="logout">Masuk</a>
        </div>
    </nav>
    
    <!-- Beberapa Paket Wisata di Bromo -->
    <div class="info-section">
        <div class="info-text">
            <h2>Jalan-Jalan Biasa di Bromo</h2>
            <p>
                Paket ini dirancang untuk kamu yang ingin menikmati keindahan Gunung Bromo secara sederhana namun tetap berkesan. Cocok untuk wisatawan dengan waktu dan anggaran terbatas, namun tetap ingin merasakan pesona alam Bromo yang luar biasa.
            </p>
            <div class="btn-container">
                <a href="packet1.php" class="btn-paket">Detail Fasilitas</a>
                <a href="booking.php" class="btn-paket">Pesan Sekarang</a>
            </div>
        </div>
        <div class="info-image">
            <img src="gambar/p1.png" alt="Paket 1">
        </div>
    </div>

    <div class="info-section reverse">
        <div class="info-image">
            <img src="gambar/p2.png" alt="Paket 2">
        </div>
        <div class="info-text">
            <h2>Jalan-Jalan Terbaik di Bromo</h2>
            <p>
                Ini adalah paket premium favorit para wisatawan! Menawarkan pengalaman eksplorasi Bromo yang lebih lengkap, eksklusif, dan nyaman, dengan tambahan destinasi, dokumentasi profesional, serta pelayanan kelas atas. Cocok untuk kamu yang ingin mendapatkan pengalaman tak terlupakan dan hasil foto/video yang instagenic.
            </p>
            <div class="btn-container">
                <a href="packet2.php" class="btn-paket">Detail Fasilitas</a>
                <a href="booking.php" class="btn-paket">Pesan Sekarang</a>
            </div>
        </div>
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
            <p>Hak Cipta &copy;2025 Dirancang oleh <span class="designer">Ryan Hidayat</span></p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
