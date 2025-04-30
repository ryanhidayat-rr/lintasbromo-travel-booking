<!DOCTYPE html>
<html lang="id">
<head>
    <title>Galeri</title>
    <link rel="stylesheet" href="css/gallery.css">
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
            <li><a href="destinations.php">Paket Wisata</a></li>
            <li><a href="gallery.php" class="active">Galeri</a></li>
            <li><a href="book.php">Pemesanan</a></li>
            <li><a href="contact.php">Kontak</a></li>
        </ul>
        <!-- Tombol Masuk -->
        <div class="logout-container">
            <a href="login.php" class="logout">Masuk</a>
        </div>
    </nav>

    <!-- konten galeri di sini -->
    <div class="container">
            <div class="header">
                <img src="gambar/logo-lintasbenua.png"/>
                <h1>Lintas Bromo</h1>
                <p>Galeri bromo</p>
            </div>
            <div class="gallery">
                <img src="gambar/aldi.jpg"/>
                <img src="gambar/gambar2.png"/>
                <img src="gambar/gambar3.png"/>
                <img src="gambar/gambar4.png"/>
                <img src="gambar/budayatengger.jpg"/>
                <img src="gambar/kulinerbromo.jpg"/>
                <img src="gambar/background2.png"/>
                <img src="gambar/background.jpg"/>
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
