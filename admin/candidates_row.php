<?php 
	include 'includes/session.php';
	if(isset($_POST['id'])){
		$id = $_POST['id'];	
		$sql = "SELECT *, candidates.id AS canid, `gr`.description as groupdesc, `positions`.`description` as jabatan FROM candidates LEFT JOIN positions ON positions.id=candidates.position_id LEFT JOIN `group` as gr ON candidates.group_id = `gr`.id WHERE candidates.id = $id";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>