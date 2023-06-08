<?php 
	include 'includes/session.php';
	// $_POST['id']=35;
	if(isset($_POST['id'])){
		$id = $_POST['id'];	
		// $sql = "SELECT *, candidates.id AS canid, `group`.description as groupdesc, `positions`.decription AS description FROM candidates LEFT JOIN positions ON positions.id=candidates.position_id WHERE candidates.id = '$id'";
	$sql = "SELECT *, candidates.id AS canid, `gr`.description as groupdesc, `positions`.`description` as jabatan FROM candidates LEFT JOIN positions ON positions.id=candidates.position_id LEFT JOIN `group` as gr ON candidates.group_id = `gr`.id WHERE candidates.id = $id";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
// echo "hallo";	
?>