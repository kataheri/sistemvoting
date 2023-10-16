<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$fullname = $_POST['fullname'];
		$position = $_POST['position'];
		$platform = $_POST['platform'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}

		$sql = "INSERT INTO president (position_id, fullname, photo, platform) 
        VALUES ('$position', '$fullname','$filename', '$platform')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'president added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: president.php');
?>