<!DOCTYPE html>
<html>
<head>
    <title>Reservation System</title>
    <style>
       body {
        background-color: #d4edda; 
        font-family: Arial, sans-serif; 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        height: 100vh; 
    }
    .message-box {
        background-color: #d4edda; 
        color: #155724; 
        padding: 20px; 
        display: inline-block; 
        border-radius: 5px;
    }
    </style>
</head>
<body>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "restuarent_data"; 
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['update'])){
    
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $persons = $_POST['person1'];
    $reservationDate = $_POST['reservation-date'];
    $reservationTime = $_POST['person'];

    
    $sql = "SELECT * FROM datatable WHERE Name = '$name' AND Phone = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $sql_update = "UPDATE datatable SET Email_id='$email', Total_persons='$persons', Date='$reservationDate', Time='$reservationTime' WHERE Name='$name' AND Phone='$phone'";
        if ($conn->query($sql_update) === TRUE) {
            
            $to = $email;
            $subject = "Reservation Details Updated";
            $message = "Hello, Your appointment has been updated.\nName: $name\nPhone: $phone\nEmail: $email\nPersons: $persons\nReservation Date: $reservationDate\nReservation Time: $reservationTime";
            $headers = "From: kasarapukrishna98@gmail.com"; 
            mail($to, $subject, $message, $headers);

           
            $owner_email = "kasarapukrishna98@gmail.com";
            $owner_subject = "Appointment Rescheduled";
            $owner_message = "Hello, The appointment for $name has been rescheduled.\nName: $name\nPhone: $phone\nEmail: $email\nPersons: $persons\nReservation Date: $reservationDate\nReservation Time: $reservationTime";
            $owner_headers = "From: $email";
            mail($owner_email, $owner_subject, $owner_message, $owner_headers);

            
            echo '<div class="message-box">Congratulations!Your Appointment has been Rescheduled.</div>';
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Record not found in the database.";
    }
} elseif(isset($_POST['delete'])){
    
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    
    $sql = "SELECT * FROM datatable WHERE Name = '$name' AND Phone = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $sql_delete = "DELETE FROM datatable WHERE Name = '$name' AND Phone = '$phone'";
        if ($conn->query($sql_delete) === TRUE) {
            
            $to = $email;
            $subject = "Reservation Cancellation";
            $message = "Hello, Your reservation has been cancelled.\nName: $name\nPhone: $phone\nEmail: $email";
            $headers = "From: kasarapukrishna98@gmail.com"; 
            mail($to, $subject, $message, $headers);

            
            $owner_email = "kasarapukrishna98@gmail.com";
            $owner_subject = "Appointment Cancelled";
            $owner_message = "Hello, The appointment for $name has been cancelled.\nName: $name\nPhone: $phone\nEmail: $email";
            $owner_headers = "From: $email"; 
            mail($owner_email, $owner_subject, $owner_message, $owner_headers);

            
            echo '<div class="message-box">Your Appointment has been Cancelled.</div>';
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Record not found in the database.";
    }
}

$conn->close();
?>

</body>
</html>
