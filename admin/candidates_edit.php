<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $position = $_POST['position'];
    $group = $_POST['group'];
    $platform = $_POST['platform'];

    // Mengambil informasi tentang file yang diunggah
    $filename = $_FILES['photo']['name'];
    $filetmp = $_FILES['photo']['tmp_name'];
    $filetype = $_FILES['photo']['type'];

    // Membuat array yang berisi ekstensi file yang diizinkan
    $allowed_extensions = array("jpg", "jpeg", "png");

    $errors = array(); // Array untuk menyimpan pesan kesalahan

    // Memeriksa apakah file yang diunggah adalah gambar dengan ekstensi yang diizinkan
    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
    if (!empty($filename) && !in_array(strtolower($file_extension), $allowed_extensions)) {
        $errors[] = 'Hanya file JPG, JPEG, dan PNG yang diizinkan';
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
        if (!empty($filename)) {
            move_uploaded_file($filetmp, '../images/' . $filename);
        } else {
            // Jika file name kosong, gunakan gambar yang ada (lalu cek jika gambar yang ada ada di database)
            $select = "SELECT photo FROM candidates WHERE id = '$id'";
            $exec = $conn->query($select);
            if ($exec) {
                $fetch = $exec->fetch_assoc();
                if ($fetch) {
                    $filename = $fetch['photo'];
                } else {
                    $errors[] = 'Data not found for the given ID';
                }
            } else {
                $errors[] = $conn->error;
            }
        }

        if (empty($errors)) {
            $sql = "UPDATE candidates SET fullname = '$fullname', position_id = '$position', group_id = '$group', platform = '$platform', photo = '$filename' WHERE id = '$id'";
            if ($conn->query($sql)) {
                $_SESSION['success'] = 'Candidate updated successfully';
            } else {
                $_SESSION['error'] = $conn->error;
            }
        } else {
            $_SESSION['error'] = implode("<br>", $errors);
        }
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
} else {
    $_SESSION['error'] = 'Fill up edit form first';
}

header('location: candidates.php');
?>
