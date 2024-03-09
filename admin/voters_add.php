<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = array(); // Inisialisasi array untuk menyimpan pesan kesalahan

    // Check if the username already exists
    $checkQuery = "SELECT * FROM voters WHERE username = '$username'";
    $checkResult = $conn->query($checkQuery);

    // Validasi panjang username
    if (strlen($username) < 4) {
        $errors[] = 'Username harus memiliki minimal 4 karakter.';
    }
    // Validasi format email menggunakan ekspresi reguler
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid. Mohon gunakan alamat email yang benar.';
    } else {
        // Pengecekan domain email untuk membatasi hanya menerima dari Gmail atau Hotmail
        $allowedDomains = ['gmail.com', 'hotmail.com', 'untirta.ac.id', 'outlook.com'];
        $emailParts = explode('@', $email);
        $domain = end($emailParts);
    
        if (!in_array($domain, $allowedDomains)) {
            $errors[] = 'Hanya diperbolehkan alamat email dari gmail, hotmail, maupun outlook.';
        }
    }
    // Validasi "fullname" hanya mengandung hanya huruf dan spasi
    if (!preg_match("/^[a-zA-Z,. ]*$/", $fullname)) {
        $errors[] = 'Nama hanya mengandung hanya huruf dan spasi.';
    }
    // Validasi "username" hanya mengandung angka
    if (!preg_match("/^[0-9]*$/", $username)) {
        $errors[] = 'Username hanya mengandung hanya angka.';
    }
    // Validasi "password" tidak mengandung huruf atau angka
    if (!preg_match("/[a-zA-Z0-9]/", $password)) {
        $errors[] = 'Password hanya mengandung huruf atau angka.';
    }
    // Jika semua validasi berhasil, maka lakukan pengecekan username dan masukkan data
    if (empty($errors) && $checkResult->num_rows > 0) {
        $errors[] = 'Username/NIK sudah ada yang punya. Mohon gunakan username/NIK pribadi.';
    }

    // Jika ada pesan kesalahan, tampilkan semua pesan kesalahan
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new voter if the username is not a duplicate
        $sql = "INSERT INTO voters (username, password, fullname, email) VALUES ('$username', '$hashedPassword', '$fullname', '$email')";

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
