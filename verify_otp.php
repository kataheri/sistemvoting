<?php
include 'includes/session.php';
include 'includes/conn.php';
date_default_timezone_set("Asia/Bangkok");  

// if (isset($_POST['verify'])) {
    // $entered_otp = $_POST['otp'];
    $voter_id = $_SESSION['voter_id'];
if (isset($_POST['submitOTP'])) {
    $otp = $_POST['otp'];
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM voters WHERE username = '$username'";
    // Fetch the stored OTP and expiration time from the database
    $sql = "SELECT otp, expired_otp FROM voters WHERE id = '$voter_id'";
    $query = $conn->query($sql);
    $voter = $query->fetch_assoc();

    if (password_verify($otp, $voter['otp'])) {
        $current_time = date("Y-m-d H:i:s");

        if ($current_time <= $voter['expired_otp']) {
            // OTP is correct and not expired, save votes to the main votes table
            $sql = "INSERT INTO votes (voters_id, president_id, candidate_id, position_id)
                    SELECT voters_id, president_id, candidate_id, position_id FROM votes
                    WHERE voters_id = '$voter_id'
                    VALUES ('" . $voter['id'] . "', '$president_id', '$candidate_id', '$pos_id')";
            $conn->query($sql);
            // var_dump($sql);
            // exit();

            // Clear temporary votes and session
            // $conn->query("DELETE FROM votes WHERE voters_id = '$voter_id'");
            unset($_SESSION['otp']);
            unset($_SESSION['voter_id']);
            $_SESSION['success'] = 'Vote verified and saved successfully.';

            header('location: home.php');
            exit();
        } else {
            // OTP expired
            unset($_SESSION['error']);
            echo "<script type='text/javascript'>
            alert('Sesi telah berakhir');
            </script>";
            echo "<script type='text/javascript'>
            window.location.replace('home.php');
            </script>";
            // $_SESSION['error'] = 'OTP has expired. Please vote again.';
            // header('location: home.php');
            exit();
        }
    } else {
        // Invalid OTP
        $_SESSION['error'] = 'Invalid OTP. Please try again.';
    }
}
?>
<?php include 'includes/header.php'; ?>
<body style='background-image:url(dist/img/bkg.jpg); background-size:cover;' class="hold-transition login-page">
<div class="login-box">
  	<div class="login-box-body">
    	<p class="login-box-msg">Masukan kode OTP yang telah dikirimkan ke email anda</p>
    	<form action="" method="POST">
    	  <div class="form-group has-feedback">
            <input type="number" class="form-control" name="otp" placeholder="Kode OTP">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" class="btn btn-primary btn-block btn-flat" name="submitOTP"> Submit</button>
        		</div>
				<!-- <div class="col-xs-4 pull-right">
					<a href="logout.php" class="btn btn-primary btn-block btn-flat"><i class="fa fa-sign-out"></i> KELUAR</a>
                </div> -->
      		</div>
    	</form>
  	</div>
  	<?php
  		if(isset($_SESSION['error'])){
  			echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>".$_SESSION['error']."</p> 
			  	</div>
  			";
  			unset($_SESSION['error']);
  		}
  	?>
</div>
<?php include 'includes/scripts.php' ?>
</body>
</html>
