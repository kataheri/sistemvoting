<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'libraries/phpmailer/PHPMailer.php';
	require 'libraries/phpmailer/Exception.php';
	require 'libraries/phpmailer/SMTP.php';



	session_start();
	include 'includes/conn.php';
	date_default_timezone_set("Asia/Bangkok");	
	if(isset($_POST['login'])){
		$voter = $_POST['voter'];
		$password = $_POST['password'];
		
		$sql = "SELECT * FROM voters WHERE username = '$voter'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Username salah';
			
		}
		else{
			$row = $query->fetch_assoc();
			if(password_verify($password, $row['password'])){
				// kalau bener
				$generate_otp = sendOTP($row['email'], $voter, $conn);
				$_SESSION['username'] = $row['username'];
				$_SESSION['otp'] = $generate_otp;

			}
			else{
				
				$_SESSION['error'] = 'Kata sandi salah';
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Input voter credentials first';
	}

	header('location: index.php');

?>
<?php
function sendOTP($email, $voter, $conn){
		//generate otp
		$generate_otp = rand(100000,999999);

		// send email
		$to = $email;
		$subject = "My subject";
		$txt = "Hello world!";
		$headers = "From: felix.swift916@gmail.com";
		error_reporting(E_ALL|E_STRICT);
		ini_set('display_errors', 1);
		$email = mail($to,$subject,$txt,$headers);
		$hash_otp = password_hash($generate_otp, PASSWORD_DEFAULT);
		$date = date("Y-m-d H:i:s");

		//Time
		$selectedTime = date("H:i:s");
		$endTime = strtotime("+5 minutes", strtotime($selectedTime));
		$expired_date =  date("Y-m-d H:i:s", $endTime);

		//update to db
		$string_query = "UPDATE voters SET otp = '$hash_otp',
		expired_otp = '$expired_date'
		 WHERE username = '$voter'";
		 $exe = $conn->query($string_query);

		 return $generate_otp;
}

?>

<script type="text/javascript">
	localStorage.setItem("otp", <?= $generate_otp;?>);
	localStorage.setItem("otp", "tes");

</script>