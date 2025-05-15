<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0fff0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message {
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
         .back-link {
            position: absolute;
            top: 10px;
            left: 10px; 
        }
    </style>
</head>
<body>
    <div class="message">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
           
            $servername = "localhost";
            $username = "root"; 
            $password = "";
            $dbname = "restuarent_data";

            
            $conn = new mysqli($servername, $username, $password, $dbname);

            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

           
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $selected_person = $_POST['person1'];
            $slot_time = $_POST['person'];
            $date = $_POST['reservation-date'];

            
            $sql = "INSERT INTO datatable (Name, Phone, Email_Id, Total_persons, Time, Date) VALUES ('$name', '$phone', '$email', '$selected_person', '$slot_time', '$date')";
	
            if ($conn->query($sql) === TRUE) {
                echo "Congratulations! Your appointment has been confirmed.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            
            $conn->close();

            
            $to_email = $_POST['email'];
            $from_email = "kasarapukrishna98@gmail.com"; 

            
            $subject_recipient = "Appointment booking details";
            $body_recipient = " Dear $name,\nThank you for booking the table at our restaurent,Please check your appointment details here:\nName:    $name\nPhone:    $phone\nEmail:    $to_email\nNo.of persons:    $selected_person\nSlot time:    $slot_time\nReservation Date:    $date";
            $headers_recipient = "From: $from_email";

            
            $subject_sender = "A new Appointment booked";
            $body_sender = "Hello, a table has been reserved,here are the details:\n\nName:    $name\nPhone:    $phone\nEmail:    $to_email\nNo.of persons:    $selected_person\nSlot time:    $slot_time\nReservation Date:    $date\n\nRegards,\nRestaurant";
            $headers_sender = "From: $to_email";

            
            if (mail($to_email, $subject_recipient, $body_recipient, $headers_recipient)) {
                // echo "Data successfully sent to $to_email...<br>";
            } else {
                // echo "Data sending failed...<br>";
            }

            
            if (mail($from_email, $subject_sender, $body_sender, $headers_sender)) {
                // echo "Confirmation email sent to $from_email...";
            } else {
                // echo "Confirmation email sending failed...";
            }
        } else {
            echo "Method not allowed.";
        }
        ?>
    </div>
    <a href="index1.html" class="back-link">back</a> 
</body>
</html>
