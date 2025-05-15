<?php
session_start(); 

if(isset($_POST['otp'])) {
   
    $enteredOTP = $_POST['otp'];

   
    $storedOTP = $_SESSION['otp'];
    $email=$_SESSION['email'];
    $name=$_SESSION['name'];

    
    if($enteredOTP == $storedOTP) {
        
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
            
            $sql_delete = "DELETE FROM datatable WHERE Name = '$name' AND Email_Id = '$email'";
            if ($conn->query($sql_delete) === TRUE) {
                
                $to = $email;
                $subject = "Reservation Cancellation";
                $message = "Hello, Your upcoming reservation has been cancelled.\nName: $name\nEmail: $email";
                $headers = "From: kasarapukrishna98@gmail.com"; 
                mail($to, $subject, $message, $headers);

                
                $owner_email = "kasarapukrishna98@gmail.com";
                $owner_subject = "Appointment Cancelled";
                $owner_message = "Hello, The appointment for $name has been cancelled.\nName: $name\nEmail: $email";
                $owner_headers = "From: $email"; // Use customer's email as the sender
                mail($owner_email, $owner_subject, $owner_message, $owner_headers);

                
                echo '<div style="color: black; text-align: center; padding: 400px;">Your Appointment has been Cancelled.</div>';
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        } else {
            echo '<div style="color: bronze; text-align: center; padding: 350px;"><h4>You dont have any appointments</h4>.</div>';
        }

        $conn->close();
    } else {
        
        echo '<script>alert("Please enter correct OTP."); window.location.href = "login2_form.html";</script>';
    }
} else {
   
    echo '<script>alert("Please enter OTP."); window.location.href = "login_page.php";</script>';
}
?>
