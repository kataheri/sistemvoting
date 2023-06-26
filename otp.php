<?php

      session_start();
  	include 'includes/conn.php';
      date_default_timezone_set("Asia/Bangkok");      

      // $timeout = 1; // setting timeout dalam menit
      // $logout = "index.php"; // redirect halaman logout

      // $timeout = $timeout * 10; // menit ke detik
      // if(isset($_SESSION['start_session'])){
      //       $elapsed_time = time()-$_SESSION['start_session'];
      //       if($elapsed_time >= $timeout){
      //             session_destroy();
      //             $_SESSION['error'] = "Sesi telah berakhir";
      //             echo "<script type='text/javascript'>
      //             alert('Sesi telah berakhir');
      //             setInterval(window.location='$logout',1000)
      //            </script>
      //             ";
                  

      //       }
      // }

      // $_SESSION['start_session']=time();

  	 if(isset($_SESSION['voter'])){
      header('location: home.php');
    }
    
    if(!isset($_SESSION['username'])){
    	header('location: index.php');
    }
    
	echo $_SESSION['otp'];

    //logic mengecek OTP
    if (isset($_POST['submitOTP'])) {
    	$logout = "index.php";
    	$otp = $_POST['otp'];
    	$username = $_SESSION['username'];
    	$sql = "SELECT * FROM voters WHERE username = '$username'";
    	$exec = $conn->query($sql);
    	$row = $exec->fetch_assoc();
    	$dateNow = date("Y-m-d H:i:s");
    	
    		// check if expired or not
            // valid
    		if ($dateNow < $row['expired_otp']) {
                  if(password_verify($otp, $row['otp'])){
          			$_SESSION['voter'] = $row['id'];
          			header('location: home.php');
          			echo $_SESSION['voter'];
                  }
                   else{
                        $_SESSION['error']= 'OTP salah';
                  }
    		}
            // expired
    		else{
                  unset($_SESSION['username']);
                  echo "<script type='text/javascript'>
                  alert('Sesi telah berakhir');
                 </script>";
                 echo "<script type='text/javascript'>
                  window.location.replace('index.php');
                 </script>";
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