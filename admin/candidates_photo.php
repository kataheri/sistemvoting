<?php
include 'includes/session.php';

if (isset($_POST['upload'])) {
    $id = $_POST['id'];
    $filename = $_FILES['photo']['name'];
    $fileTmpPath = $_FILES['photo']['tmp_name'];

    // Validate file type on the server side
    $allowedExtensions = array('jpg', 'jpeg', 'png');
    $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['error'] = 'Only JPG, JPEG, and PNG files are allowed.';
        header('location: candidates.php');
        exit;
    }

    // If the file type is valid, move the uploaded file to the target directory
    $uploadDirectory = '../images/';
    $targetFilePath = $uploadDirectory . $filename;

    if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
        // Update the photo field in the database
        $sql = "UPDATE candidates SET photo = '$filename' WHERE id = '$id'";
        if ($conn->query($sql)) {
            $_SESSION['success'] = 'Photo updated successfully';
        } else {
            $_SESSION['error'] = $conn->error;
        }
    } else {
        $_SESSION['error'] = 'Error uploading the file.';
    }
} else {
    $_SESSION['error'] = 'Select a candidate to update the photo first';
}

header('location: candidates.php');
exit;
?>
