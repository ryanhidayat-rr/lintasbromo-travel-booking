<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

include "../service/database.php";

// Proses form update akun
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['user_id'];

    if (isset($_POST['update_user'])) {
        $email = $_POST['email'];
        $phone = $_POST['phone_number'];
        $role = $_POST['role'];

        $stmt = $db->prepare("UPDATE user SET email = ?, phone_number = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $email, $phone, $role, $id);
        $stmt->execute();
    }

    if (isset($_POST['reset_password'])) {
        $new_password = password_hash("lintasbromo1234", PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE user SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_password, $id);
        $stmt->execute();
    }

    header("Location: list_account.php");
    exit;
}

// Ambil semua data user
$result = $db->query("SELECT id, username, email, phone_number, role FROM user");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Pengguna</title>
    <link rel="stylesheet" href="css/list_account.css">
    <style>
        body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #f0f4f7, #e3eaf2);
    margin: 0;
    padding: 20px;
    min-height: 100vh;
}


        .navbar {
    background-color: #333;
    color: white;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar .logo-container .logo {
    height: 50px;
}

.navbar ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.navbar ul li {
    margin: 0 10px;
}

.navbar ul li a {
    text-decoration: none;
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    transition: background 0.3s;
}

.navbar ul li a.active,
.navbar ul li a:hover {
    background-color: #555;
}

.logout-container .logout {
    text-decoration: none;
    color: white;
    background-color: #ff6347;
    padding: 8px 16px;
    border-radius: 4px;
    transition: background 0.3s;
}

.logout-container .logout:hover {
    background-color: #e5533d;
}

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container {
            text-align: right;
            margin-bottom: 10px;
        }

        .search-container input {
            padding: 8px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #0066cc;
            color: white;
        }

        td input, td select {
            width: 90%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            margin: 3px;
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[name="update_user"] {
            background-color: #28a745;
            color: white;
        }

        button[name="reset_password"] {
            background-color: #dc3545;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar">
    <div class="logo-container">
        <img src="gambar/logo-lintasbenua.png" alt="Logo" class="logo">
    </div>
    <ul>
        <li><a href="dashboard.php">Beranda</a></li>
        <li><a href="list_account.php" class="active">List akun</a></li>
        <li><a href="history.php">History</a></li>
        <li><a href="account.php">Akun saya</a></li>
    </ul>
    <div class="logout-container">
        <a href="login.php" class="logout">Masuk</a>
    </div>
</nav>

<h2>Daftar Akun Pengguna</h2>

<div class="search-container">
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Cari pengguna...">
</div>

<table id="userTable">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>No WhatsApp</th>
            <th>Hak Akses</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="POST">
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"></td>
                <td><input type="text" name="phone_number" value="<?php echo htmlspecialchars($row['phone_number']); ?>"></td>
                <td>
                    <select name="role">
                        <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="kasir" <?php if ($row['role'] == 'kasir') echo 'selected'; ?>>Cashier</option>
                        <option value="user" <?php if ($row['role'] == 'user') echo 'selected'; ?>>User</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="update_user">Update</button>
                    <button type="submit" name="reset_password" onclick="return confirm('Reset password ke lintasbromo1234?')">Reset Password</button>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script>
// Fungsi pencarian tabel
function searchTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll("#userTable tbody tr");

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
}
</script>

</body>
</html>
