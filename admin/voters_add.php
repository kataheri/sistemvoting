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
	
		if ($checkResult->num_rows > 0) {
			$_SESSION['error'] = 'Username/NIK sudah ada yg punya. mohon gunakan username/NIK pribadi.';
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
