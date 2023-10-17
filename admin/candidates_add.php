<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$fullname = $_POST['fullname'];
		$position = $_POST['position'];
		$group = $_POST['group'];
		$platform = $_POST['platform'];
		$filename = $_FILES['photo']['name'];
		$file_extension = pathinfo($filename, PATHINFO_EXTENSION);

		// Validasi ekstensi file
		if(!empty($filename) && in_array($file_extension, array("jpg", "jpeg", "png"))){
			// Pindahkan file jika ekstensi valid
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);

			$sql = "INSERT INTO candidates (position_id, group_id, fullname, photo, platform) VALUES ('$position', '$group', '$fullname', '$filename', '$platform')";

			if($conn->query($sql)){
				$_SESSION['success'] = 'Candidate added successfully';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}
		else{
			$_SESSION['error'] = 'File gambar harus memiliki ekstensi .jpg, .jpeg, atau .png';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: candidates.php');
?>
