<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'libraries/phpmailer/PHPMailer.php';
require 'libraries/phpmailer/Exception.php';
require 'libraries/phpmailer/SMTP.php';
include 'includes/session.php';
include 'includes/slugify.php';
include 'includes/conn.php';
date_default_timezone_set("Asia/Bangkok");    

if (isset($_POST['vote'])) {
    $selectedCandidates = $_POST;
    unset($selectedCandidates['vote']); // Hapus elemen 'vote' dari array $_POST

    $error = false;
    $sql_array = array();

    $sql = "SELECT * FROM positions";
    $query = $conn->query($sql);

    while ($row = $query->fetch_assoc()) {
        $position = slugify($row['description']);
        $pos_id = $row['id'];

        if (!isset($selectedCandidates[$position])) {
            $_SESSION['error']['mohon'] = 'Mohon isi setiap jabatan'; // Notifikasi ini harus berada di atas notifikasi berikutnya
            $_SESSION['error'][] = 'Select candidates for ' . $row['description'];
            $error = true;
        } else {
            if ($row['max_vote'] > 1) {
                if (count($selectedCandidates[$position]) > $row['max_vote']) {
                    $_SESSION['error'][] = 'You can only choose ' . $row['max_vote'] . ' candidates for ' . $row['description'];
                    $error = true;
                } else {
                    foreach ($selectedCandidates[$position] as $key => $values) {
                        $sql_array[] = "INSERT INTO votes (voters_id, president_id, candidate_id, position_id) VALUES ('" . $voter['id'] . "', '$values', '$pos_id')";
                    }
                }
            } else {
                $candidate = $selectedCandidates[$position];

                // Dapatkan id position
                $position_id = $row['id'];

                // Cari position id di tabel candidate:
                $sql = "SELECT * FROM candidates WHERE position_id = '$position_id'";
                $cmquery = $conn->query($sql);
                $affected = $conn->affected_rows;

                if ($affected > 0) {
                    $candidate_id = $candidate;
                    $president_id = 0;
                } else {
                    $president_id = $candidate;
                    $candidate_id = 0;
                }

                $sql_array[] = "INSERT INTO votes_temp (voters_id, president_id, candidate_id, position_id) VALUES ('" . $voter['id'] . "', '$president_id', '$candidate_id', '$pos_id')";
            }
        }
    }

    if (!$error) {
        foreach ($sql_array as $sql_row) {
            $conn->query($sql_row);
        }

        // Generate and send OTP
        $voterEmail = $voter['email'];
        $otp = sendOTP($voterEmail, $voter['username'], $conn);

        // Store the generated OTP in session for verification
        $_SESSION['otp'] = $otp;
        $_SESSION['voter_id'] = $voter['id'];
        $_SESSION['success'] = 'Vote submitted. Please check your email for OTP verification.';

        header('location: verify_otp.php');
        exit();
    }
} else {
    $_SESSION['error'][] = 'Select candidates to vote first';
}

header('location: home.php');
?>

<?php
function sendOTP($email, $voter, $conn){
        //generate otp
        $generate_otp = rand(100000,999999);
        $hash_otp = password_hash($generate_otp, PASSWORD_DEFAULT);

        // send email
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        // Set up SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server address
        $mail->Port = 465;  // Specify the SMTP server port
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->SMTPSecure = 'ssl';

        $mail->Username = 'felix.swift916@gmail.com'; // Your SMTP username
        $mail->Password = 'refikrxllfmsimzc'; // Your SMTP password

        // Set up email details
        $mail->setFrom('admin@sistemvoting.com', 'Admin');  // Sender email address and name
        $mail->addAddress($email, 'name');  // Recipient email address and name
        $mail->Subject = 'OTP';  // Email subject
        $mail->Body = 'This is your OTP : ' . $generate_otp;  // Email body content

        // Send the email
        if ($mail->send()) {
            // echo 'Email sent successfully.';
        } else {
            echo 'Error sending email: ' . $mail->ErrorInfo;
        }

        //Time
        $selectedTime = date("H:i:s");
        $endTime = strtotime("+3 minutes", strtotime($selectedTime));
        $expired_date =  date("Y-m-d H:i:s", $endTime);

        //update to db
        $string_query = "UPDATE voters SET otp = '$hash_otp',
        expired_otp = '$expired_date'
         WHERE username = '$voter'";
         $exe = $conn->query($string_query);
         return $generate_otp;
}
?>
