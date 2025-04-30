<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'user' && $_SESSION['role'] != 'admin')) {
    header("Location: login.php");
    exit;
}

include "../service/database.php"; // Menyertakan file untuk koneksi ke database

// Mendapatkan username dari session
$username = $_SESSION['username'];

// Query untuk admin: Menampilkan riwayat pemesanan semua pengguna
if ($_SESSION['role'] == 'admin') {
    $stmt = $db->prepare("SELECT * FROM bookings");
} else {
    // Query untuk user biasa: Menampilkan riwayat berdasarkan username
    $stmt = $db->prepare("SELECT * FROM bookings WHERE username = ?");
    $stmt->bind_param("s", $username);
}

$stmt->execute();
$result = $stmt->get_result();

// Proses perubahan status pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_payment_status'])) {
    $payment_status = $_POST['payment_status'];
    $booking_id = $_POST['booking_id'];

    // Update status pembayaran
    $update_stmt = $db->prepare("UPDATE bookings SET payment_status = ? WHERE id = ?");
    $update_stmt->bind_param("si", $payment_status, $booking_id);
    $update_stmt->execute();
    header("Location: history.php");
    exit;
}

// Proses penghapusan riwayat pemesanan
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_booking'])) {
    $booking_id = $_GET['delete_booking'];

    // Hapus pemesanan
    $delete_stmt = $db->prepare("DELETE FROM bookings WHERE id = ?");
    $delete_stmt->bind_param("i", $booking_id);
    $delete_stmt->execute();
    header("Location: history.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan</title>
    <link rel="stylesheet" href="css/history.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body style="background-image: url('gambar/bg.png'); background-size: cover; background-position: center; background-attachment: fixed;">

<!-- Navbar -->
<nav class="navbar">
    <div class="logo-container">
        <img src="gambar/logo-lintasbenua.png" alt="Logo" class="logo">
    </div>
    <ul>
        <li><a href="dashboard.php">Dasbor</a></li>
        <li><a href="booking.php">Pesan Sekarang</a></li>
        <li><a href="history.php" class="active">Riwayat</a></li>
        <li><a href="account.php">Akun Saya</a></li>
    </ul>
    <div class="logout-container">
        <a href="logout.php" class="logout">Keluar</a>
    </div>
</nav>

<h2 align="center">Riwayat Pemesanan</h2>
<table>
    <thead>
        <tr>
            <th>Username</th> <!-- Kolom Username ditempatkan paling awal -->
            <th>No Invoice</th>
            <th>Tanggal Dibuat</th>
            <th>Layanan</th>
            <th>Tanggal Pelaksanaan</th>
            <th>Jumlah Orang</th>
            <th>Jumlah Tagihan</th>
            <th>Status Pembayaran</th>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <th>Aksi</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['username']; ?> <!-- Menampilkan Username pengguna di kolom paling awal --></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($row['created_at'])); ?></td>
                <td><?php echo $row['service']; ?></td>
                <td><?php echo $row['travel_date']; ?></td>
                <td><?php echo $row['num_people']; ?></td>
                <td><?php echo $row['total_cost']; ?></td>
                <td>
                    <?php
                    // Menampilkan status pembayaran
                    if ($row['payment_status'] == 'done') {
                        echo '<span style="color: green;">Selesai</span>';
                    } elseif ($row['payment_status'] == 'failed') {
                        echo '<span style="color: red;">Gagal</span>';
                    } else {
                        echo '<span style="color: orange;">Tertunda</span>';
                    }
                    ?>
                </td>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <td>
                        <form method="POST" style="display:inline;">
                            <select name="payment_status">
                                <option value="pending" <?php if ($row['payment_status'] == 'pending') echo 'selected'; ?>>Tertunda</option>
                                <option value="done" <?php if ($row['payment_status'] == 'done') echo 'selected'; ?>>Selesai</option>
                                <option value="failed" <?php if ($row['payment_status'] == 'failed') echo 'selected'; ?>>Gagal</option>
                            </select>
                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="update_payment_status">Update</button>
                        </form>
                        <a href="history.php?delete_booking=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')">Hapus</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<p align="center"><a href="payment.php">Bayar tagihan Anda di sini</p>

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
            <ul><li><a href="contactus.php">Kontak Kami</a></li></ul>
        </div>
    </div>
    <div class="footerBottom">
        <p>Hak Cipta &copy;2025 Dirancang oleh <span class="designer">Lintas Benua Projects</span></p>
    </div>
</footer>

</body>
</html>

<?php
$stmt->close();
?>
