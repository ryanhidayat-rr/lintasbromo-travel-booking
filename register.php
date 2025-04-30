<?php
include "service/database.php";

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $phone_number = $_POST['phone_number']; // Mendapatkan nomor telepon dari form

    // Query untuk memeriksa apakah username sudah ada
    $stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username sudah digunakan.";
    } else {
        // Query untuk menambahkan pengguna baru termasuk nomor telepon
        $stmt = $db->prepare("INSERT INTO user (email, username, password, phone_number) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $username, $password, $phone_number); // Menambahkan parameter phone_number
        if ($stmt->execute()) {
            $success = true;
            } else {
            $error = "Pendaftaran gagal.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="gambar/logo-lintasbenua.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
</head>
<body style="background-image: url('gambar/background.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="gambar/logo-lintasbenua.png" alt="Logo Universitas Pamulang" class="logo">
        </div>
        <ul>
            <li><a href="index.php">Beranda</a></li>
            <li><a href="destinations.php">Paket Wisata</a></li>
            <li><a href="gallery.php">Galeri</a></li>
            <li><a href="book.php">Pesan</a></li>
            <li><a href="contact.php">Kontak</a></li>
        </ul>
    </nav>
    
    <div class="utama">
    <form action="register.php" method="POST">
    <h2>Daftar</h2>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="phone_number">Nomor Telepon:</label>
        <input type="text" id="phone_number" name="phone_number" required><br> <!-- Field untuk nomor telepon -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit" name="register">Daftar</button>
        <a href="login.php">Sudah punya akun? Masuk di sini!</a>
    </form>
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
                    <li><a href="book.php">Pesan</a></li>
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
        title: 'Pendaftaran Gagal!',
        text: '<?php echo $error; ?>',
        confirmButtonColor: '#d66000'
    });
</script>
<?php endif; ?>

<?php if (isset($success)): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Pendaftaran Berhasil!',
        text: 'Anda akan diarahkan ke halaman login...',
        showConfirmButton: false,
        timer: 2000
    }).then(() => {
        window.location.href = "login.php";
    });
</script>
<?php endif; ?>

<script src="script.js"></script>

</body>
</html>
