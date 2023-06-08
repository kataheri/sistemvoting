<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$fullname = $_POST['fullname'];
		$position = $_POST['position'];
		$groupname = $_POST['groupname'];
		$platform = $_POST['platform'];
		$filename = $_FILES['photo']['name'];
		
		// kalau file name nya di set
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}
		// kalau file name nya kosong
		else{
			$select = "SELECT photo FROM president WHERE id = '$id'";
			$exec = $conn->query($select);
			$fetch = $exec->fetch_assoc();
			$filename = $fetch['photo'];
		}

		$sql = "UPDATE president SET fullname = '$fullname', position_id = '$position', groupname = '$groupname', platform = '$platform', photo = '$filename' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Candidate updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location: president.php');

?>