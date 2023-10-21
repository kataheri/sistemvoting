<?php
include 'includes/session.php';

if(isset($_POST['add'])){
    $errors = array(); // Array untuk menyimpan pesan kesalahan

    $fullname = $_POST['fullname'];
    $position = $_POST['position'];
    $group = $_POST['group'];
    $platform = $_POST['platform'];
    $filename = $_FILES['photo']['name'];
    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

    // Validasi ekstensi file
    if (!empty($filename) && !in_array($file_extension, array("jpg", "jpeg", "png"))) {
        $errors[] = 'File gambar harus memiliki ekstensi .jpg, .jpeg, atau .png';
    }

    // Validasi fullname hanya huruf
    if (!preg_match("/^[A-Za-z,. ]*$/", $fullname)) {
        $errors[] = 'Nama hanya menggunakan huruf dan spasi!';
    }

    // Validasi jika position dan group harus ada
    if (empty($position) || empty($group)) {
        $errors[] = 'Position and Group fields are required.';
    }

    if (empty($errors)) {
        // Jika tidak ada pesan kesalahan, lanjutkan dengan pengolahan data
        move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);

        $sql = "INSERT INTO candidates (position_id, group_id, fullname, photo, platform) 
                VALUES ('$position', '$group', '$fullname', '$filename', '$platform')";

        if($conn->query($sql)){
            $_SESSION['success'] = 'Candidate added successfully';
        }
        else{
            $_SESSION['error'] = $conn->error;
        }
    } else {
        // Jika ada pesan kesalahan, simpan semua pesan kesalahan dalam $_SESSION['error']
        $_SESSION['error'] = implode("<br>", $errors);
    }
}
else{
    $_SESSION['error'] = 'Fill up add form first';
}

header('location: candidates.php');
?>
