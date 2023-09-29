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
	// require 'libraries/phpmailer/PHPMailer.php';


	if(isset($_POST['login'])){
		$voter = $_POST['voter'];
		$password = $_POST['password'];
		
		$sql = "SELECT * FROM voters WHERE username = '$voter'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Username tidak terdaftar';
			
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
		$hash_otp = password_hash($generate_otp, PASSWORD_DEFAULT);

		// send email
		// Create a new PHPMailer instance
		// $mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail = new PHPMailer(true);

		// Set up SMTP configuration
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';  // Specify your SMTP server address
		$mail->Port = 465;  // Specify the SMTP server port
		$mail->SMTPAuth = true;  // Enable SMTP authentication
		$mail->SMTPSecure = 'ssl';

		$mail->Username = 'heriaji72@gmail.com';  // Your SMTP username
		$mail->Password = 'rqwgzyvfwurlylef';  // Your SMTP password

		// Set up email details
		$mail->setFrom('admin@sistemvoting.com', 'Admin');  // Sender email address and name
		$mail->addAddress($email, 'name');  // Recipient email address and name
		$mail->Subject = 'OTP';  // Email subject
		$mail->Body = 'This is your OTP : ' . $generate_otp;  // Email body content

		// Send the email
		if ($mail->send()) {
		// echo 'Email sent successfully.';
		} 
		else {
			echo 'Error sending email: ' . $mail->ErrorInfo;
		}

		//Time
		$selectedTime = date("H:i:s");
		$endTime = strtotime("+1 minutes", strtotime($selectedTime));
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