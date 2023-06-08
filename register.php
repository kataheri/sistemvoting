<?php
  session_start();
  include 'includes/conn.php';
  // include 'includes/session.php';


  if(isset($_POST['add'])){
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO voters (username, password, fullname, email) VALUES ('$username', '$password', '$fullname', '$email')";
    if($conn->query($sql)){
      $_SESSION['success'] = 'Voter Berhasil Ditambahkan';
    }
    else{
      $_SESSION['error'] = $conn->error;
    }

  }
  else{
    $_SESSION['error'] = 'Fill up add form first';
  }

  header('location: index.php');
?>