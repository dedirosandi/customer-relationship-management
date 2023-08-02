<?php
// Definisikan kredensial database
$servername = "localhost";
$username = "dedirosandi";
$password = "Indonesia12345";
$dbname = "crm";

// Fungsi untuk membuat koneksi ke database
function createConnection()
{
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set karakter koneksi ke UTF-8
    $conn->set_charset("utf8mb4");

    return $conn;
}
