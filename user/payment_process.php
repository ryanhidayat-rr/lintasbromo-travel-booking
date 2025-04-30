<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit;
}

include "../service/database.php"; // Koneksi ke database

// Mendapatkan ID tagihan dari URL (GET)
if (isset($_GET['id']) || isset($_POST['id'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
    $message = '';

    // Query untuk mengambil detail tagihan berdasarkan ID
    $stmt = $db->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek jika data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $service = $row['service'];
        $travel_date = $row['travel_date'];
        $num_people = $row['num_people'];
        $total_cost = $row['total_cost'];
        $payment_status = $row['payment_status'];
    } else {
        $message = "ID tagihan tidak ditemukan.";
        exit();
    }

    $stmt->close();

    // Cek jika form telah disubmit dan ada bukti pembayaran yang di-upload
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['payment_proof'])) {
        $payment_proof = $_FILES['payment_proof'];

        // Validasi jenis file dan ukuran file
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];
        $file_extension = strtolower(pathinfo($payment_proof['name'], PATHINFO_EXTENSION));

        // Cek ukuran file (batasi 5MB)
        $max_file_size = 5 * 1024 * 1024; // 5MB
        if ($payment_proof['size'] > $max_file_size) {
            $message = "File terlalu besar. Maksimal 5MB.";
        } elseif (!in_array($file_extension, $allowed_extensions)) {
            $message = "Hanya file dengan ekstensi jpg, jpeg, png, dan pdf yang diperbolehkan.";
        } else {
            // Menyimpan file yang di-upload
            $upload_dir = 'uploads/';
            $file_name = uniqid() . '.' . $file_extension;
            $upload_file = $upload_dir . $file_name;

            if (move_uploaded_file($payment_proof['tmp_name'], $upload_file)) {
                // Update status pembayaran di database menjadi "done" dan menyimpan nama file bukti pembayaran
                $stmt = $db->prepare("UPDATE bookings SET payment_status = ?, payment_proof = ? WHERE id = ?");
                $payment_status = 'done'; // Tandai pembayaran sebagai "done"
                $stmt->bind_param("ssi", $payment_status, $file_name, $id);

                if ($stmt->execute()) {
                    header("Location: payment_process.php?status=success&id=" . $id);
                    exit();
                } else {
                    $message = "Gagal mengupdate status pembayaran.";
                }
                $stmt->close();
            } else {
                $message = "Gagal mengupload bukti pembayaran.";
            }
        }
    }
} else {
    $message = "ID tagihan tidak diterima.";
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/payment_proccess.css">
    <title>Proses Pembayaran</title>
</head>
<body style="background-image: url('gambar/bg.png'); background-size: cover; background-position: center; background-attachment: fixed;">
<!-- Navbar -->
<nav class="navbar">
    <div class="logo-container">
        <img src="gambar/logo-lintasbenua.png" alt="Logo Universitas Pamulang" class="logo">
    </div>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="booking.php">Pesan sekarang</a></li>
        <li><a href="history.php">Riwayat</a></li>
        <li><a href="account.php">Akun Saya</a></li>
    </ul>
    <!-- Tombol Logout -->
    <div class="logout-container">
        <a href="logout.php" class="logout">Keluar</a>
    </div>
</nav>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
    <p class="success-message">Pembayaran Berhasil! Status pembayaran telah diperbarui.</p>
    <p class="success-message">No. tagihan: <?php echo $id; ?></p>
<?php } else { ?>
    
    <table>
    <h3 align="center">Detail tagihan Anda</h3>
        <tr><th>Nama Akun</th><td><?php echo $username; ?></td></tr>
        <tr><th>Layanan</th><td><?php echo $service; ?></td></tr>
        <tr><th>Tanggal Pengajuan</th><td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td></tr>
        <tr><th>Tanggal Pelaksanaan</th><td><?php echo date('d-m-Y', strtotime($travel_date)); ?></td></tr>
        <tr><th>Jumlah Orang</th><td><?php echo $num_people; ?></td></tr>
        <tr><th>Jumlah Tagihan</th><td>Rp. <?php echo number_format($total_cost, 0, ',', '.'); ?></td></tr>
        <tr><th>Status Pembayaran</th><td><?php echo ucfirst($payment_status); ?></td></tr>
    </table>

    <?php if ($payment_status !== 'done') { ?>
        
        <form action="payment_process.php" method="POST" enctype="multipart/form-data" align="center">
            <h3>Lakukan Pembayaran Tagihan Anda</h3>
            <p>Lakukan pembayaran melalui QRIS di bawah untuk <b>Rp. <?php echo number_format($total_cost, 0, ',', '.'); ?></b></p>
                <img src="gambar/qris.jpg" alt="QRIS Pembayaran">
            <label for="payment_proof">Unggah bukti pembayaran Anda</label>
            <input type="file" name="payment_proof" id="payment_proof" required>
            <br><br>
            <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- ID tagihan yang valid -->
            <button type="submit">Kirim bukti pembayaran</button>
        </form>
    <?php } else { ?>
        <p class="success-message">Pembayaran Selesai</p>
        <a href="history.php">Kembali ke riwayat pesanan</a>
    <?php } ?>
<?php } ?>

<!-- Tampilkan pesan jika ada -->
<?php if (!empty($message)) { ?>
    <p class="message"><?php echo $message; ?></p>
<?php } ?>

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
            <ul><li><a href="contactus.php">Kontak Kami</a></li></ul>
        </div>
    </div>
    <div class="footerBottom">
        <p>Hak Cipta &copy;2025 Dirancang oleh <span class="designer">Lintas Benua Projects</span></p>
    </div>
</footer>
</body>
</html>
