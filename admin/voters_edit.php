<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = array();

    // Validasi panjang username (minimal 4 karakter)
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

    // Validasi nama hanya mengandung huruf dan spasi
    if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
        $errors[] = 'Nama hanya boleh mengandung huruf dan spasi.';
    }

    // Validasi username hanya mengandung huruf dan angka
    if (!preg_match("/^[0-9]*$/", $username)) {
        $errors[] = 'Username hanya boleh mengandung angka.';
    }

    // Validasi password hanya mengandung huruf dan angka
    if (!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
        $errors[] = 'Password harus mengandung huruf dan angka.';
    }

    if (empty($errors)) {
        // Check if the new username already exists for other voters
        $checkQuery = $conn->prepare("SELECT * FROM voters WHERE username = ? AND id <> ?");
        $checkQuery->bind_param("si", $username, $id);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();

        if ($checkResult->num_rows > 0) {
            $errors[] = 'Username/NIK sudah ada yang punya. Mohon gunakan username/NIK pribadi.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $updateQuery = $conn->prepare("UPDATE voters SET fullname = ?, username = ?, email = ?, password = ? WHERE id = ?");
            $updateQuery->bind_param("sssii", $fullname, $username, $email, $hashed_password, $id);

            if ($updateQuery->execute()) {
                $_SESSION['success'] = 'Voter Berhasil Diubah';
            } else {
                $errors[] = 'Gagal mengubah voter: ' . $conn->error;
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
    }
} else {
    $_SESSION['error'] = 'Isi formulir edit terlebih dahulu.';
}

header('location: voters.php');

?>