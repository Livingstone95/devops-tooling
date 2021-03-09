<?php 
include('db_conn.php');

if (isset($_POST['reset-password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  // ensure that the user exists on our system
  $query = "SELECT email FROM users WHERE email='$email'";
  $results = mysqli_query($db, $query);

  if (empty($email)) {
    array_push($errors, "Your email is required");
  }else if(mysqli_num_rows($results) <= 0) {
    array_push($errors, "Sorry, no user exists on our system with that email");
  }
  // generate a unique random token of length 100
  $token = bin2hex(random_bytes(50));

  if (count($errors) == 0) {
    // store token in the password-reset database table against the user's email
    $sql = "INSERT INTO password_reset(email, token) VALUES ('$email', '$token')";
    $results = mysqli_query($db, $sql);

    // Send email to user with the token in a link they can click on
    $to = $email;
    $subject = "Reset your password on examplesite.com";
    $msg = "Hi there, click on this <a href=\"new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
    $msg = wordwrap($msg,70);
    $headers = "From: info@examplesite.com";
    mail($to, $subject, $msg, $headers);
    header('location: pending.php?email=' . $email);
  }
}

// if (isset($_POST['new_password'])) {
//   $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
//   $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);

//   // Grab to token that came from the email link
//   $token = $_SESSION['token'];
//   if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
//   if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");
//   if (count($errors) == 0) {
//     // select email address of user from the password_reset table 
//     $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
//     $results = mysqli_query($db, $sql);
//     $email = mysqli_fetch_assoc($results)['email'];

//     if ($email) {
//       $new_pass = md5($new_pass);
//       $sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
//       $results = mysqli_query($db, $sql);
//       header('location: index.php');
//     }
//   }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/register.css">
	<link href='https://fonts.googleapis.com/css?family=IBM Plex Mono' rel='stylesheet'>
	
	<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>  
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
</head>
<style >
	h2.form-title {
	text-align: center;
}
form.login-form {
    padding: 30px;
    text-align: center;
}
input {
	display: block;
	box-sizing: border-box;
	width: 100%;
	padding: 8px;
	height: 60px;
    border: 1px solid #E5E5E5;
    box-sizing: border-box;
    border-radius: 7px;
    margin: 14px 0;
}
.register-sec {
    max-width: 775px;
     height: max-content; 
    margin: 0 auto;
    width: 100%;
    box-shadow: 0px 0px 20px rgb(0 0 0 / 15%);
}
</style>
<body>
	<div class="main-content">
		<div class="container">
	<div class="register-sec">
	<form class="login-form" action="forgot_pass.php" method="post">
		<h2 class="form-title">Reset password</h2>
		<!-- form validation messages -->
		
		<div class="form-group">
			<label>Your email address</label>
			<input type="password" name="new_pass">
		</div>
		<div class="form-group submit-btn ">
			<input  type="submit" name="reset-password" class="login-btn" value="Reset Password">
		</div>
	</form>
</div>
</div>
</div>
</body>
</html>