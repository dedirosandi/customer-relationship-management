<?php
require_once "../env/connection.php"; // Sisipkan file koneksi.php

if (isset($_GET["code"])) {
    $verificationCode = $_GET["code"];

    // Update the verification status in the database
    $sql = "UPDATE tb_user SET is_verified = 1 WHERE verification_code = '$verificationCode'";
    if (mysqli_query($koneksi, $sql)) {
        echo "Email verification successful! You can now log in.";
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
} else {
    echo "Invalid verification code.";
}
