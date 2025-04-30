<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit;
}

include "../service/database.php"; 

// Cek koneksi database
if ($db->connect_error) {
    die("Koneksi database gagal: " . $db->connect_error);
}

if (isset($_POST['submit'])) {
    $username = $_SESSION['username'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $num_people = $_POST['num_people'];
    $cost = ($service == 1) ? 100000 : 180000;
    $total_cost = $cost * $num_people;

    // Cek apakah user punya booking yang masih pending
    $check = $db->prepare("SELECT * FROM bookings WHERE username = ? AND payment_status = 'none'");
    if ($check === false) {
        die("Gagal menyiapkan query: " . $db->error);
    }
    
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Anda masih memiliki booking yang belum selesai. Harap selesaikan pembayaran terlebih dahulu.";
    } else {
        // Simpan data ke database
        $stmt = $db->prepare("INSERT INTO bookings (username, service, travel_date, num_people, total_cost, payment_status) VALUES (?, ?, ?, ?, ?, 'none')");
        if ($stmt === false) {
            die("Gagal menyiapkan query: " . $db->error);  // Menampilkan pesan error jika prepare gagal
        }

        $stmt->bind_param("sssis", $username, $service, $date, $num_people, $total_cost);

        // Eksekusi query
        if (!$stmt->execute()) {
            die("Gagal mengeksekusi query: " . $stmt->error);  // Tampilkan error jika execute gagal
        }

        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan</title>
    <link rel="stylesheet" href="css/booking.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="gambar/logo-lintasbenua.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background-image: url('gambar/bg.png'); background-size: cover; background-position: center; background-attachment: fixed;">
    
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="gambar/logo-lintasbenua.png" alt="Logo Lintas Benua" class="logo">
        </div>
        <ul>
            <li><a href="dashboard.php">Beranda</a></li>
            <li><a href="booking.php" class="active">Pesan Sekarang</a></li>
            <li><a href="history.php">Riwayat</a></li>
            <li><a href="account.php">Akun Saya</a></li>
        </ul>
        <div class="logout-container">
            <a href="logout.php" class="logout">Keluar</a>
        </div>
    </nav>

    <div class="utama">
        <form action="booking.php" method="POST">
            <h2>Formulir Pemesanan</h2>
            
            <label for="service">Pilih Layanan:</label>
            <select name="service" required>
                <option value="1">Jalan-jalan biasa di Bromo (Rp. 100.000)</option>
                <option value="2">Jalan-jalan best seller di Bromo (Rp. 180.000)</option>
            </select><br>

            <label for="date">Tanggal Keberangkatan:</label>
            <input type="date" name="date" required><br>

            <label for="num_people">Jumlah Orang:</label>
            <input type="number" name="num_people" required><br>

            <button type="submit" name="submit">Pesan Sekarang</button>
        </form>
    </div>

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
                <ul>
                    <li><a href="contactus.php">Hubungi Kami</a></li>
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
            title: 'Pemesanan Gagal!',
            text: '<?php echo $error; ?>',
            confirmButtonColor: '#3085d6'
        });
    </script>
    <?php endif; ?>

    <?php if (isset($success)): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Pemesanan Berhasil!',
            text: 'Anda akan diarahkan ke halaman riwayat...',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location.href = "history.php";
        });
    </script>
    <?php endif; ?>

</body>
</html>
