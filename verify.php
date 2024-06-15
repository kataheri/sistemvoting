<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['verify'])) {
    $voter = $_POST['username'];

    // Prepare statement to prevent SQL injection
    $sql = "SELECT * FROM voters WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $voter);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        $_SESSION['error'] = 'NIK tidak terdaftar';
    } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Update voter data
        updateVoterData($conn, $username, $email, $password);
    }

    $stmt->close();
    header('Location: index.php'); // Redirect to profile page or another relevant page
}

function updateVoterData($conn, $username, $email, $password) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare statement to prevent SQL injection
    $sql = "UPDATE voters SET email = ?, password = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $hashedPassword, $username); // Corrected data type

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = 'Data berhasil diupdate';
        } else {
            $_SESSION['error'] = 'Data tidak berubah atau pengguna tidak ditemukan';
        }
    } else {
        $_SESSION['error'] = 'Gagal mengupdate data: ' . $stmt->error;
    }

    $stmt->close();
}
?>