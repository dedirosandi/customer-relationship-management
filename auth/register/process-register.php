<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

require_once "../../env/connection.php"; // Sisipkan file koneksi.php
require_once "../../env/PHPMailer/src/PHPMailer.php";
require_once "../../env/PHPMailer/src/SMTP.php";
require_once "../../env/PHPMailer/src/Exception.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash the password
    $verificationCode = md5(uniqid(rand(), true)); // Generate a unique verification code

    // Simpan data pengguna ke database
    $query = "INSERT INTO tb_user (name, email, password, verification_code) VALUES ('$name', '$email', '$password', '$verificationCode')";
    if (mysqli_query($koneksi, $query)) {
        // Kirim email verifikasi menggunakan PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'mail.skiddie.id'; // Ganti dengan alamat host SMTP Anda
        $mail->Port = 465; // Ganti dengan port SMTP yang sesuai
        $mail->SMTPAuth = true;
        $mail->Username = 'verification@skiddie.id'; // Ganti dengan username SMTP Anda
        $mail->Password = 'Indonesia12345'; // Ganti dengan password SMTP Anda
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->setFrom('verification@skiddie.id', 'Your Name'); // Ganti dengan alamat email dan nama pengirim yang sesuai
        $mail->addAddress($email, $name);
        $mail->Subject = 'Verify Your Email';
        $mail->Body = "Hello $name, please click the link below to verify your email:\n";
        $mail->Body .= "http://yourdomain.com/verify.php?code=$verificationCode";

        if ($mail->send()) {
            echo "Registration successful! Check your email for verification.";
        } else {
            echo "Failed to send verification email. Please contact support.";
        }
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
