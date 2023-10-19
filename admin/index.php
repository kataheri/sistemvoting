<?php
  	session_start();
  	if(isset($_SESSION['admin'])){
    	header('location:home.php');
  	}
	
	if(isset($_SESSION['username'])){
    header('location: otp.php');
	}
?>
<?php include 'includes/header.php'; ?>
<body style="background-image:url(../dist/img/bkg1.jpeg); background-size:cover;" class="hold-transition login-page">
<div class="login-box">
  	<div class="login-logo">
  		<b style="color:white">SISTEM VOTING</b>
  	</div>
  
  	<div class="login-box-body">
    	<p class="login-box-msg">Masukan akun untuk memulai sesi admin</p>

    	<form action="login.php" method="POST">
      		<div class="form-group has-feedback">
        		<input type="text" class="form-control" name="username" placeholder="Nama pengguna" required>
        		<span class="glyphicon glyphicon-user form-control-feedback"></span>
      		</div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Kata Sandi" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" class="btn btn-primary btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Masuk</button>
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