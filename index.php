<?php
session_start();
if(isset($_SESSION['admin'])){
    header('location: admin/home.php');
}

if(isset($_SESSION['voter'])){
    header('location: home.php');
}

if(isset($_SESSION['username'])){
    header('location: otp.php');
}
?>
<?php include 'includes/header.php'; ?>
<body style='background-image:url(dist/img/bkg.jpg); background-size:cover;' class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>SISTEM VOTING</b>
    </div>
  
    <div class="login-box-body">
        <p class="login-box-msg">Masukan akun anda untuk memulai sesi vote</p>

        <form action="login.php" method="POST">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="voter" placeholder="NIK/username" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" id="password" placeholder="Kata Sandi" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group">
                <input type="checkbox" id="showPasswordCheckbox">
                <label for="showPasswordCheckbox">Tampilkan kata sandi</label>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Masuk</button>
                </div>
                <div class="col-xs-8 text-right">
                    <a href="#verify" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>  Verifikasi</a>
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
     <?php
        if(isset($_SESSION['error'])){
            echo "
                <div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-warning'></i> Error!</h4>
                    ".$_SESSION['error']."
                </div>
            ";
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
            echo "
                <div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-check'></i> Success!</h4>
                    ".$_SESSION['success']."
                </div>
            ";
            unset($_SESSION['success']);
        }
      ?>
</div>

<?php include 'includes/verify_modal.php'?>

<?php include 'includes/scripts.php' ?>
<!-- Add the following JavaScript code -->
<script>
    const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');
    const passwordInput = document.getElementById('password');

    showPasswordCheckbox.addEventListener('change', function() {
        if (this.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });
</script>
</body>
</html>
