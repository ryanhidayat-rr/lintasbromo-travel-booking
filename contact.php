<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kontak</title>
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="gambar/logo-lintasbenua.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <li><a href="gallery.php">Galeri</a></li>
            <li><a href="book.php">Pemesanan</a></li>
            <li><a href="contact.php" class="active">Kontak</a></li>
        </ul>
        <div class="logout-container">
            <a href="login.php" class="logout">Masuk</a>
        </div>
    </nav>

    <!-- Konten Kontak -->
    <div class="contact-container">
        <div class="form-section">
            <h1>Hubungi Kami</h1>
            <form action="send_to_telegram.php" method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Alamat email" required>

                <label for="whatsapp">Nomor WhatsApp</label>
                <input type="text" name="whatsapp" placeholder="Contoh: 6281234567890" required>

                <label for="message">Pesan</label>
                <textarea name="message" placeholder="Tulis pesan Anda..." rows="5" required></textarea>

            <input type="submit" value="Kirim">
</form>
        </div>
        <div class="info-section">
            <h1>Info Kontak</h1>
            <div class="contact-info">
                <img src="gambar/hp-removebg-preview.png" alt="Phone Icon" class="contact-icon">
                <p><strong>Telepon:</strong> (+62) 851-6177-9591</p>
            </div>
            <div class="contact-info">
                <img src="gambar/email-removebg-preview.png" alt="Email Icon" class="contact-icon">
                <p><strong>Email:</strong> my@ryanhidayatt.com</p>
            </div>
            <div class="contact-info">
                <img src="gambar/alamat-removebg-preview.png" alt="Address Icon" class="contact-icon">
                <p><strong>Alamat:</strong> Jl. Raya jakarta bogor, Desa Kemang, Kabupaten Bogor, 16310.</p>
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
