<?php
require_once "../../env/connection.php"; // Sisipkan file koneksi.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash the password
    $verificationCode = md5(uniqid(rand(), true)); // Generate a unique verification code

    // Simpan data pengguna ke database
    $query = "INSERT INTO tb_user (name, email, password, verification_code) VALUES ('$name', '$email', '$password', '$verificationCode')";
    if (mysqli_query($koneksi, $query)) {
        // Kirim email verifikasi
        $subject = "Verify Your Email";
        $message = "Hello $name, please click the link below to verify your email:\n";
        $message .= "http://yourdomain.com/verify.php?code=$verificationCode";
        $headers = "From: dedi.rosandi@skiddie.com"; // Ganti dengan alamat email yang sesuai

        if (mail($email, $subject, $message, $headers)) {
            echo "Registration successful! Check your email for verification.";
        } else {
            echo "Failed to send verification email. Please contact support.";
        }
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
