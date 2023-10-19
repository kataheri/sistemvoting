<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'libraries/phpmailer/PHPMailer.php';
require 'libraries/phpmailer/Exception.php';
require 'libraries/phpmailer/SMTP.php';

session_start();
include 'includes/conn.php';
date_default_timezone_set("Asia/Bangkok");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $query = $conn->query($sql);

    if ($query->num_rows < 1) {
        $_SESSION['error'] = 'Username tidak ditemukan atau tidak ada';
    } else {
        $row = $query->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // kalau bener
            $generate_otp = sendOTP($row['email'], $username, $conn); // Mengganti $voter dengan $username
            $_SESSION['username'] = $row['username'];
            $_SESSION['otp'] = $generate_otp;
        } else {
            $_SESSION['error'] = 'Kata sandi salah';
        }
    }
} else {
    $_SESSION['error'] = 'Input admin credentials first';
}

header('location: index.php');

function sendOTP($email, $username, $conn)
{
    // generate otp
    $generate_otp = rand(100000, 999999);
    $hash_otp = password_hash($generate_otp, PASSWORD_DEFAULT);

    // send email
    $mail = new PHPMailer(true);

    // Set up SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server address
    $mail->Port = 465; // Specify the SMTP server port
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->SMTPSecure = 'ssl';

    $mail->Username = 'heriaji72@gmail.com'; // Your SMTP username
    $mail->Password = 'rqwgzyvfwurlylef'; // Your SMTP password

    // Set up email details
    $mail->setFrom('admin@sistemvoting.com', 'Admin'); // Sender email address and name
    $mail->addAddress($email, 'name'); // Recipient email address and name
    $mail->Subject = 'OTP'; // Email subject
    $mail->Body = 'This is your OTP for admin: ' . $generate_otp; // Email body content

    // Send the email
    if ($mail->send()) {
        // echo 'Email sent successfully.';
    } else {
        echo 'Error sending email: ' . $mail->ErrorInfo;
    }

    // Time
    $selectedTime = date("Y-m-d H:i:s"); // Menambahkan tanggal untuk saat ini
    $endTime = strtotime("+1 minutes", strtotime($selectedTime));
    $expired_date = date("Y-m-d H:i:s", $endTime);

    // update to db
    $string_query = "UPDATE admin SET otp = '$hash_otp', expired_otp = '$expired_date' WHERE username = '$username'";
    $exe = $conn->query($string_query);

    return $generate_otp;
}
?>
<script type="text/javascript">
    var generate_otp = <?= $generate_otp; ?>;
    localStorage.setItem("otp", generate_otp);
    localStorage.setItem("otp_test", "tes");
</script>
