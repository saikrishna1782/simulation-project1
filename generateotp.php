<?php
session_start(); 


$name = $_POST['name'];
$email = $_POST['email'];


$servername = "localhost";
$username = "root";
$password = "";
$database = "restuarent_data"; 
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM datatable WHERE Name = '$name' AND Email_Id = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address. Please provide a valid email.");
    }

    
    $otp = mt_rand(100000, 999999); 

    
    $to = $email;
    $subject = "OTP for Login";
    $message = "Your OTP for login is: $otp";
    $headers = "From: kasarapukrishna98@gmail.com"; 

    
    $mailSent = mail($to, $subject, $message, $headers);

    if (!$mailSent) {
        die("Failed to send OTP. Please try again later."); 
    }

   
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['name']= $name;

    
    header("Location: send_otp_cancel.php");
    exit();
} else {
    
    echo '<script>alert("Invalid user details."); window.location.href = "login2_form.html";</script>';
}

$conn->close();
?>
