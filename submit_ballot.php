<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['vote'])){
		if(count($_POST) == 1){
			$_SESSION['error'][] = 'Please vote atleast one candidate';
		}
		else{
			$_SESSION['post'] = $_POST;
			$sql = "SELECT * FROM positions";
			$query = $conn->query($sql);
			$error = false;
			$sql_array = array();
			while($row = $query->fetch_assoc()){
				$position = slugify($row['description']);
				$pos_id = $row['id'];
				if(isset($_POST[$position])){
					if($row['max_vote'] > 1){
						if(count($_POST[$position]) > $row['max_vote']){
							$error = true;
							$_SESSION['error'][] = 'You can only choose '.$row['max_vote'].' candidates for '.$row['description'];
						}
						else{
							foreach($_POST[$position] as $key => $values){
								$sql_array[] = "INSERT INTO votes (voters_id, president_id, candidate_id, position_id) VALUES ('".$voter['id']."', '$values', '$pos_id')";
							}

						}
						
					}
					else{
						$candidate = $_POST[$position];

						// dapetin id position
						$position_id= $row['id'];

						// cari position id di tabel candidate:
						$sql = "SELECT * FROM candidates WHERE position_id = '$position_id'";
						$cmquery = $conn->query($sql);
						$affected = $conn->affected_rows;
						if($affected >0){
							$candidate_id = $candidate;
							$president_id = 0;
						}
						else{
							$president_id = $candidate;
							$candidate_id = 0;
						}
						// $candidate = $_POST[$position];
						$sql_array[] = "INSERT INTO votes (voters_id, president_id, candidate_id, position_id) VALUES ('".$voter['id']."', '$president_id', '$candidate_id', '$pos_id')";
					}

				}
				
			}

			if(!$error){
				foreach($sql_array as $sql_row){
					$conn->query($sql_row);
				}

				unset($_SESSION['post']);
				$_SESSION['success'] = 'Vote berhasil dikirim';

			}

		}

	}
	else{
		$_SESSION['error'][] = 'Select candidates to vote first';
	}

	header('location: home.php');

?>