<?php 
	include 'includes/session.php';
	if(isset($_POST['id'])){
		$id = $_POST['id'];	
        $sql = "SELECT *, president.id AS presid, `positions`.`description` as jabatan 
        FROM president 
        LEFT JOIN positions ON positions.id=president.position_id 
        WHERE president.id = $id";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>