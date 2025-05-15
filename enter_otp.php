<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
   
    $enteredOTP = $_POST['otp'];

    
    $name = $_SESSION['name'];
    $storedOTP = $_SESSION['otp'];
    $email = $_SESSION['email'];

    
    if ($enteredOTP == $storedOTP) {
        

       
        $servername = "localhost";
        $username = "root"; 
        $password = ""; 
        $dbname = "restuarent_data"; 

       
        $conn = new mysqli($servername, $username, $password, $dbname);

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $sql = "SELECT * FROM datatable WHERE Email_Id = '$email' AND Name = '$name'";
        $result = $conn->query($sql);

        
        if ($result->num_rows > 0) {
            echo "<div style='text-align: center;'><h1><strong>Good Restaurant</strong></h1></div>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<p></p>";
                echo "<p>Below are the details of your upcoming Appointment</p>";
                echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
                echo "<p><strong>Name:</strong> " . $row["Name"] . "</p>";
                echo "<p><strong>Email:</strong> " . $row["Email_Id"] . "</p>";
                echo "<p><strong>Phone:</strong> " . $row["Phone"] . "</p>";
                echo "<p><strong>Date:</strong> " . $row["Date"] . "</p>";
                echo "<p><strong>Time:</strong> " . $row["Time"] . "</p>";
                echo "<p><strong>Total Persons:</strong> " . $row["Total_persons"] . "</p>";
                echo "<button onclick='rescheduleAppointment()'  class='action-button' style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;'>Reschedule Appointment</button>";
                echo "<button onclick='printDetails()' class='action-button'  style='background-color: #008CBA; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; margin-left: 10px;'>Print Details</button>";
                echo "</div>";
            }
        } else {
            echo "<div style='text-align: center;'><p>Oops!You dont have any appointments.</p></div>";
        }

        
        $conn->close();
    } else {
        
        echo "Incorrect OTP. Please try again.";
    }
} else {
    
    header("Location: enter_otp.php");
    exit;
}
?>

<script>
    function rescheduleAppointment() {
        
        window.location.href = "rescheduling.html";
    }

    function printDetails() {
        window.print(); 
    }
</script>

<style>
    body {
        background-color: #f5f5dc; 
        color: #333333;
    }

    @media print {
        .action-button {
            display: none;
        }
    }
</style>
