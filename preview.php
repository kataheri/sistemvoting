<?php
	
	include 'includes/session.php';
	include 'includes/slugify.php';

	$output = array('error'=>false,'list'=>'');

	$sql = "SELECT * FROM positions";
	$query = $conn->query($sql);

	while($row = $query->fetch_assoc()){
		$position = slugify($row['description']);
		$pos_id = $row['id'];
		if(isset($_POST[$position])){
			if($row['max_vote'] > 1){
				if(count($_POST[$position]) > $row['max_vote']){
					$output['error'] = true;
					$output['message'][] = '<li>You can only choose '.$row['max_vote'].' candidates for '.$row['description'].'</li>';
				}
				else{
					foreach($_POST[$position] as $key => $values){
						$sql = "SELECT * FROM candidates WHERE id = '$values'";
						$cmquery = $conn->query($sql);
						$cmrow = $cmquery->fetch_assoc();
						$output['list'] .= "
							<div class='row votelist'>
		                      	<span class='col-sm-4'><b>".$row['description']." :</b></span></span> 
		                      	<span class='col-sm-8'>".$cmrow['fullname']."</span>
		                    </div>
						";
					}

				}
				
			}
			else{
				
				$desc = $row['description'];
				$candidate = $_POST[$position];
				// dapetin id position
				
				$position_id = $row['id'];
				
				// cari position id di tabel candidate:
				$sql = "SELECT * FROM candidates WHERE position_id = '$position_id'";
				$cmquery = $conn->query($sql);
				$affected = $conn->affected_rows;
				if($affected >0){
					$sql = "SELECT * FROM candidates WHERE id = '$candidate'";
					$csquery = $conn->query($sql);
					$csrow = $csquery->fetch_assoc();
					$output['list'] .= "
						<div class='row votelist'>
							<span class='col-sm-4'><b>".$row['description']." :</b></span> 
							<span class='col-sm-8'>".$csrow['fullname']."</span>
						</div>
					";

				}
				else{
					$sql = "SELECT * FROM president WHERE id = '$candidate'";
					$cmquery = $conn->query($sql);
					$cmrow = $cmquery->fetch_assoc();
					$output['list'] .= "
						<div class='row votelist'>
							<span class='col-sm-4'><b>".$row['description']." :</b></span> 
							<span class='col-sm-8'>".$cmrow['fullname']."</span>
						</div>
					";
				}


			}

		}
		
	}
	

	echo json_encode($output);


?>