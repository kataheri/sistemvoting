<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['verify'])) {
    $voter = $_POST['voter'];
    $sql = "SELECT * FROM voters WHERE username = '$voter'";
    $query = $conn->query($sql);

    if ($query->num_rows < 1) {
        $_SESSION['error'] = 'NIK tidak terdaftar';
    } else {
        $_SESSION['verified_user'] = $voter;
    }
}

header('location: index.php'); // Redirect to profile page or another relevant page
?>
