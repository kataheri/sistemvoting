<?php
	include 'includes/session.php';

	if (isset($_POST['edit'])) {
		$id = $_POST['id'];
		$fullname = $_POST['fullname'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
	
		// Check if the new username already exists for other voters
		$checkQuery = "SELECT * FROM voters WHERE username = '$username' AND id <> $id";
		$checkResult = $conn->query($checkQuery);
	
		// Jika semua validasi berhasil, maka lakukan pengecekan username dan masukkan data
		if ($checkResult->num_rows > 0) {
			$_SESSION['error'] = 'Username/NIK sudah ada yang punya. Mohon gunakan username/NIK pribadi.';
		else {
			$sql = "SELECT * FROM voters WHERE id = $id";
			$query = $conn->query($sql);
			$row = $query->fetch_assoc();
	
			if ($password == $row['password']) {
				$password = $row['password'];
			} else {
				$password = password_hash($password, PASSWORD_DEFAULT);
			}
	
			$sql = "UPDATE voters SET fullname = '$fullname', username = '$username', email = '$email', password = '$password' WHERE id = '$id'";
			
			if ($conn->query($sql)) {
				$_SESSION['success'] = 'Voter Berhasil Diubah';
			} else {
				$_SESSION['error'] = $conn->error;
			}
		}
	} else {
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location: voters.php');
?>
