<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "db_lintasbromo";

// Membuat koneksi ke database
$db = new mysqli($hostname, $username, $password, $database_name);

// Periksa apakah koneksi berhasil
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

/*echo "Koneksi berhasil"; // Opsional, hanya untuk memastikan koneksi berhasil*/
?>
