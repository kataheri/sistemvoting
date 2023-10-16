<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    $checkQuery = "SELECT * FROM voters WHERE username = '$username'";
    $checkResult = $conn->query($checkQuery);

    // Validasi panjang username
    if (strlen($username) < 4) {
        $_SESSION['error'] = 'Username harus memiliki minimal 4 karakter.';
    }
    // Validasi format email menggunakan ekspresi reguler
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Format email tidak valid. Mohon gunakan alamat email yang benar.';
    }
    // Jika semua validasi berhasil, maka lakukan pengecekan username dan masukkan data
    elseif ($checkResult->num_rows > 0) {
        $_SESSION['error'] = 'Username/NIK sudah ada yang punya. Mohon gunakan username/NIK pribadi.';
    } else {
        // Insert the new voter if the username is not a duplicate
        $sql = "INSERT INTO voters (username, password, fullname, email) VALUES ('$username', '$password', '$fullname', '$email')";

        if ($conn->query($sql)) {
            $_SESSION['success'] = 'Voter Berhasil Ditambahkan';
        } else {
            $_SESSION['error'] = $conn->error;
        }
    }
} else {
    $_SESSION['error'] = 'Fill up add form first';
}

header('location: voters.php');
?>
