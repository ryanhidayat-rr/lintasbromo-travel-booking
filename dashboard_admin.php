<?php
session_start();
include "service/database.php";

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Jika bukan admin, redirect ke login
    exit();
}

// Ambil data pesanan dari seluruh pengguna
$stmt = $db->prepare("SELECT * FROM bookings INNER JOIN user ON bookings.user_id = user.id");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard_admin.css">
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="admin_orders.php" class="active">All Orders</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <h1>All Orders</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Layanan</th>
                <th>Tanggal</th>
                <th>Jumlah Orang</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['service']); ?></td>
                    <td><?php echo htmlspecialchars($row['travel_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['num_people']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_cost']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
