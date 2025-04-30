<?php
session_start(); // Mulai session

// Hapus semua session
session_unset();
session_destroy();

// Redirect ke halaman login setelah logout
header("Location: ../index.php?logout=true");
exit();
?>