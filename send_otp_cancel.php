<?php
session_start(); 

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];



 $email=$_SESSION['email'];
 $name=$_SESSION['name'];


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address. Please provide a valid email.");
}


$otp = mt_rand(100000, 999999); 

// Send OTP via email
$to = $email;
$subject = "OTP for Login";
$message = "Your OTP for login is: $otp";
$headers = "From: kasarapukrishna98@gmail.com"; 
// Send email
$mailSent = mail($to, $subject, $message, $headers);

if (!$mailSent) {
    die("Failed to send OTP. Please try again later."); 
}


$_SESSION['otp'] = $otp;
$_SESSION['email'] = $email;
$_SESSION['name']= $name;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Enter OTP</title>
<style>
    body {
        font-family: Arial, sans-serif;
        #background-color: #f4f4f4;
	background-color:#0C0C0C;
    }
    .container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        #background: #fff;
	background-color: hsl(32, 74%, 41%);
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"], input[type="email"], input[type="submit"], input[type="reset"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
	input[type="submit"] {
   background-color:hsl(38, 61%, 73%);
    }
</style>
</head>
<body>

<div class="container">
    <h2>Enter OTP</h2>
    <form action="update_delete_otp.php" method="post">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <div id="otpError" class="error"></div>
        
        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>
