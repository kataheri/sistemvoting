<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$fullname = $_POST['fullname'];
		$position = $_POST['position'];
		$platform = $_POST['platform'];
		$filename = $_FILES['photo']['name'];
		$file_extension = pathinfo($filename, PATHINFO_EXTENSION);

		// Validasi ekstensi file
		if(!empty($filename) && in_array($file_extension, array("jpg", "jpeg", "png"))){
			// Pindahkan file jika ekstensi valid
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);

			$sql = "INSERT INTO president (position_id, fullname, photo, platform) 
			        VALUES ('$position', '$fullname', '$filename', '$platform')";

			if($conn->query($sql)){
				$_SESSION['success'] = 'president added successfully';
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

	header('location: president.php');
?>
