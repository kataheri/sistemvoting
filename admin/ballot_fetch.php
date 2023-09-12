<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	$sql = "SELECT * FROM positions";
	$pquery = $conn->query($sql);

	$output = '';
	$candidate = '';
	$presiden = '';

	$sql = "SELECT * FROM positions ORDER BY priority ASC";
	$query = $conn->query($sql);
	$num = 1;
	while($row = $query->fetch_assoc()){
		$input = ($row['max_vote'] > 1) ? '<input type="checkbox" class="flat-red '.slugify($row['description']).'" name="'.slugify($row['description'])."[]".'">' : '<input type="radio" class="flat-red '.slugify($row['description']).'" name="'.slugify($row['description']).'">';

		$sqlpresident = "SELECT * FROM president WHERE position_id=" . $row['id'];
		$sql = "SELECT * FROM candidates WHERE position_id=" . $row['id'];
		$cquery = $conn->query($sql);
		$dquery = $conn->query($sqlpresident);
		while($crow = $dquery->fetch_assoc()){
			$image = (!empty($crow['photo'])) ? '../images/'.$crow['photo'] : '../images/profile.jpg';
			$presiden .= '
				<li>
					'.$input.'<button class="btn btn-primary btn-sm btn-flat clist"><i class="fa fa-search"></i> Platform</button><img src="'.$image.'" height="100px" width="100px" class="clist"><span class="cname clist">'.$crow['fullname'].'</span>
				</li>
			';
		}
		while($crow = $cquery->fetch_assoc()){
			$image = (!empty($crow['photo'])) ? '../images/'.$crow['photo'] : '../images/profile.jpg';
			$candidate .= '
				<li>
					'.$input.'<button class="btn btn-primary btn-sm btn-flat clist"><i class="fa fa-search"></i> Platform</button><img src="'.$image.'" height="100px" width="100px" class="clist"><span class="cname clist">'.$crow['fullname'].'</span>
				</li>
			';
		}

		$instruct = ($row['max_vote'] > 1) ? 'Kamu dapat memilih sampai '.$row['max_vote'].' kandidat' : 'hanya dapat memilih satu kandidat';
		
		$updisable = ($row['priority'] == 1) ? 'disabled' : '';
		$downdisable = ($row['priority'] == $pquery->num_rows) ? 'disabled' : '';

		$output .= '
		<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid" id="'.$row['id'].'">
				<div class="box-header with-border">
					<h3 class="box-title"><b>'.$row['description'].'</b></h3>
				</div>
				<div class="box-body">
					<p>'.$instruct.'
						<span class="pull-right">
							<button type="button" class="btn btn-success btn-sm btn-flat reset" data-desc="'.slugify($row['description']).'"><i class="fa fa-refresh"></i> Reset</button>
						</span>
					</p>
					<div id="candidate_list">
						<ul>
							'.$candidate.'
							'.$presiden.'
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
		';

		$sql = "UPDATE positions SET priority = '$num' WHERE id = '".$row['id']."'";
		$conn->query($sql);

		$num++;
		$candidate = '';
		$presiden = '';
	}

	echo json_encode($output);

?>