<?php
require_once "../../env/connection.php"; // Sisipkan file koneksi.php
require_once "../../env/PHPMailer/src/PHPMailer.php";
require_once "../../env/PHPMailer/src/SMTP.php";
require_once "../../env/PHPMailer/src/Exception.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash the password
    $verificationCode = md5(uniqid(rand(), true)); // Generate a unique verification code

    // Cek apakah email sudah terdaftar di database
    $query_check_email = "SELECT * FROM tb_user WHERE email = '$email'";
    $result_check_email = mysqli_query($koneksi, $query_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // Jika email sudah terdaftar, arahkan ke halaman login
        header("Location: https://crm.skiddie-demo.com/login/");
        exit;
    }

    // Simpan data pengguna ke database
    $query = "INSERT INTO tb_user (name, email, password, verification_code) VALUES ('$name', '$email', '$password', '$verificationCode')";
    if (mysqli_query($koneksi, $query)) {
        // Kirim email verifikasi menggunakan PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Ganti dengan alamat host SMTP Anda
        $mail->Port = 587; // Ganti dengan port SMTP yang sesuai
        $mail->SMTPAuth = true;
        $mail->Username = 'skiddie.id@gmail.com'; // Ganti dengan username SMTP Anda
        $mail->Password = 'zbjewozgaszkvjno'; // Ganti dengan password SMTP Anda
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->setFrom('verification@skiddie.id', 'Your Name'); // Ganti dengan alamat email dan nama pengirim yang sesuai
        $mail->addAddress($email, $name);
        $mail->Subject = 'Verify Your Email';
        $mail->Body = "Hello $name, please click the link below to verify your email:\n";
        $mail->Body .= "https://crm.skiddie-demo.com/verify/?code=$verificationCode";

        if ($mail->send()) {
            echo "Registration successful! Check your email for verification.";
        } else {
            echo "Failed to send verification email. Please contact support.";
        }
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
